<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KnowledgeSharing;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class KnowledgeSharingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedSeason = $request->get('season_id') ?? Season::getActiveSeason()?->id;
        $season = Season::with('knowledgeSharings')->find($selectedSeason);
        $knowledgeSharings = $season ? $season->knowledgeSharings : collect();
        return view('admin.knowledge-sharings.index', compact('knowledgeSharings', 'selectedSeason'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.knowledge-sharings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'title' => 'required|string|max:255',
            'overview' => 'required|string',
            'description' => 'required|string',
            'collaterals' => 'nullable|array',
            'collaterals.*' => 'file|max:10240'
        ]);

        $activeSeason = Season::getActiveSeason();
        if (!$activeSeason) {
            return back()->with('error', 'No active season found.');
        }

        try {
            // Handle Thumbnail Upload
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $uniqueFileName = 'thumbnail-' . Str::uuid() . '.webp';
                $thumbnailPath = "files/knowledge-sharings/thumbnails/{$uniqueFileName}";
                $image = (new ImageManager(new Driver()))
                    ->read($request->file('thumbnail')->getRealPath())
                    ->toWebp(80);
                Storage::disk('public')->put($thumbnailPath, $image);
            }

            // Handle Collateral Uploads
            $collateralPaths = [];
            if ($request->hasFile('collaterals')) {
                foreach ($request->file('collaterals') as $file) {
                    $uniqueFileName = 'collateral-' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $collateralPath = "files/knowledge-sharings/collaterals/{$uniqueFileName}";
                    Storage::disk('public')->put($collateralPath, file_get_contents($file));
                    $collateralPaths[] = $collateralPath;
                }
            }

            $knowledgeSharing = KnowledgeSharing::create([
                'thumbnail' => $thumbnailPath,
                'title' => $request->title,
                'overview' => $request->overview,
                'description' => $request->description,
                'collaterals' => $collateralPaths
            ]);

            $knowledgeSharing->seasons()->attach($activeSeason->id);

            return redirect()->route('knowledge-sharings.index')
                ->with('success', 'Knowledge sharing created successfully.');
        } catch (\Exception $e) {
            // Clean up uploaded files if there's an error
            if (isset($thumbnailPath) && Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
            if (!empty($collateralPaths)) {
                foreach ($collateralPaths as $path) {
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }
            return back()->with('error', 'Failed to create knowledge sharing.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(KnowledgeSharing $knowledgeSharing)
    {
        return view('admin.knowledge-sharings.show', compact('knowledgeSharing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KnowledgeSharing $knowledgeSharing)
    {
        return view('admin.knowledge-sharings.edit', compact('knowledgeSharing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KnowledgeSharing $knowledgeSharing)
    {
        $request->validate([
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'title' => 'required|string|max:255',
            'overview' => 'required|string',
            'description' => 'required|string',
            'collaterals' => 'nullable|array',
            'collaterals.*' => 'file|max:10240',
            'existing_collaterals' => 'nullable|string'
        ]);

        try {
            // Handle Thumbnail Upload
            $thumbnailPath = $knowledgeSharing->thumbnail;
            if ($request->hasFile('thumbnail')) {
                if ($knowledgeSharing->thumbnail && Storage::disk('public')->exists($knowledgeSharing->thumbnail)) {
                    Storage::disk('public')->delete($knowledgeSharing->thumbnail);
                }

                $uniqueFileName = 'thumbnail-' . Str::uuid() . '.webp';
                $thumbnailPath = "files/knowledge-sharings/thumbnails/{$uniqueFileName}";
                $image = (new ImageManager(new Driver()))
                    ->read($request->file('thumbnail')->getRealPath())
                    ->toWebp(80);
                Storage::disk('public')->put($thumbnailPath, $image);
            }

            // Handle Collateral Uploads
            $collateralPaths = [];

            // Handle existing collaterals that weren't removed
            if ($request->has('existing_collaterals')) {
                $existingCollaterals = json_decode($request->existing_collaterals, true) ?? [];
                $collateralPaths = array_merge($collateralPaths, $existingCollaterals);
            }

            // Handle new collateral uploads
            if ($request->hasFile('collaterals')) {
                foreach ($request->file('collaterals') as $file) {
                    $uniqueFileName = 'collateral-' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $collateralPath = "files/knowledge-sharings/collaterals/{$uniqueFileName}";
                    Storage::disk('public')->put($collateralPath, file_get_contents($file));
                    $collateralPaths[] = $collateralPath;
                }
            }

            // Delete removed collaterals
            if ($knowledgeSharing->collaterals) {
                foreach ($knowledgeSharing->collaterals as $oldCollateral) {
                    if (!in_array($oldCollateral, $collateralPaths) && Storage::disk('public')->exists($oldCollateral)) {
                        Storage::disk('public')->delete($oldCollateral);
                    }
                }
            }

            $knowledgeSharing->update([
                'thumbnail' => $thumbnailPath,
                'title' => $request->title,
                'overview' => $request->overview,
                'description' => $request->description,
                'collaterals' => $collateralPaths
            ]);

            return redirect()->route('knowledge-sharings.index')
                ->with('success', 'Knowledge sharing updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update knowledge sharing.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KnowledgeSharing $knowledgeSharing)
    {
        if ($knowledgeSharing->thumbnail) {
            Storage::disk('public')->delete($knowledgeSharing->thumbnail);
        }

        $knowledgeSharing->delete();

        return redirect()->route('knowledge-sharings.index')
            ->with('success', 'Knowledge sharing deleted successfully.');
    }
}

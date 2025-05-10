<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Startup;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class StartupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedSeason = $request->get('season_id') ?? Season::getActiveSeason()?->id;
        $season = Season::with('startups')->find($selectedSeason);
        $startups = $season ? $season->startups : collect();
        return view('admin.startups.index', compact('startups', 'selectedSeason'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.startups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'bio' => 'required|string',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'pincode' => 'required|string|max:20',
            'address' => 'required|string',
            'year' => 'required|numeric|digits:4',
            'type' => 'required|string',
            'industry' => 'required|string',
            'size' => 'required|string',
            'revenue' => 'required|string',
            'pocs' => 'required|array|min:1',
            'pocs.0.name' => 'required|string|max:255',
            'pocs.0.designation' => 'required|string|max:255',
            'pocs.0.email' => 'required|email|max:255',
            'pocs.0.phone' => 'required|string|max:20',
            'pocs.*.name' => 'nullable|string|max:255',
            'pocs.*.designation' => 'nullable|string|max:255',
            'pocs.*.email' => 'nullable|email|max:255',
            'pocs.*.phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'collaterals' => 'nullable|array',
            'collaterals.*' => 'file|max:10240'
        ]);

        $activeSeason = Season::getActiveSeason();
        if (!$activeSeason) {
            $this->alert('No active season found.', 'error');
            return back();
        }

        try {
            // Handle Logo Upload
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $uniqueFileName = 'logo-' . Str::uuid() . '.webp';
                $logoPath = "files/startups/logo/{$uniqueFileName}";
                $image = (new ImageManager(new Driver()))->read($request->file('logo')->getRealPath())->toWebp(80);
                Storage::disk('public')->put($logoPath, $image);
            }

            // Handle Collateral Uploads
            $collateralPaths = [];
            if ($request->hasFile('collaterals')) {
                foreach ($request->file('collaterals') as $file) {
                    $uniqueFileName = 'collateral-' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $collateralPath = "files/startups/collaterals/{$uniqueFileName}";
                    Storage::disk('public')->put($collateralPath, file_get_contents($file));
                    $collateralPaths[] = $collateralPath;
                }
            }

            // Filter out empty POCs
            $pocs = array_filter($request->pocs, function ($poc) {
                return !empty($poc['name']);
            });

            $startup = Startup::create([
                'name' => $request->name,
                'bio' => $request->bio,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'pincode' => $request->pincode,
                'address' => $request->address,
                'year' => $request->year,
                'type' => $request->type,
                'industry' => $request->industry,
                'size' => $request->size,
                'revenue' => $request->revenue,
                'pocs' => array_values($pocs),
                'website' => $request->website,
                'linkedin' => $request->linkedin,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'logo' => $logoPath,
                'collaterals' => $collateralPaths
            ]);

            $startup->seasons()->attach($activeSeason->id);
            $startup->users()->attach(auth()->id());

            return redirect()->route('startups.index')->with('success', 'Startup created successfully.');
        } catch (\Exception $e) {
            // If there's an error, clean up any uploaded files
            if (isset($logoPath) && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
            if (!empty($collateralPaths)) {
                foreach ($collateralPaths as $path) {
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }

            $this->alert('Failed to add startup.', 'error');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Startup $startup)
    {
        return view('admin.startups.show', compact('startup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Startup $startup)
    {
        return view('admin.startups.edit', compact('startup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Startup $startup)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'bio' => 'required|string',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'pincode' => 'required|string|max:20',
            'address' => 'required|string',
            'year' => 'required|numeric|digits:4',
            'type' => 'required|string',
            'industry' => 'required|string',
            'size' => 'required|string',
            'revenue' => 'required|string',
            'pocs' => 'required|array|min:1',
            'pocs.0.name' => 'required|string|max:255',
            'pocs.0.designation' => 'required|string|max:255',
            'pocs.0.email' => 'required|email|max:255',
            'pocs.0.phone' => 'required|string|max:20',
            'pocs.*.name' => 'nullable|string|max:255',
            'pocs.*.designation' => 'nullable|string|max:255',
            'pocs.*.email' => 'nullable|email|max:255',
            'pocs.*.phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'collaterals' => 'nullable|array',
            'collaterals.*' => 'file|max:10240',
            'existing_collaterals' => 'nullable|string'
        ]);

        try {
            // Handle Logo Upload
            $logoPath = $startup->logo;
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($startup->logo && Storage::disk('public')->exists($startup->logo)) {
                    Storage::disk('public')->delete($startup->logo);
                }

                $uniqueFileName = 'logo-' . Str::uuid() . '.webp';
                $logoPath = "files/startups/logo/{$uniqueFileName}";
                $image = (new ImageManager(new Driver()))->read($request->file('logo')->getRealPath())->toWebp(80);
                Storage::disk('public')->put($logoPath, $image);
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
                    $collateralPath = "files/startups/collaterals/{$uniqueFileName}";
                    Storage::disk('public')->put($collateralPath, file_get_contents($file));
                    $collateralPaths[] = $collateralPath;
                }
            }

            // Delete removed collaterals
            if ($startup->collaterals) {
                foreach ($startup->collaterals as $oldCollateral) {
                    if (!in_array($oldCollateral, $collateralPaths) && Storage::disk('public')->exists($oldCollateral)) {
                        Storage::disk('public')->delete($oldCollateral);
                    }
                }
            }

            // Filter out empty POCs
            $pocs = array_filter($request->pocs, function ($poc) {
                return !empty($poc['name']);
            });

            $startup->update([
                'name' => $request->name,
                'bio' => $request->bio,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'pincode' => $request->pincode,
                'address' => $request->address,
                'year' => $request->year,
                'type' => $request->type,
                'industry' => $request->industry,
                'size' => $request->size,
                'revenue' => $request->revenue,
                'pocs' => array_values($pocs),
                'website' => $request->website,
                'linkedin' => $request->linkedin,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'logo' => $logoPath,
                'collaterals' => $collateralPaths
            ]);

            $this->alert('Startup updated successfully', 'success');
            return redirect()->route('startups.index');
        } catch (\Exception $e) {
            $this->alert('Failed to update startup.', 'error');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Startup $startup)
    {
        //
    }
}

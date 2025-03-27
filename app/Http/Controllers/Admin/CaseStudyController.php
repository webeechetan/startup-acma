<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CaseStudyController extends Controller
{
    public function index(Request $request)
    {
        $selectedSeason = $request->get('season_id') ?? Season::getActiveSeason()?->id;
        $season = Season::with('caseStudies')->find($selectedSeason);
        $caseStudies = $season ? $season->caseStudies : collect();
        return view('admin.case-studies.index', compact('caseStudies', 'selectedSeason'));
    }

    public function create()
    {
        return view('admin.case-studies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'title' => 'required|string|max:255',
            'overview' => 'required|string',
            'description' => 'required|string'
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
                $thumbnailPath = "files/case-studies/thumbnails/{$uniqueFileName}";
                $image = (new ImageManager(new Driver()))
                    ->read($request->file('thumbnail')->getRealPath())
                    ->toWebp(80);
                Storage::disk('public')->put($thumbnailPath, $image);
            }

            $caseStudy = CaseStudy::create([
                'thumbnail' => $thumbnailPath,
                'title' => $request->title,
                'overview' => $request->overview,
                'description' => $request->description
            ]);

            $caseStudy->seasons()->attach($activeSeason->id);

            return redirect()->route('case-studies.index')
                ->with('success', 'Case study created successfully.');
        } catch (\Exception $e) {
            // Clean up uploaded file if there's an error
            if (isset($thumbnailPath) && Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }

            return back()->with('error', 'Failed to create case study.');
        }
    }


    public function show(CaseStudy $caseStudy)
    {
        //
    }

    public function edit(CaseStudy $caseStudy)
    {
        return view('admin.case-studies.edit', compact('caseStudy'));
    }

    public function update(Request $request, CaseStudy $caseStudy)
    {
        $request->validate([
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'title' => 'required|string|max:255',
            'overview' => 'required|string',
            'description' => 'required|string'
        ]);

        try {
            // Handle Thumbnail Upload
            $thumbnailPath = $caseStudy->thumbnail;
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                if ($caseStudy->thumbnail && Storage::disk('public')->exists($caseStudy->thumbnail)) {
                    Storage::disk('public')->delete($caseStudy->thumbnail);
                }

                $uniqueFileName = 'thumbnail-' . Str::uuid() . '.webp';
                $thumbnailPath = "files/case-studies/{$uniqueFileName}";
                $image = (new ImageManager(new Driver()))
                    ->read($request->file('thumbnail')->getRealPath())
                    ->toWebp(80);
                Storage::disk('public')->put($thumbnailPath, $image);
            }

            $caseStudy->update([
                'thumbnail' => $thumbnailPath,
                'title' => $request->title,
                'overview' => $request->overview,
                'description' => $request->description
            ]);

            return redirect()->route('case-studies.index')
                ->with('success', 'Case study updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update case study.');
        }
    }

    public function destroy(CaseStudy $caseStudy)
    {
        if ($caseStudy->thumbnail) {
            Storage::disk('public')->delete($caseStudy->thumbnail);
        }

        $caseStudy->delete();

        return redirect()->route('case-studies.index')
            ->with('success', 'Case study deleted successfully.');
    }
}
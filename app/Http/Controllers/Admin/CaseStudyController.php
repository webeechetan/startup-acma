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
            $this->alert('No active season found.', 'error');
            return back();
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

            $this->alert('Case study created successfully', 'success');
            return redirect()->route('case-studies.index');
        } catch (\Exception $e) {
            // Clean up uploaded file if there's an error
            if (isset($thumbnailPath) && Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }

            $this->alert('Failed to add case study.', 'error');
            return back();
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

            $this->alert('Case study updated successfully', 'success');
            return redirect()->route('case-studies.index');
        } catch (\Exception $e) {
            $this->alert('Failed to update case study.', 'error');
            return back();
        }
    }

    public function destroy(CaseStudy $caseStudy)
    {
        try {
            if ($caseStudy->thumbnail) {
                Storage::disk('public')->delete($caseStudy->thumbnail);
            }

            $caseStudy->delete();

            $this->alert('Case study deleted successfully', 'success');
            return redirect()->route('case-studies.index');
        } catch (\Exception $e) {
            $this->alert('Failed to delete case study.', 'error');
            return back();
        }
    }
}
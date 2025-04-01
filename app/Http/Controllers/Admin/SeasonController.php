<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Season;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seasons = Season::all();
        return view('admin.seasons.index', compact('seasons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.seasons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:seasons,name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        try {
            Season::where('is_active', true)->update(['is_active' => false]);

            Season::create([
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => true,
            ]);

            $this->alert('Season added successfully', 'success');

            return redirect()->route('seasons.index');
        } catch (\Exception $e) {
            $this->alert($e->getMessage(), 'error');
            return back();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Season $season)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Season $season)
    {
        return view('admin.seasons.edit', compact('season'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Season $season)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:seasons,name,' . $season->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'nullable|string',
        ]);

        try {
            if ($request->has('is_active')) {
                Season::where('is_active', true)->update(['is_active' => false]);
            }

            $season->update([
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('seasons.index')->with('success', 'Season updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update season.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Season $season)
    {
        //
    }
}

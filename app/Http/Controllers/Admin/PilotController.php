<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pilot;
use App\Models\Season;
use Illuminate\Http\Request;

class PilotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pilots = Pilot::all();
        return view('admin.pilots.index', compact('pilots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pilots_array = Pilot::pluck('name');
        $pilots = $pilots_array->mapWithKeys(fn($name) => [$name => $name]);
        return view('admin.pilots.create', compact('pilots'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pilot_names' => 'required|array',
            'pilot_names.*' => 'string',
        ]);

        try {
            $activeSeason = Season::getActiveSeason();

            if (!$activeSeason) {
                return back()->with('error', 'No active season found.');
            }

            $pilotNames = array_map('trim', $request->pilot_names);

            foreach ($pilotNames as $name) {
                if (!empty($name)) {
                    $pilot = Pilot::firstOrCreate(['name' => $name]);

                    $pilot->seasons()->syncWithoutDetaching([$activeSeason->id]);

                    $users = $pilot->users()->where('is_active', true)->pluck('id')->toArray();

                    if (!empty($users)) {
                        $activeSeason->users()->syncWithoutDetaching($users);
                    }
                }
            }

            return redirect()->route('pilots.index')->with('success', 'Companies added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add companies.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Pilot $pilot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pilot $pilot)
    {
        return view('admin.pilots.edit', compact('pilot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pilot $pilot)
    {
        $request->validate([
            'name' => 'required|string|unique:pilots,name,' . $pilot->id,
        ]);

        try {
            $pilot->update([
                'name' => $request->name,
            ]);

            return redirect()->route('pilots.index')->with('success', 'Pilot updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update pilot.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pilot $pilot)
    {
        //
    }
}

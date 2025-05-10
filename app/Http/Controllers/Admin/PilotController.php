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
    public function index(Request $request)
    {
        $selectedSeason = $request->get('season_id') ?? Season::getActiveSeason()?->id;
        $season = Season::with('pilots')->find($selectedSeason);
        $pilots = $season ? $season->pilots : collect();
        return view('admin.pilots.index', data: compact('pilots', 'selectedSeason'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pilots = Pilot::pluck('name')->toArray();
        $pilots = array_combine($pilots, $pilots);
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

        $activeSeason = Season::getActiveSeason();
        if (!$activeSeason) {
            $this->alert('No active season found.', 'error');
            return back();
        }

        try {
            $pilotNames = array_map('trim', $request->pilot_names);
            foreach ($pilotNames as $name) {
                if (!empty($name)) {
                    $pilot = Pilot::firstOrCreate(['name' => $name]);
                    $pilot->seasons()->syncWithoutDetaching([$activeSeason->id]);

                    $users = $pilot->users()->where('is_active', true)->pluck('users.id')->toArray();

                    if (!empty($users)) {
                        $activeSeason->users()->syncWithoutDetaching($users);
                    }
                }
            }

            $this->alert('Companies added successfully', 'success');
            return redirect()->route('pilots.index');
        } catch (\Exception $e) {
            $this->alert('Failed to add pilot companies.', 'error');
            return back();
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

            $this->alert('Pilot updated successfully', 'success');
            return redirect()->route('pilots.index');
        } catch (\Exception $e) {
            $this->alert('Failed to update pilot.', 'error');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pilot $pilot)
    {
        try {
            $pilot->delete();
            $this->alert('Pilot deleted successfully', 'success');
            return redirect()->route('pilots.index');
        } catch (\Exception $e) {
            $this->alert('Failed to delete pilot.', 'error');
            return back();
        }
    }
}

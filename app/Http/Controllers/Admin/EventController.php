<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Season;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $activeSeason = Season::getActiveSeason();

        if (!$activeSeason) {
            $this->alert('No active season found.', 'error');
            return redirect()->route('seasons.index');
        }

        // Get pilots and startups for the active season
        $pilots = $activeSeason->pilots()
            ->with('users')
            ->get()
            ->flatMap(function ($pilot) {
                return $pilot->users->pluck('email');
            })
            ->unique()
            ->values()
            ->toArray();

        $startups = $activeSeason->startups()
            ->with('users')
            ->get()
            ->flatMap(function ($startup) {
                return $startup->users->pluck('email');
            })
            ->unique()
            ->values()
            ->toArray();

        // Convert to email => email format
        $pilots = array_combine($pilots, $pilots);
        $startups = array_combine($startups, $startups);

        // dd($pilots, $startups);

        return view('admin.events.create', compact('pilots', 'startups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}

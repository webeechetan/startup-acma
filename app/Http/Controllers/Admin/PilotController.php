<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pilot;
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
        return view('admin.pilots.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:pilots,name',
        ]);

        try {
            Pilot::create([
                'name' => $request->name,
            ]);

            return redirect()->route('pilots.index')->with('success', 'Pilot added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add pilot.');
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
        // $pilot->delete();
        // return redirect()->route('pilots.index')->with('success', 'Pilot deleted successfully.');
    }
}

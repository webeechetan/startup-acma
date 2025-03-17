<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Season;
use App\Models\User;
use App\Models\Pilot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PilotUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('type', 'pilot')->get();
        return view('admin.pilots.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pilots = Pilot::all();
        return view('admin.pilots.users.create', compact('pilots'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'pilot_id' => 'required|exists:pilots,id',
        ]);

        try {
            $activeSeason = Season::getActiveSeason();

            if (!$activeSeason) {
                return back()->with('error', 'No active season found.');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'type' => 'pilot',
            ]);

            $user->pilots()->sync([$request->pilot_id]);

            $activeSeason->users()->syncWithoutDetaching([$user->id]);

            return redirect()->route('pilots.users.index')->with('success', 'User added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add user.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $pilots = Pilot::all();
        $selectedPilot = $user->pilots()->pluck('pilots.id')->first();

        return view('admin.pilots.users.edit', compact('user', 'pilots', 'selectedPilot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'pilot_id' => 'required|exists:pilots,id',
            'is_active' => 'nullable|string',
        ]);

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'is_active' => $request->has('is_active'),
            ]);

            $user->pilots()->sync([$request->pilot_id]);

            return redirect()->route('pilots.users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update user.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}

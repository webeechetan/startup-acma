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
    public function index(Request $request)
    {
        $selectedSeason = $request->get('season_id') ?? Season::getActiveSeason()?->id;
        $season = Season::with('users')->find($selectedSeason);
        $users = $season ? $season->users->where('type', 'pilot') : User::where('type', 'pilot')->get();
        return view('admin.pilots.users.index', compact('users', 'selectedSeason'));
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

        $activeSeason = Season::getActiveSeason();
        if (!$activeSeason) {
            $this->alert('No active season found.', 'error');
            return back();
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'type' => 'pilot',
            ]);

            $user->pilots()->sync([$request->pilot_id]);
            $activeSeason->users()->syncWithoutDetaching([$user->id]);

            $this->alert('User added successfully.', 'success');
            return redirect()->route('pilot-users.index');
        } catch (\Exception $e) {
            $this->alert('Failed to add user.', 'error');
            return back();
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

            $this->alert('User updated successfully.', 'success');
            return redirect()->route('pilot-users.index');
        } catch (\Exception $e) {
            $this->alert('Failed to update user.', 'error');
            return back();
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

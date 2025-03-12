<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pilot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'pilot_id' => 'required|exists:pilots,id',
        ]);

        try {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'type' => 'pilot',
            ]);

            // DB::table('pilot_user')->insert([
            //     'user_id' => $user->id,
            //     'pilot_id' => $validatedData['pilot_id'],
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]);

            $user->pilots()->sync($validatedData['pilot_id']);

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
        return view('admin.pilots.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}

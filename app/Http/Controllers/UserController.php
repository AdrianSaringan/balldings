<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 📋 READ - Display user list with filters and search
    public function index(Request $request)
    {
        $query = User::query();

        // ✅ Search by name, email, phone, sport, role
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('sport', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            });
        }

        // 🔍 Filter by sport or role
        if ($filter = $request->input('filter')) {
            if (in_array($filter, ['basketball', 'volleyball'])) {
                $query->where('sport', $filter);
            } elseif (in_array($filter, ['coach', 'referee', 'player'])) {
                $query->where('role', $filter);
            }
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        return view('admin.users.index', compact('users'));
    }

    // ➕ CREATE FORM
    public function create()
    {
        return view('admin.users.create');
    }

    // 💾 STORE NEW USER
    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users',
            'password'          => 'required|confirmed|min:6',
            'usertype'          => 'required|string|in:user,admin',
            'role'              => 'required|string|in:player,coach,referee',
        ]);

        User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'dob'               => $request->dob,
            'sport'             => $request->sport,
            'position'          => $request->position,
            'height'            => $request->height,
            'weight'            => $request->weight,
            'experience'        => $request->experience,
            'jersey_number'     => $request->jersey_number,
            'emergency_contact' => $request->emergency_contact,
            'password'          => Hash::make($request->password),
            'usertype'          => $request->usertype,
            'role'              => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    // 👀 PROFILE VIEW (for players, coaches, referees)
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.profile', compact('user'));
    }

    // ✏️ EDIT FORM
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // 🔁 UPDATE USER
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email,' . $user->id,
            'phone'             => 'nullable|string|max:20',
            'dob'               => 'nullable|date',
            'sport'             => 'nullable|string|max:100',
            'position'          => 'nullable|string|max:100',
            'height'            => 'nullable|numeric',
            'weight'            => 'nullable|numeric',
            'experience'        => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'jersey_number'     => 'nullable|integer',
            'role'              => 'nullable|in:player,coach,referee',
            'usertype'          => 'required|in:user,admin',
        ]);

        $user->update([
            'name'              => $request->name,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'dob'               => $request->dob,
            'sport'             => $request->sport,
            'position'          => $request->position,
            'height'            => $request->height,
            'weight'            => $request->weight,
            'experience'        => $request->experience,
            'emergency_contact' => $request->emergency_contact,
            'jersey_number'     => $request->jersey_number,
            'usertype'          => $request->usertype,
            'role'              => $request->role ?? $user->role ?? 'player',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    // ❌ DELETE USER
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}

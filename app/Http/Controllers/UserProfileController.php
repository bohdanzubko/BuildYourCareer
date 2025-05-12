<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index()
    {
        $profiles = UserProfile::with('user')->get();
        return view('admin.user_profiles.index', compact('profiles'));
    }

    public function create()
    {
        // Retrieve available jobs and users for the dropdowns
        $users = User::all();

        return view('admin.user_profiles.create',compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'avatar_url' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'company_description' => 'nullable|string',
        ]);

        UserProfile::create($validated);

        return redirect()->route('user-profiles.index')->with('success', 'User profile created successfully.');
    }

    public function edit(UserProfile $userProfile)
    {
        // Retrieve available jobs and users for the dropdowns
        $users = User::all();

        return view('admin.user_profiles.edit', compact('userProfile', 'users'));
    }

    public function update(Request $request, UserProfile $userProfile)
    {
        $validated = $request->validate([
            'avatar_url' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'company_description' => 'nullable|string',
        ]);

        $userProfile->update($validated);

        return redirect()->route('user-profiles.index')->with('success', 'User profile updated successfully.');
    }

    public function destroy(UserProfile $userProfile)
    {
        $userProfile->delete();
        return redirect()->route('user-profiles.index')->with('success', 'Profile deleted successfully');
    }
}


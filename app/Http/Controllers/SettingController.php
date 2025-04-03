<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of settings.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all settings
        $settings = Setting::all();

        // Return the settings list view
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new setting.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.settings.create');
    }

    /**
     * Store a newly created setting in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'setting_key' => 'required|string|max:100|unique:settings',
            'setting_value' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Create the setting in the database
        Setting::create($request->only(['setting_key', 'setting_value', 'description']));

        // Redirect back to the settings list with a success message
        return redirect()->route('settings.index')->with('success', 'Setting added successfully!');
    }

    /**
     * Show the form for editing the specified setting.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\View\View
     */
    public function edit(Setting $setting)
    {
        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update the specified setting in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Setting $setting)
    {
        // Validate the incoming request
        $request->validate([
            'setting_key' => 'required|string|max:100|unique:settings,setting_key,' . $setting->setting_key,
            'setting_value' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Update the setting
        $setting->update($request->only(['setting_key', 'setting_value', 'description']));

        // Redirect back to the settings list with a success message
        return redirect()->route('settings.index')->with('success', 'Setting updated successfully!');
    }

    /**
     * Remove the specified setting from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Setting $setting)
    {
        // Delete the setting
        $setting->delete();

        // Redirect back to the settings list with a success message
        return redirect()->route('settings.index')->with('success', 'Setting deleted successfully!');
    }
}

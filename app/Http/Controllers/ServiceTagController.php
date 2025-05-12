<?php

namespace App\Http\Controllers;

use App\Models\ServiceTag;
use Illuminate\Http\Request;

class ServiceTagController extends Controller
{
    public function index()
    {
        $tags = ServiceTag::all();
        return view('admin.service_tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.service_tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ServiceTag::create($request->all());

        return redirect()->route('service-tags.index')->with('success', 'Service tag created successfully');
    }

    public function edit(ServiceTag $serviceTag)
    {
        return view('admin.service_tags.edit', compact('serviceTag'));
    }

    public function update(Request $request, ServiceTag $serviceTag)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $serviceTag->update($request->all());

        return redirect()->route('service-tags.index')->with('success', 'Service tag updated successfully');
    }

    public function destroy(ServiceTag $serviceTag)
    {
        $serviceTag->delete();
        return redirect()->route('service-tags.index')->with('success', 'Service tag deleted successfully');
    }
}
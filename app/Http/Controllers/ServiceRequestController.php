<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $requests = ServiceRequest::with(['user', 'service'])->get();
        return view('admin.service_requests.index', compact('requests'));
    }

    public function create()
    {
        // Retrieve available jobs and users for the dropdowns
        $services = Service::all();
        $users = User::all();

        return view('admin.service_requests.create', compact('services', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'description' => 'required|string',
            'area' => 'required|numeric|min:0',
            'estimated_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        ServiceRequest::create($request->all());

        return redirect()->route('service-requests.index')->with('success', 'Service request created successfully');
    }

    public function edit(ServiceRequest $serviceRequest)
    {
        // Retrieve available jobs and users for the dropdowns
        $services = Service::all();
        $users = User::all();

        return view('admin.service_requests.edit', compact('services', 'users', 'serviceRequest'));
    }

    public function update(Request $request, ServiceRequest $serviceRequest)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'description' => 'required|string',
            'area' => 'required|numeric|min:0',
            'estimated_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $serviceRequest->update($request->all());

        return redirect()->route('service-requests.index')->with('success', 'Service request updated successfully');
    }

    public function destroy(ServiceRequest $serviceRequest)
    {
        $serviceRequest->delete();
        return redirect()->route('service-requests.index')->with('success', 'Service request deleted successfully');
    }
}
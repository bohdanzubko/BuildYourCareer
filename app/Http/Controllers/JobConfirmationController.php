<?php

namespace App\Http\Controllers;

use App\Models\JobConfirmation;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class JobConfirmationController extends Controller
{
    public function index()
    {
        $confirmations = JobConfirmation::with(['user', 'job'])->get();
        return view('admin.job_confirmations.index', compact('confirmations'));
    }

    public function create()
    {
        // Retrieve available jobs and users for the dropdowns
        $jobs = Job::all();
        $users = User::all();

        return view('admin.job_confirmations.create', compact('jobs', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'user_id' => 'required|exists:users,id',
            'confirmed_at' => 'nullable|date',
        ]);

        JobConfirmation::create($request->all());

        return redirect()->route('job-confirmations.index')->with('success', 'Confirmation created successfully');
    }

    public function edit(JobConfirmation $jobConfirmation)
    {        
        // Retrieve available jobs and users for the dropdowns
        $jobs = Job::all();
        $users = User::all();

        return view('admin.job_confirmations.edit', compact('jobs', 'users', 'jobConfirmation'));
    }

    public function update(Request $request, JobConfirmation $jobConfirmation)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'user_id' => 'required|exists:users,id',
            'confirmed_at' => 'nullable|date',
        ]);

        $jobConfirmation->update($request->all());

        return redirect()->route('job-confirmations.index')->with('success', 'Confirmation updated successfully');
    }

    public function destroy(JobConfirmation $jobConfirmation)
    {
        $jobConfirmation->delete();
        return redirect()->route('job-confirmations.index')->with('success', 'Confirmation deleted successfully');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\JobRequest;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class JobRequestController extends Controller
{
    /**
     * Display a listing of the job offers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $jobRequests = JobRequest::all();

        return view('admin.job_requests.index', compact('jobRequests'));
    }

    /**
     * Show the form for creating a new job offer.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $jobs = Job::all();
        $users = User::all();

        return view('admin.job_requests.create', compact('jobs', 'users'));
    }

    /**
     * Store a newly created job offer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:jobs,id',
            'status' => 'required|in:pending,viewed,approved,declined',
        ]);

        JobRequest::create($request->only(['user_id', 'job_id', 'status']));

        return redirect()->back()->with('success', 'Job offer created successfully!');
    }

    /**
     * Show the form for editing the specified job offer.
     *
     * @param  \App\Models\JobRequest  $jobRequest
     * @return \Illuminate\View\View
     */
    public function edit(JobRequest $jobRequest)
    {
        // Retrieve available jobs and users for the dropdowns
        $jobs = Job::all();
        $users = User::all();

        return view('admin.job_requests.edit', compact('jobRequest', 'jobs', 'users'));
    }

    /**
     * Update the specified job offer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobRequest  $jobRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, JobRequest $jobRequest)
    {
        // Validate the incoming request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:jobs,id',
            'status' => 'required|in:pending,viewed,approved,declined',
        ]);

        // Update the job offer
        $jobRequest->update($request->only(['user_id', 'job_id', 'status']));

        // Redirect back to the job offers list with a success message
        return redirect()->route('job_requests.index')->with('success', 'Job offer updated successfully!');
    }

    /**
     * Remove the specified job offer from storage.
     *
     * @param  \App\Models\JobRequest  $jobRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(JobRequest $jobRequest)
    {
        // Delete the job offer
        $jobRequest->delete();

        // Redirect back to the job offers list with a success message
        return redirect()->route('job_requests.index')->with('success', 'Job offer deleted successfully!');
    }
}

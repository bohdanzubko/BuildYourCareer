<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of jobs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all jobs with their related category and employer
        $jobs = Job::with(['category', 'employer'])->get();

        // Return the jobs list view
        return view('admin.jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new job.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get all categories and employers for the dropdowns
        $categories = Category::all();
        $employers = User::where('role', 'employer')->get();

        // Return the create job form view
        return view('admin.jobs.create', compact('categories', 'employers'));
    }

    /**
     * Store a newly created job in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'salary_min' => 'required|numeric',
            'salary_max' => 'required|numeric',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'employer_id' => 'required|exists:users,id',
        ]);

        // Create the job in the database
        Job::create($request->only(['title', 'description', 'salary_min', 'salary_max', 'location', 'category_id', 'employer_id']));

        // Redirect back to the job listing page with a success message
        return redirect()->route('jobs.index')->with('success', 'Job created successfully!');
    }

    /**
     * Show the form for editing the specified job.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\View\View
     */
    public function edit(Job $job)
    {
        // Get all categories and employers for the dropdowns
        $categories = Category::all();
        $employers = User::where('role', 'employer')->get();

        // Return the edit job form view
        return view('admin.jobs.edit', compact('job', 'categories', 'employers'));
    }

    /**
     * Update the specified job in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Job $job)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'salary_min' => 'required|numeric',
            'salary_max' => 'required|numeric',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'employer_id' => 'required|exists:users,id',
        ]);

        // Update the job with the new data
        $job->update($request->only(['title', 'description', 'salary_min', 'salary_max', 'location', 'category_id', 'employer_id']));

        // Redirect back to the job listing page with a success message
        return redirect()->route('jobs.index')->with('success', 'Job updated successfully!');
    }

    /**
     * Remove the specified job from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Job $job)
    {
        // Delete the job from the database
        $job->delete();

        // Redirect back to the job listing page with a success message
        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully!');
    }
}

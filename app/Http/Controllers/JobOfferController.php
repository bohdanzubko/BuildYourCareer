<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    /**
     * Display a listing of the job offers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all job offers
        $jobOffers = JobOffer::all();

        // Return the job offers list view
        return view('admin.job_offers.index', compact('jobOffers'));
    }

    /**
     * Show the form for creating a new job offer.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Retrieve available jobs and users for the dropdowns
        $jobs = Job::all();
        $users = User::all();

        return view('admin.job_offers.create', compact('jobs', 'users'));
    }

    /**
     * Store a newly created job offer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:jobs,id',
            'offer_price' => 'required|string|max:255',
        ]);

        // Create the job offer in the database
        JobOffer::create($request->only(['user_id', 'job_id', 'offer_price']));

        // Redirect back to the job offers list with a success message
        return redirect()->route('job_offers.index')->with('success', 'Job offer created successfully!');
    }

    /**
     * Show the form for editing the specified job offer.
     *
     * @param  \App\Models\JobOffer  $jobOffer
     * @return \Illuminate\View\View
     */
    public function edit(JobOffer $jobOffer)
    {
        // Retrieve available jobs and users for the dropdowns
        $jobs = Job::all();
        $users = User::all();

        return view('admin.job_offers.edit', compact('jobOffer', 'jobs', 'users'));
    }

    /**
     * Update the specified job offer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobOffer  $jobOffer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, JobOffer $jobOffer)
    {
        // Validate the incoming request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:jobs,id',
            'offer_price' => 'required|string|max:255',
        ]);

        // Update the job offer
        $jobOffer->update($request->only(['user_id', 'job_id', 'offer_price']));

        // Redirect back to the job offers list with a success message
        return redirect()->route('job_offers.index')->with('success', 'Job offer updated successfully!');
    }

    /**
     * Remove the specified job offer from storage.
     *
     * @param  \App\Models\JobOffer  $jobOffer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(JobOffer $jobOffer)
    {
        // Delete the job offer
        $jobOffer->delete();

        // Redirect back to the job offers list with a success message
        return redirect()->route('job_offers.index')->with('success', 'Job offer deleted successfully!');
    }
}

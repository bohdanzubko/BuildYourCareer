<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedback = Feedback::with(['user', 'job'])->get();
        return view('admin.feedback.index', compact('feedback'));
    }

    public function create()
    {
        // Retrieve available jobs and users for the dropdowns
        $jobs = Job::all();
        $users = User::all();

        return view('admin.feedback.create', compact('jobs', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        Feedback::create($request->all());

        return redirect()->route('feedback.index')->with('success', 'Feedback created successfully');
    }

    public function edit(Feedback $feedback)
    {
        return view('admin.feedback.edit', compact('feedback'));
    }

    public function update(Request $request, Feedback $feedback)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $feedback->update($request->all());

        return redirect()->route('feedback.index')->with('success', 'Feedback updated successfully');
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('feedback.index')->with('success', 'Feedback deleted successfully');
    }
}

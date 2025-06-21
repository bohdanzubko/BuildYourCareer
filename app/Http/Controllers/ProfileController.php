<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Job;
use App\Models\ServiceRequest;
use App\Models\Feedback;
use App\Models\JobConfirmation;
use App\Models\JobOffer;
use App\Models\JobRequest;
use App\Models\Skill;

class ProfileController extends Controller
{
    /**
     * Основна сторінка профілю користувача (універсально для робітника й роботодавця).
     */
    public function index(Request $request)
    {
        $user = $request->route('user') 
            ? \App\Models\User::findOrFail($request->route('user'))
            : $request->user();

        $profile = $user->profile;

        $categories = $user->categories ?? collect();
        $skills = $user->skills ?? collect();
        $portfolio = $profile && method_exists($profile, 'portfolio') ? $profile->portfolio : [];
        $confirmedJobs = $user->confirmedJobs ? $user->confirmedJobs()->with('job')->get()->pluck('job')->filter() : collect();
        $feedbacks = $user->feedbacksReceived ? $user->feedbacksReceived()->with(['user', 'job'])->get() : collect();
        $rating = $feedbacks->avg('rating') ?? 0;
        $reviewsCount = $feedbacks->count();
        $jobs = $user->role === 'employer' ? $user->jobs()->with('category')->get() : collect();
        $services = $user->role === 'worker' ? $user->services()->with('category')->get() : collect();

        return view('profile.index', compact(
            'user',
            'profile',
            'categories',
            'skills',
            'confirmedJobs',
            'portfolio',
            'feedbacks',
            'rating',
            'reviewsCount',
            'jobs',
            'services'
        ));
    }

    /**
     * Редагування профілю.
     */
    public function edit(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile;
        $categories = $user->categories ?? collect();

        // ВСІ можливі навички (для мультиселекту)
        $allSkills = Skill::all();

        // Вибрані користувачем навички (id)
        $userSkills = $user->skills ? $user->skills->pluck('id')->toArray() : [];

        $portfolio = $profile && method_exists($profile, 'portfolio') ? $profile->portfolio : [];

        return view('profile.edit', compact(
            'user',
            'profile',
            'categories',
            'allSkills',
            'userSkills',
            'portfolio'
        ));
    }

    /**
     * Оновлення профілю.
     */
    public function update(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile;

        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'company_description' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'bio' => 'nullable|string|max:2000',
            'avatar' => 'nullable|image|max:2048',
            'skills' => 'array',
            'skills.*' => 'integer|exists:skills,id',
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar_url'] = $path;
            if ($profile->avatar_url && Storage::disk('public')->exists($profile->avatar_url)) {
                Storage::disk('public')->delete($profile->avatar_url);
            }
        }

        $profile->update($validated);

        // ОНОВЛЕННЯ НАВИЧОК
        $user->skills()->sync($validated['skills'] ?? []);

        return redirect()->route('profile.index')->with('success', 'Профіль оновлено');
    }

    /**
     * Видалення акаунту.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Перегляд відгуків користувача.
     */
// В контролері:

    // Мої вакансії (роботодавець)
    public function jobs(Request $request): View
    {
        $user = $request->user();
        $jobs = Job::where('employer_id', $user->id)->with('category')->get();
        return view('profile.jobs.index', compact('jobs', 'user'));
    }

    // Мої послуги (worker)
    public function services(Request $request): View
    {
        $user = $request->user();
        $services = $user->services()->with('category')->get();
        return view('profile.services.index', compact('services', 'user'));
    }

    /**
     * Запропоновані вакансії для користувача.
     */
    public function suggestions(Request $request): View
    {
        $user = $request->user();
        $suggestions = Job::whereHas('skills', function ($query) use ($request) {
            $query->whereIn('skills.id', $request->user()->skills->pluck('id'));
        })->with('employer')->get();

        return view('profile.suggestions', compact('suggestions', 'user'));
    }

    // Мої відгуки
    public function myReviews(Request $request)
    {
        $user = $request->user();

        // Всі відгуки, автором яких є цей користувач
        $myFeedbacks = Feedback::with(['job', 'job.employer'])
            ->where('user_id', $user->id)
            ->get();

        return view('profile.my_reviews', compact('myFeedbacks', 'user'));
    }

    // Відгуки на вакансії (роботодавець)
    public function reviewsAboutMe(Request $request)
    {
        $user = $request->user();

        // Початкові значення
        $reviews_count = 0;
        $rating = 0;

        if ($user->role === 'worker') {
            // Всі підтверджені jobs для користувача
            $confirmedJobIds = JobConfirmation::where('user_id', $user->id)->pluck('job_id');

            // Відгуки, які отримав користувач (але не він їх залишав)
            $feedbacks = Feedback::with(['user', 'job', 'job.employer'])
                ->whereIn('job_id', $confirmedJobIds)
                ->where('user_id', '<>', $user->id)
                ->get();

            $reviews_count = $feedbacks->count();
            $rating = $feedbacks->avg('rating') ?? 0;
        }
        elseif ($user->role === 'employer') {
            // ID всіх jobs, створених користувачем
            $myJobIds = Job::where('employer_id', $user->id)->pluck('id');

            // Відгуки по цих jobs, які залишили не цей користувач
            $feedbacks = Feedback::with(['user', 'job', 'job.employer'])
                ->whereIn('job_id', $myJobIds)
                ->where('user_id', '<>', $user->id)
                ->get();

            $reviews_count = $feedbacks->count();
            $rating = $feedbacks->avg('rating') ?? 0;
        }
        elseif ($user->role === 'admin') {
            // Всі відгуки, які не він залишав
            $feedbacks = Feedback::with(['user', 'job', 'job.employer'])
                ->where('user_id', '<>', $user->id)
                ->get();

            $reviews_count = $feedbacks->count();
            $rating = $feedbacks->avg('rating') ?? 0;
        }

        return view('profile.reviews_about_me', compact('feedbacks', 'reviews_count', 'rating', 'user'));
    }


    public function myJobRequests(Request $request)
    {
        $user = $request->user();
        // Заявки, подані користувачем
        $jobRequests = JobRequest::with(['job.category', 'job.employer'])
            ->where('user_id', $user->id)
            ->get();

        return view('profile.job_requests', compact('jobRequests', 'user'));
    }

    public function jobOffersForMe(Request $request)
    {
        $user = $request->user();
        $jobOffers = JobOffer::with(['job.category', 'job.employer'])
            ->where('user_id', $user->id)
            ->get();

        return view('profile.job_offers', compact('jobOffers', 'user'));
    }

    public function confirmJobOffer(Request $request, $offerId)
    {
        $offer = JobOffer::findOrFail($offerId);

        $action = $request->input('action');
        if ($action === 'accept') {
            $offer->status = 'approved';
            $offer->save();

            // Додаємо JobConfirmation (якщо ще немає)
            JobConfirmation::firstOrCreate([
                'job_id' => $offer->job_id,
                'user_id' => $offer->user_id,
            ]);
        } elseif ($action === 'reject') {
            $offer->status = 'rejected';
            $offer->save();
        }

        return redirect()->route('profile.job_offers')->with('success', 'Статус пропозиції оновлено.');
    }

    public function jobRequestsForMyJobs(Request $request)
    {
        $user = $request->user();

        // ID всіх вакансій користувача
        $myJobIds = Job::where('employer_id', $user->id)->pluck('id');
        // Заявки на ці вакансії
        $jobRequests = JobRequest::with(['user', 'job.category'])
            ->whereIn('job_id', $myJobIds)
            ->get();

        return view('profile.job_requests_for_my_jobs', compact('jobRequests', 'user'));
    }

    public function confirmJobRequest(Request $request, $requestId)
    {
        $jobRequest = JobRequest::with('job')->findOrFail($requestId);

        $action = $request->input('action');
        if ($action === 'accept') {
            $jobRequest->status = 'approved';
            $jobRequest->save();

            // Додаємо JobConfirmation (якщо ще немає)
            JobConfirmation::firstOrCreate([
                'job_id' => $jobRequest->job_id,
                'user_id' => $jobRequest->user_id,
            ]);
        } elseif ($action === 'reject') {
            $jobRequest->status = 'rejected';
            $jobRequest->save();
        }

        return redirect()->route('profile.job_requests_for_my_jobs')->with('success', 'Статус заявки оновлено.');
    }

    public function myJobOffers(Request $request)
    {
        $user = $request->user();

        // ID всіх вакансій користувача
        $myJobIds = Job::where('employer_id', $user->id)->pluck('id');
        // Пропозиції по цих вакансіях
        $myJobOffers = JobOffer::with(['user', 'job.category'])
            ->whereIn('job_id', $myJobIds)
            ->get();

        return view('profile.my_job_offers', compact('myJobOffers', 'user'));
    }

    public function requestsForMyServices(Request $request)
    {
        $user = $request->user();

        // ID послуг, у яких користувач — виконавець (worker)
        $myServiceIds = $user->services()->pluck('services.id');

        // Заявки на ці послуги
        $serviceRequests = ServiceRequest::with(['user', 'service.category'])
            ->whereIn('service_id', $myServiceIds)
            ->get();

        return view('profile.service_requests', compact('serviceRequests', 'user'));
    }

    public function confirmServiceRequest(Request $request, $requestId)
    {
        $serviceRequest = ServiceRequest::with('service')->findOrFail($requestId);

        $action = $request->input('action');
        if ($action === 'accept') {
            $serviceRequest->status = 'in_progress';
            $serviceRequest->save();
        } elseif ($action === 'reject') {
            $serviceRequest->status = 'pending';
            $serviceRequest->save();
        }

        return redirect()->route('profile.service_requests')->with('success', 'Статус заявки оновлено.');
    }
}

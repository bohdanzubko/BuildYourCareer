<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Category;
use App\Models\Skill;
use App\Models\User;
use App\Models\JobConfirmation;
use App\Models\JobRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    // --- АДМІН-ПАНЕЛЬ ---
    public function index()
    {
        // Всі вакансії з категорією та роботодавцем
        $jobs = Job::with(['category', 'employer'])->get();
        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $categories = Category::all();
        $employers = User::where('role', 'employer')->get();
        return view('admin.jobs.create', compact('categories', 'employers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'salary_min' => 'required|numeric',
            'salary_max' => 'required|numeric',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'employer_id' => 'required|exists:users,id',
            'skills' => 'array',
            'skills.*' => 'integer|exists:skills,id',
        ]);

        $job = Job::create($validated);

        return redirect()->route('jobs.index')->with('success', 'Вакансію створено!');
    }

    public function edit(Job $job)
    {
        $categories = Category::all();
        $employers = User::where('role', 'employer')->get();
        $allSkills = Skill::all();
        $jobSkills = $job->skills ? $job->skills->pluck('id')->toArray() : [];
        return view('admin.jobs.edit', compact('job', 'categories', 'employers', 'allSkills', 'jobSkills'));
    }

    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'salary_min' => 'required|numeric',
            'salary_max' => 'required|numeric',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'employer_id' => 'required|exists:users,id',
            'skills' => 'array',
            'skills.*' => 'integer|exists:skills,id',
        ]);

        $job->update($validated);

        // Оновлення навичок
        if (isset($validated['skills'])) {
            $job->skills()->sync($validated['skills']);
        }

        return redirect()->route('jobs.index')->with('success', 'Вакансію оновлено!');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Вакансію видалено!');
    }

    // --- ПУБЛІЧНА ЧАСТИНА (роботодавець) ---
    public function createPublic()
    {
        $user = Auth::user();
        $categories = Category::all();
        $allSkills = Skill::all();
        return view('profile.jobs.create', compact('user', 'categories', 'allSkills'));
    }

    public function storePublic(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'salary_min' => 'required|numeric',
            'salary_max' => 'required|numeric',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'skills' => 'array',
            'skills.*' => 'integer|exists:skills,id',
        ]);

        // Створення вакансії, employer_id - сам поточний користувач
        $job = Job::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'salary_min' => $validated['salary_min'],
            'salary_max' => $validated['salary_max'],
            'location' => $validated['location'],
            'category_id' => $validated['category_id'],
            'employer_id' => $user->id,
        ]);

        if (!empty($validated['skills'])) {
            $job->skills()->sync($validated['skills']);
        }

        return redirect()->route('profile.jobs')->with('success', 'Вакансію створено!');
    }

    public function editPublic(Job $job)
    {
        $user = Auth::user();
        if ($job->employer_id !== $user->id && $user->role !== 'admin') {
            abort(403);
        }
        $categories = Category::all();
        $allSkills = Skill::all();
        $jobSkills = $job->skills ? $job->skills->pluck('id')->toArray() : [];
        return view('profile.jobs.edit', compact('job', 'categories', 'allSkills', 'jobSkills', 'user'));
    }

    public function updatePublic(Request $request, Job $job)
    {
        $user = Auth::user();
        if ($job->employer_id !== $user->id && $user->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'salary_min' => 'required|numeric',
            'salary_max' => 'required|numeric',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'skills' => 'array',
            'skills.*' => 'integer|exists:skills,id',
        ]);

        $job->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'salary_min' => $validated['salary_min'],
            'salary_max' => $validated['salary_max'],
            'location' => $validated['location'],
            'category_id' => $validated['category_id'],
        ]);

        if (isset($validated['skills'])) {
            $job->skills()->sync($validated['skills']);
        }

        return redirect()->route('profile.jobs')->with('success', 'Вакансію оновлено!');
    }

    public function destroyPublic(Job $job)
    {
        $user = Auth::user();
        if ($job->employer_id !== $user->id && $user->role !== 'admin') {
            abort(403);
        }
        $job->delete();
        return redirect()->route('profile.jobs')->with('success', 'Вакансію видалено!');
    }

    // --- ПУБЛІЧНА ЧАСТИНА (робітники) ---
    public function publicIndex(Request $request)
    {
        $query = Job::with(['category', 'skills', 'employer']);

        // Фільтр за категорією (?category=ID)
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Фільтр за навичкою (?skill=ID)
        if ($request->filled('skill')) {
            $query->whereHas('skills', function($q) use ($request) {
                $q->where('skills.id', $request->input('skill'));
            });
        }

        // Пошук по назві або опису (?search=...)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'ILIKE', "%$search%")
                  ->orWhere('description', 'ILIKE', "%$search%");
            });
        }

        // Сортування (останнє додане перше)
        $query->orderByDesc('created_at');

        // Пагінація (12 на сторінку)
        $jobs = $query->paginate(12)->withQueryString();

        // Для фільтрів
        $categories = Category::all();
        $skills = Skill::all();

        return view('jobs.index', compact('jobs', 'categories', 'skills'));
    }

    public function show(Job $job, Request $request)
    {
        $job->load(['category', 'skills', 'employer', 'feedbacks']);

        $alreadyRequested = false;
        $isConfirmed = false;

        // Якщо користувач авторизований і має роль worker
        if ($request->user() && $request->user()->role === 'worker') {
            // Перевіряємо, чи вже подана заявка на цю вакансію
            $alreadyRequested = JobRequest::where('job_id', $job->id)
                ->where('user_id', $request->user()->id)
                ->exists();

            // Перевіряємо, чи користувач підтверджений для цієї вакансії
            $isConfirmed = JobConfirmation::where('job_id', $job->id)
                ->where('user_id', $request->user()->id)
                ->exists();
        }

        return view('jobs.show', compact('job', 'alreadyRequested', 'isConfirmed'));
    }
}

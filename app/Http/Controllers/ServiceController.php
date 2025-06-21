<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use App\Models\ServiceRequest;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * --- АДМІН-ПАНЕЛЬ ---
     * Всі стандартні CRUD-операції для ресурсу Service (адмін)
     */
    public function index()
    {
        // Для адмін-панелі: список усіх послуг
        $services = Service::with('category', 'skills', 'tags')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        // Для адмін-панелі: форма створення послуги
        $categories = Category::all();
        return view('admin.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Для адмін-панелі
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        Service::create($validated);

        return redirect()->route('services.index')->with('success', 'Послугу створено!');
    }

    public function edit(Service $service)
    {
        // Для адмін-панелі: форма редагування
        $categories = Category::all();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        // Для адмін-панелі
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $service->update($validated);

        return redirect()->route('services.index')->with('success', 'Послугу оновлено!');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Послугу видалено!');
    }

    /**
     * --- ПУБЛІЧНА ЧАСТИНА (worker/employer) ---
     */
    public function createPublic()
    {
        $user = Auth::user();
        $categories = Category::all();
        $skills = Skill::all();
        return view('profile.services.create', compact('user', 'categories', 'skills'));
    }
    public function storePublic(Request $request)
    {
        $user = $request->user();

        // Валідація
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'skills' => 'array',
            'skills.*' => 'integer|exists:skills,id',
            'tags' => 'nullable|string',
        ]);

        // Створюємо нову послугу
        $service = Service::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
        ]);

        // Прив'язуємо послугу до користувача
        $user->services()->attach($service->id);

        // Додаємо навички до послуги (many-to-many)
        if (!empty($validated['skills'])) {
            $service->skills()->sync($validated['skills']);
        }

        // Додаємо теги (рядок через кому)
        if (!empty($validated['tags'])) {
            $tags = collect(explode(',', $validated['tags']))
                ->map(fn($tag) => trim($tag))
                ->filter()
                ->unique();
            // Приклад збереження тегів (псевдокод, залежить від моделі)
            foreach ($tags as $tagName) {
                $tag = \App\Models\ServiceTag::firstOrCreate(['name' => $tagName]);
                $service->tags()->attach($tag->id);
            }
        }

        return redirect()->route('profile.services')->with('success', 'Послугу створено!');
    }

    public function editPublic(Service $service)
    {
        $user = Auth::user();
        // Перевіряємо, чи це його послуга (або він адмін)
        if ($service->user_id !== $user->id && $user->role !== 'admin') {
            abort(403);
        }
        $categories = Category::all();
        $skills = Skill::all();
        return view('profile.services.edit', compact('service', 'categories', 'skills', 'user'));
    }

    public function updatePublic(Request $request, Service $service)
    {
        $user = Auth::user();
        if ($service->user_id !== $user->id && $user->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'skills' => 'array',
            'tags' => 'nullable|string',
        ]);
        $service->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
        ]);

        if (!empty($validated['skills'])) {
            $service->skills()->sync($validated['skills']);
        }

        // ОНОВЛЕННЯ ТЕГІВ:
        if (isset($validated['tags'])) {
            $tags = collect(explode(',', $validated['tags']))
                ->map(fn($tag) => trim($tag))
                ->filter()
                ->unique();

            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = \App\Models\ServiceTag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $service->tags()->sync($tagIds);
        }

        return redirect()->route('profile.services')->with('success', 'Послугу оновлено!');
    }

    public function destroyPublic(Service $service)
    {
        $user = Auth::user();
        if ($service->user_id !== $user->id && $user->role !== 'admin') {
            abort(403);
        }
        $service->delete();
        return redirect()->route('profile.services')->with('success', 'Послугу видалено!');
    }

    /**
     * --- ПУБЛІЧНА ЧАСТИНА ---
     * Каталог послуг для всіх користувачів (фільтрація, пагінація)
     */
    public function publicIndex(Request $request)
    {
        // Додаємо фільтрацію за категорією, тегами, навичками
        $query = Service::with(['category', 'skills', 'tags', 'users']);

        // Фільтр за категорією (через параметр ?category=ID)
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Фільтр за навичкою (?skill=ID)
        if ($request->filled('skill')) {
            $query->whereHas('skills', function($q) use ($request) {
                $q->where('skills.id', $request->input('skill'));
            });
        }

        // Фільтр за тегом (?tag=назва)
        if ($request->filled('tag')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('name', $request->input('tag'));
            });
        }

        // Пошук по імені/опису (?search=...)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'ILIKE', "%$search%")
                  ->orWhere('description', 'ILIKE', "%$search%");
            });
        }

        // Сортування за датою створення (останнє перше)
        $query->orderByDesc('created_at');

        // Пагінація (12 на сторінку)
        $services = $query->paginate(12)->withQueryString();

        // Для фільтрів:
        $categories = Category::all();
        $skills = Skill::all();

        return view('services.index', compact('services', 'categories', 'skills'));
    }

    /**
     * Показати одну послугу (детальна сторінка)
     */
    public function show(Service $service, Request $request)
    {
        // Підтягуємо всі потрібні зв'язки
        $service->load(['category', 'skills', 'tags', 'users']);

        $alreadyRequested = false;

        // Якщо користувач авторизований і має роль employer
        if ($request->user() && $request->user()->role === 'employer') {
            // Перевіряємо, чи вже подана заявка на цю gjckeue
            $alreadyRequested = ServiceRequest::where('service_id', $service->id)
                ->where('user_id', $request->user()->id)
                ->exists();
        }

        return view('services.show', compact('service'));
    }
}

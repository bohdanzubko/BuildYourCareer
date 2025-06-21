<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all categories from the database
        $categories = Category::all();

        // Return the view with the categories data
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Return the view to create a new category
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        // Create the category in the database
        Category::create($request->only(['name', 'description']));

        // Redirect to the category list page
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function edit(Category $category)
    {
        // Return the edit view with the category data
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        // Update the category with the new data
        $category->update($request->only(['name', 'description']));

        // Redirect back to the category list with a success message
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        // Delete the category
        $category->delete();

        // Redirect back to the category list with a success message
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }

    public function publicIndex(Request $request)
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function show(Request $request, Category $category)
    {
        $user = $request->user();
        // За замовчуванням — якщо неавторизований, виводити все
        $role = $user ? $user->role : null;

        // Всі послуги та вакансії цієї категорії
        $jobs = $category->jobs()->with('employer', 'skills')->get();
        $services = $category->services()->with('skills', 'tags')->get();

        if ($role === 'worker') {
            // Всі послуги цієї категорії
            return view('categories.show', compact('category', 'jobs'));
        } elseif ($role === 'employer') {
            // Всі послуги та вакансії цієї категорії
            return view('categories.show', compact('category', 'services'));
        } else {
            // Для гостьового перегляду та робітників — вакансії
            return view('categories.show', compact('category', 'jobs', 'services'));
        }
    }
}

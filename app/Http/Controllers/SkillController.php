<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\Category;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::with('category')->get();
        return view('admin.skills.index', compact('skills'));
    }

    public function create()
    {
        // Get all categories and employers for the dropdowns
        $categories = Category::all();

        return view('admin.skills.create',compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        Skill::create($request->all());

        return redirect()->route('skills.index')->with('success', 'Skill created successfully');
    }

    public function edit(Skill $skill)
    {
        // Get all categories and employers for the dropdowns
        $categories = Category::all();

        return view('admin.skills.edit', compact('skill', 'categories'));
    }

    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $skill->update($request->all());

        return redirect()->route('skills.index')->with('success', 'Skill updated successfully');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('skills.index')->with('success', 'Skill deleted successfully');
    }
}

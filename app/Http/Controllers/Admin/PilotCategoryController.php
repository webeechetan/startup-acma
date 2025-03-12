<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class PilotCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('type', 'pilot')->get();
        return view('admin.pilots.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pilots.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name',
        ]);

        $type = 'pilot';
        if (!in_array($type, Category::getAllowedTypes())) {
            return back()->with('error', 'Invalid category type.');
        }

        try {
            Category::create([
                'name' => $request->name,
                'type' => $type,
            ]);

            return redirect()->route('pilots.categories.index')->with('success', 'Category added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add category.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.pilots.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id,
        ]);

        try {
            $category->update([
                'name' => $request->name,
            ]);

            return redirect()->route('pilots.categories.index')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update category.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}

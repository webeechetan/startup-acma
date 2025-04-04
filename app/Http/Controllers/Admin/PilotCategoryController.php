<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Pilot;
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
        $pilots = Pilot::pluck('name', 'id');
        return view('admin.pilots.categories.create', compact('pilots'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name',
            'pilot_id' => 'required|array',
            'pilot_id.*' => 'exists:pilots,id',
        ]);

        try {
            $category = Category::create([
                'name' => $request->name,
                'type' => 'pilot',
            ]);

            $category->pilots()->sync($request->pilot_id);

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
        $pilots = Pilot::pluck('name', 'id');
        $selectedPilots = $category->pilots()->pluck('pilots.id')->toArray();

        return view('admin.pilots.categories.edit', compact('category', 'pilots', 'selectedPilots'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id,
            'pilot_id' => 'required|array',
            'pilot_id.*' => 'exists:pilots,id',
        ]);

        try {
            $category->update([
                'name' => $request->name,
            ]);

            $category->pilots()->sync($request->pilot_id);

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
        $category->delete();
        return redirect()->route('pilots.categories.index')->with('success', 'Category deleted successfully.');
    }
}

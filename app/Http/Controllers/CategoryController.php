<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|min:2|max:100|unique:categories,name',
            'color' => 'nullable|string',
        ], [
            'name.required' => 'Category name is required.',
            'name.min'      => 'Name must be at least 2 characters.',
            'name.unique'   => 'This category already exists.',
        ]);

        Category::create([
            'name'  => $request->name,
            'color' => $request->color ?? '#FFE8D6',
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', '🏷 Category "' . $request->name . '" added!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $name = $category->name;
        $category->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', '🗑 Category "' . $name . '" removed.');
    }
}

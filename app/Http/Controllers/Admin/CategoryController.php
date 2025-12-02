<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'CategoryName' => 'required|string|max:255|unique:categories,CategoryName'
        ]);

        Category::create($request->only('CategoryName')); // Let model generate ID & prefix

        return redirect()->route('admin.products')
            ->with('success', 'Category created successfully!');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'CategoryName' => 'required|string|max:255|unique:categories,CategoryName,' . $category->CategoryID . ',CategoryID',
        ]);

        $data = $request->only(['CategoryName']);

        

        $category->update($data);

        return redirect()->route('admin.products')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->products()->exists()) {
            return back()->with('error', 'Cannot delete category with assigned products.');
        }

        $category->delete();

        return back()->with('success', 'Category deleted successfully!');
    }
}
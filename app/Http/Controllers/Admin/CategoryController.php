<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'CategoryID' => 'required|unique:categories,CategoryID',
            'CategoryName' => 'required|string|max:255|unique:categories,CategoryName'
        ]);

        try {
            Category::create($request->all());

            return redirect()->route('admin.products')
                ->with('success', 'Category created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating category: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'CategoryName' => 'required|string|max:255|unique:categories,CategoryName,' . $id . ',CategoryID'
        ]);

        try {
            $category->update($request->all());

            return redirect()->route('admin.products')
                ->with('success', 'Category updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating category: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            
            // Check if category has products
            if ($category->products()->count() > 0) {
                // Optionally, you can set products to null or handle differently
                // $category->products()->update(['CategoryID' => null]);
            }
            
            $category->delete();

            return redirect()->route('admin.products')
                ->with('success', 'Category deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting category: ' . $e->getMessage());
        }
    }
}
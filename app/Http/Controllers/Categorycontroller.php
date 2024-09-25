<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // Display a listing of the categories
    public function index()
    {
        return view('admin.Categorydisplay', ['categories' => Category::paginate(10)]);
    }
    
    public function create()
    {
        return view('admin.Category'); // Return the view to create a new category
    }

    // Store a newly created category in storage
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        //'slug' => 'required|string|max:255|unique:categories,slug',
        'description' => 'nullable|string',
    ]);

    // Create the category with only the necessary fields
    Category::create($request->only('name', 'description'));

    return response()->json(['message' => 'Category created successfully.']);
}

    // Display the edit form for a specific category
    public function edit($id)
{
    $category = Category::findOrFail($id);
    return view('admin.categoryedit', compact('category'));
}


public function update(Request $request, $id)
{
    $category = Category::find($id);

    if (!$category) {
        return response()->json(['status' => false, 'message' => 'Category not found'], 404);
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
    ]);

    // Update category attributes
    $category->update($request->only('name', 'description'));

    return response()->json(['status' => true, 'message' => 'Category updated successfully!']);
}

 public function destroy($id)
 {
    $category = Category::find($id);

    if (!$category) {         return redirect()->back()->with('error', 'Category not found');
    }

   $category->delete();

    return redirect()->back()->with('success', 'Category deleted successfully');
 }


}

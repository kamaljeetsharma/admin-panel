<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Menu; // Ensure correct model is used
use App\Http\Controllers\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
class MenuController extends Controller
{
    
public function createnew()
{
    return view('admin.menu', ['categories' => Category::all()]);
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'category_id' => 'nullable|integer|exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle image upload
    $validatedData['image'] = $request->file('image') 
        ? $request->file('image')->store('images', 'public') 
        : null;

    // Create a new menu item with mass assignment
    Menu::create($validatedData);

    return redirect()->back()->with('success', 'Menu item added successfully!');
}
     //Display a listing of the menu items.

    public function showMenuItems()
{
    $menuItems = Menu::paginate(10);
 // Fetch all menu items from the database
    //dd($menuItems);
    return view('admin.menudisplay', compact('menuItems')); // Pass data to the view
}

     //Show the form for editing the specified menu item.
     
     public function edit($id)
{
    $menuItem = Menu::findOrFail($id);

    return view('admin.menuupdate', compact('menuItem'));
}

public function update(Request $request, $id)
{
    $menuItem = Menu::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'price' => 'required|numeric|min:0',
        'category_id' => 'nullable|integer|exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $menuItem->fill($request->only('name', 'description', 'price', 'category_id'));

    if ($request->hasFile('image')) {
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }
        $menuItem->image = $request->file('image')->store('images', 'public');
    }

    $menuItem->save();

    return response()->json(['message' => 'Menu item updated successfully!']);
}

public function destroy($id)
{
    $menuItem = Menu::findOrFail($id);
    $menuItem->delete();
    return redirect()->back()->with('success', 'Menu item deleted successfully');
}

}
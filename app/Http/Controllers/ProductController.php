<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
    
        // Check if a search query is provided
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('product_id', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }
    
        // Sort by name or price based on the 'sort' query parameter
        if ($request->filled('sort')) {
            $sort = $request->input('sort');
            // Apply sorting based on the query parameter
            if ($sort == 'name_asc') {
                $query->orderBy('name', 'asc');
            } elseif ($sort == 'name_desc') {
                $query->orderBy('name', 'desc');
            } elseif ($sort == 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($sort == 'price_desc') {
                $query->orderBy('price', 'desc');
            }
        }
    
        // Paginate the results
        $products = $query->paginate(10);
    
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|unique:products|max:255',
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'stock' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;
        }

        Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

     public function show($id)
     {
         $product = Product::findOrFail($id);
         return view('products.show', compact('product'));
     }
 
     public function edit($id)
     {
         $product = Product::findOrFail($id);
         return view('products.edit', compact('product'));
     }
 
     public function update(Request $request, $id)
     {
         $product = Product::findOrFail($id);
 
         $validatedData = $request->validate([
             'product_id' => 'required|max:255|unique:products,product_id,' . $product->id,
             'name' => 'required|max:255',
             'price' => 'required|numeric',
             'description' => 'nullable',
             'stock' => 'nullable|integer',
             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
         ]);
 
         if ($request->hasFile('image')) {
             if ($product->image) {
                 Storage::disk('public')->delete($product->image);
             }
 
             $imagePath = $request->file('image')->store('images', 'public');
             $validatedData['image'] = $imagePath;
         }
 
         $product->update($validatedData);
 
         return redirect()->route('products.index')->with('success', 'Product updated successfully!');
     }

     public function destroy($id)
     {
         $product = Product::findOrFail($id);
 
         if ($product->image) {
             Storage::disk('public')->delete($product->image);
         }
 
         $product->delete();
 
         return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
     }
}

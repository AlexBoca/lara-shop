<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use \Storage;

class ProductsController extends Controller
{

    public function index()
    {
        $items = Product::all();
        return view('products', compact('items'));
    }

    public function create()
    {
        return view('product');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $product = new Product($validateData);
        $product->image = $this->uploadImage($request->image);
        $product->save();
        return redirect()->back();
    }

    function uploadImage($image)
    {
        $imageName = 'images/' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(Storage::disk('public')->path($imageName));
        return $imageName;
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('product', compact('product'));
    }

    public function update(Request $request, $id)
    {
        if (!session('user_login')) {
            return redirect()->back();
        }

        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $product = Product::findOrFail($id);
        $product->fill($validateData);
        if ($request->has('image')) {
            Storage::disk('public')->delete('images/' . $product->image);
            $product->image = $this->uploadImage($request->image);
        }
        $product->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        if (!session('user_login')) {
            return redirect()->route('products');
        }
        $product = Product::findOrFail($id);
        Storage::disk('public')->delete('images/' . $product->image);
        Product::destroy($id);
        return redirect()->back();
    }
}


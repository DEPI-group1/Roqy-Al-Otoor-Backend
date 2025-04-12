<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // ------------------------------------------------------------------------
    //USER Operations 

    public function getProducts()
    {
        //
        $products = Product::with('images')->get();
        return response()->json([
            'products' => $products,
        ]);
    }
    public function getByProduct($name)
    {
        $products = Product::where('name', $name)->with('images')->get();
        return response()->json([
            'products' => $products
        ]);
    }


    // ------------------------------------------------------------------------
    //Admin Operations 

    public function index()
    {
        //
        $products = Product::all();
        // $categories = Category::all();
        return view('admin.products.products', compact('products'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view('admin.products.add-products', compact('categories'));
    }

    public function show($id)
    {
        $product = Product::with(['images', 'category'])->findOrFail($id);
        return view('admin.products.show-product', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit-products', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // التحقق من البيانات
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'keywords' => 'nullable|string',
            'images.*' => 'nullable|image|max:2048',
        ]);

        // تحديث المنتج
        $product->update($validated);

        // رفع الصور
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $imageName = time() . '_' . $imageFile->getClientOriginalName();
                $imageFile->storeAs('public/products', $imageName);

                $product->images()->create([
                    'image' => $imageName
                ]);
            }
        }

        return redirect()->route('products.edit', $product->id)->with('message', 'تم تحديث المنتج بنجاح');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // حذف الصورة إذا كانت موجودة
        if ($product->image_url && Storage::exists('public/products/' . basename($product->image_url))) {
            Storage::delete('public/products/' . basename($product->image_url));
        }

        // حذف المنتج من قاعدة البيانات
        $product->delete();

        return redirect()->route('products')->with('success', 'تم حذف المنتج بنجاح!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|max:2048'
            // 'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $product = Product::create($request->only('name', 'description', 'price', 'old_price', 'discount', 'category_id'));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName(); // حفظ الاسم مع timestamp لمنع التكرار
                $path = $image->storeAs('products', $filename, 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $filename,
                ]);
            }
        }
        // dd($request->images);
        return redirect()->route('products')->with('success', 'تم إضافة المنتج بنجاح!');
    }

    public function showImportForm()
    {
        return view('admin.products.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        // Excel::import(new ProductsImport, $request->file('file'));

        return redirect()->back()->with('success', 'تم استيراد المنتجات بنجاح!');
    }
    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id); // البحث عن الصورة

        // حذف الصورة من التخزين
        if (Storage::exists('public/products/' . $image->image)) {
            Storage::delete('public/products/' . $image->image);
        }

        // حذف الصورة من قاعدة البيانات
        $image->delete();

        return back()->with('success', 'تم حذف الصورة بنجاح!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\product;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use App\Models\images;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{




    public function getCategories()
    {
        $categories = Category::with(['images'])->get();
        return response()->json(
            [
                'categories' => $categories,
            ]
        );
    }

    public function getByCategory($id)
    {
        $products = Product::where('category_id', $id)->with('images')->get();
        return response()->json([
            'products' => $products
        ]);
    }





    // -------------------------------------------------------------------
    // Admin Operations


    // دالة لإنشاء كاتيجوري جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
            'description' => 'nullable|string',
            'image' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // **الحصول على اسم الصورة الأصلي**
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName(); // اسم الصورة مع توقيت فريد
        $image->move(public_path('storage/categories'), $imageName); // نقل الصورة إلى المجلد

        // **إنشاء الفئة مع اسم الصورة فقط**
        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imageName, // تخزين الاسم فقط في قاعدة البيانات
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('storage/categories'), $imageName);
                images::create([
                    'image' => $imageName,
                    'location' => 'carousel',
                    'belongsTo' => $category->name,
                    'category_id' => $category->id
                ]);
            }
        }
        return redirect()->back()->with('success', 'تم إنشاء الفئة بنجاح!');
    }

    // دالة لجلب كل الفئات
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.category', compact('categories'));
    }

    public function showProducts($category_id)
    {
        $categories = Category::all();
        // جلب المنتجات التابعة لهذه الفئة
        $products = Product::where('category_id', $category_id)->with('images')->get();

        return view('admin.categories.category-products', compact(['categories', 'products']))->with('title', 'المنتجات');
    }

    // دالة لعرض تفاصيل فئة معينة
    public function show($id)
    {
        $category = Category::findOrFail($id);
        // dd($category);
        return view('categories.show', compact('category'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.add-categories');
        // ->with(view('admin.products.add-products', compact('categories')));
    }

    public function edit($id)
    {
        $category = Category::with('images')->findOrFail($id);
        // dd($category);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => "required|unique:categories,name,$id|max:255",
            'description' => 'nullable|string',
            'image' => 'nullable|imagemax:2048',
            'carousel_images.*' => 'image|max:2048'
        ]);

        // تحديث البيانات
        $category->name = $request->name;
        $category->description = $request->description;

        // تحديث الصورة الرئيسية إذا تم رفع صورة جديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إن وجدت
            if ($category->image) {
                Storage::delete('public/categories/' . $category->image);
            }

            // رفع الصورة الجديدة
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/categories', $imageName);

            $category->image = $imageName;
        }

        // تحديث صور الكاروسيل إن وجدت
        if ($request->hasFile('carousel_images')) {
            foreach ($request->file('carousel_images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('storage/categories'), $imageName);
                images::create([
                    'image' => $imageName,
                    'location' => 'carousel',
                    'belongsTo' => $category->name,
                    'category_id' => $category->id
                ]);
            }
        }
        $category->save();

        return redirect()->back()->with('success', 'تم تحديث الفئة بنجاح!');
    }


    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'تم حذف الفئة بنجاح!');
    }


    public function deleteImage($id)
    {
        $image = images::find($id);
        if (!$image) {
            return response()->json(['success' => false, 'message' => 'الصورة غير موجودة'], 404);
        }

        // حذف الصورة من التخزين
        Storage::delete('public/categories/' . $image->image);

        // حذف الصورة من قاعدة البيانات
        $image->delete();

        return redirect()->back()->with('success', 'تم حذف الصورة بنجاح');
    }


    // دالة لعرض نموذج استيراد المنتجات
    public function showImportFormForCategory($categoryName)
    {
        $categoryId = Category::where('name', $categoryName)->first()->id;
        return view(
            'admin.categories.import',
            [
                'categoryName' => $categoryName,
                'categoryId' => $categoryId
            ]
        );
    }

    // دالة لاستيراد المنتجات
    public function importproducts(Request $request)
    {
        $categoryId = $request->input('category_id');
        // الكود هنا
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        // Excel::import(new ProductsImport($categoryId), $request->file('file'));
        return redirect()->back()->with('success', 'تم استيراد المنتجات بنجاح');
    }
}
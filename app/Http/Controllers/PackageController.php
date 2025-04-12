<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Package;
use App\Models\PackageImages;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class PackageController extends Controller
{
    //
    public function index()
    {
        $packages = Package::with('images')->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function ShowPackageToUser($name)
    {
        $package = Package::with('images')->where('name', $name)->first();

        if ($package) {
            // جلب المنتجات المشابهة بناءً على نفس الفئة مع تحديد عدد محدد
            $relatedPackages = Cache::remember("relatedPackages_{$package->id}", 60, function () use ($package) {
                return Product::with('images')
                    ->where('category_id', $package->category_id)
                    ->where('id', '!=', $package->id)
                    ->limit(6)
                    ->get();
            });

            // dd($package);
            return view('user.package-details', compact('package', 'relatedPackages'))->with('title', $package->name);
        } else {
            abort(404);
        }
    }


    public function create()
    {
        // $products = Product::all();
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'detailed_description' => 'nullable|string',
            'components' => 'nullable|string',
            'Usage_method' => 'nullable|string',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'status' => 'in:active,inactive',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // إنشاء الباكدج
        $package = Package::create([
            'name' => $request->name,
            'description' => $request->description,
            'detailed_description' => $request->detailed_description,
            'components' => $request->components,
            'Usage_method' => $request->descriptionUsage_method,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'status' => $request->status,
        ]);

        // حفظ الصور
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName(); // اسم الصورة فقط
                $image->storeAs('packages', $imageName, 'public'); // حفظها في فولدر packages

                // حفظ اسم الصورة فقط في قاعدة البيانات
                PackageImages::create([
                    'package_id' => $package->id,
                    'image_path' => $imageName, // تخزين الاسم فقط بدون المسار
                ]);
            }
        }

        return redirect()->route('packages.index')->with('success', 'تمت إضافة الباكدج بنجاح!');
    }
    public function edit($id)
    {
        // جلب بيانات الباكدج من قاعدة البيانات
        $package = Package::findOrFail($id);

        // إرسال البيانات إلى صفحة التعديل
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        // تحديث بيانات الباكدج
        $package->update([
            'name' => $request->name,
            'description' => $request->description,
            'detailed_description' => $request->detailed_description,
            'components' => $request->components,
            'Usage_method' => $request->descriptionUsage_method,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'status' => $request->status,
        ]);

        // حذف الصور المحددة من الطلب
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = PackageImages::find($imageId);
                if ($image) {
                    Storage::delete('public/packages/' . $image->image_path);
                    $image->delete();
                }
            }
        }

        // رفع الصور الجديدة (إن وُجدت)
        // حفظ الصور
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName(); // اسم الصورة فقط
                $image->storeAs('packages', $imageName, 'public'); // حفظها في فولدر packages

                // حفظ اسم الصورة فقط في قاعدة البيانات
                PackageImages::create([
                    'package_id' => $package->id,
                    'image_path' => $imageName, // تخزين الاسم فقط بدون المسار
                ]);
            }
        }

        return redirect()->route('packages.edit', $package->id)->with('success', 'تم تحديث الباكدج بنجاح!');
    }
    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return redirect()->route('packages.index')->with('success', 'تم حذف الباكدج بنجاح');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $images = images::where('belongsTo', '')->orWhereNull('belongsTo')->get();
        $images = images::where(function ($query) {
            $query->where('belongsTo', '')->orWhereNull('belongsTo');
        })
            ->where('location', 'carousel')
            ->get();

        return view('admin.settings.add-image', compact('images'));
    }

    public function DisplayImagesToUser()
    {
        $images = images::where(function ($query) {
            $query->where('belongsTo', '')->orWhereNull('belongsTo');
        })
            ->where('location', 'carousel')
            ->get();
        return response()->json([
            'images' => $images,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



    public function store(Request $request)
    {
        // 
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // تأكد من أن الملف صورة
            'location' => 'required|string',
            'belongsTo' => 'nullable|string|max:255',
        ]);

        $path = $request->file('image')->store('uploads', 'public');

        images::create([
            'image' => $path,
            'location' => $request->location,
            'belongsTo' => $request->belongsTo, // ✅ إصلاح الخطأ هنا
        ]);

        // 🔹 إعادة توجيه مع رسالة نجاح
        return redirect()->back()->with('success', 'تم رفع الصورة بنجاح!');
    }







    // public function store(Request $request)
    // {
    //     // 🔹 تحقق من صحة البيانات
    //     $request->validate([
    //         'image' => 'required',
    //         'location' => 'required|string',
    //         'belongsTo' => 'nullable|string|max:255',
    //     ]);

    //     // 🔹 حفظ الصورة في مجلد `storage/app/public/images`
    //     $path = $request->file('image')->store('uploads', 'public');

    //     // 🔹 تخزين معلومات الصورة في قاعدة البيانات
    //     images::create([
    //         'image' => $path,
    //         'location' => $request->location,
    //         'belongsTo' => $request->description,
    //     ]);

    //     // 🔹 إعادة توجيه مع رسالة نجاح
    //     return redirect()->back()->with('success', 'تم رفع الصورة بنجاح!');
    // }

    /**
     * Display the specified resource.
     */
    public function show(images $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(images $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, images $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(images $image)
    {
        //

    }
    /**
     * حذف صورة منتج معينة.
     */

    public function deleteImage($id)
    {
        $image = images::findOrFail($id); // البحث عن الصورة

        // حذف الصورة من التخزين
        $imagePath = storage_path('app/public/' . $image->image);

        if (file_exists($imagePath) && is_file($imagePath)) {
            Storage::disk('public')->delete($image->image);
        }

        // حذف الصورة من قاعدة البيانات
        $image->delete();

        return response()->json(['success' => true, 'message' => 'تم حذف الصورة بنجاح!']);
    }
}
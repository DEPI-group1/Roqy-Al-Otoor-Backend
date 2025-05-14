<?php

namespace App\Http\Controllers;

use App\Models\images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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


    public function store(Request $request)
    {
        // 
        $request->validate([
            'image' => 'required',
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

    // public function destroy($id)
    // {
    //     $image = images::findOrFail($id);

    //     // حذف الصورة من المسار
    //     if (file_exists(public_path('storage/uploads/' . $image->image))) {
    //         unlink(public_path('storage/uploads/' . $image->images));
    //     }

    //     // حذف السطر من قاعدة البيانات
    //     $image->delete();

    //     return response()->with('success', 'تم حذف الصورة بنجاح!');
    // }







    public function destroy($id)
    {
        // العثور على الصورة في قاعدة البيانات
        $image = images::find($id);

        if ($image) {
            // حذف الصورة من التخزين
            $imagePath = storage_path('app/public/' . $image->image);

            if (file_exists($imagePath)) {
                unlink($imagePath); // حذف الصورة من السيرفر
            }

            // حذف السجل من قاعدة البيانات
            $image->delete();

            // إرسال رسالة النجاح بعد الحذف وإعادة التوجيه
            return redirect()->back()->with('success', 'تم حذف الصورة بنجاح!');
        } else {
            return redirect()->back()->with('error', 'الصورة غير موجودة.');
        }
    }
}
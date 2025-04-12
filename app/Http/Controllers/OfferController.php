<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Offer;

class OfferController extends Controller
{
    // عرض جميع العروض
    public function index()
    {
        $offers = Offer::where('expiry_date', '>', now())->get();
        return view('admin.offers.index', compact('offers'));
    }

    public function indexToUser()
    {
        $offers = Offer::where('expiry_date', '>', now())
            ->orderBy('created_at', 'desc') // ترتيب العروض من الأحدث إلى الأقدم
            ->select('id', 'title', 'price', 'old_price', 'expiry_date', 'images') // تحديد الحقول المطلوبة فقط
            ->paginate(10); // تقسيم النتائج على صفحات (10 عروض في كل صفحة)

        return view('user.offers', compact('offers'))->with('title', 'العروض');
    }

    // صفحة إنشاء عرض جديد
    public function create()
    {
        return view('admin.offers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'original_price' => 'required|numeric',
            'discounted_price' => 'required|numeric',
            'expiry_date' => 'required|date',
            'offer_images' => 'required',
            'offer_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // التحقق من الصور
        ]);

        $imagePaths = []; // مصفوفة لتخزين مسارات الصور

        // رفع الصور وتخزين المسارات
        foreach ($request->file('offer_images') as $image) {
            $imagePaths[] = $image->store('offers', 'public');
        }

        // حفظ البيانات في قاعدة البيانات
        Offer::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->original_price,
            'old_price' => $request->discounted_price,
            'expiry_date' => $request->expiry_date,
            'images' => json_encode($imagePaths), // تخزين الصور كـ JSON
        ]);

        return redirect()->route('offers.index')->with('success', 'تم إضافة العرض بنجاح!');
    }


    /**
     * عرض صفحة تعديل العرض
     */
    public function edit($id)
    {
        $offer = Offer::findOrFail($id);
        return view('admin.offers.edit', compact('offer'));
    }

    /**
     * تحديث بيانات العرض
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'original_price' => 'required|numeric',
            'discounted_price' => 'required|numeric',
            'expiry_date' => 'required|date',
            'images' => 'nullable|array', // السماح بتحديث الصور
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $offer = Offer::findOrFail($id);

        // تحديث البيانات
        $offer->title = $request->title;
        $offer->description = $request->description;
        $offer->original_price = $request->original_price;
        $offer->discounted_price = $request->discounted_price;
        $offer->expiry_date = $request->expiry_date;

        // تحديث الصور إذا تم رفع صور جديدة
        if ($request->hasFile('images')) {
            // حذف الصور القديمة
            $oldImages = json_decode($offer->images, true);
            if ($oldImages) {
                foreach ($oldImages as $image) {
                    Storage::delete($image);
                }
            }

            // حفظ الصور الجديدة
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('offers', 'public');
                $images[] = $path;
            }
            $offer->images = json_encode($images);
        }

        $offer->save();

        return redirect()->route('offers.index')->with('success', 'تم تحديث العرض بنجاح!');
    }

    /**
     * حذف العرض
     */
    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);

        // حذف الصور من التخزين
        $images = json_decode($offer->images, true);
        if ($images) {
            foreach ($images as $image) {
                Storage::delete($image);
            }
        }

        $offer->delete();

        return redirect()->route('offers.index')->with('success', 'تم حذف العرض بنجاح!');
    }
}
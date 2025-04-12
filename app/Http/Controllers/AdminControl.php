<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Control;
use App\Models\User;

class AdminControl extends Controller
{
    public function index()
    {
        $controls = Control::orderBy('order', 'asc')->get();
        $categories = Category::all();
        return view('admin.control.index', compact('controls', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image',
            'order' => 'required|integer'
        ]);

        $path = $request->file('image')->store('control_images', 'public');

        Control::create([
            'category_id' => $request->category_id,
            'image' => $path,
            'order' => $request->order,
        ]);

        return redirect()->route('control')->with('success', 'تمت إضافة الفئة بنجاح!');
    }

    public function destroy($id)
    {
        $control = Control::findOrFail($id);
        Storage::disk('public')->delete($control->image);
        $control->delete();

        return redirect()->route('control')->with('success', 'تم الحذف بنجاح!');
    }

    // public function create()
    // {
    //     return view('admin.admins.add-admin');
    // }

    // public function storeAdmin(Request $request)
    // {
    //     dd($request->all);
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => ['required', 'email', 'max:255', Rule::unique('users')],
    //         'phone_number' => 'required|digits11',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);

    //     User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'phone_number' => $request->phone_number,
    //         'password' => Hash::make($request->password),
    //         'role' => 'admin', // إنشاء كأدمن
    //     ]);

    //     return redirect()->route('admin.create')->with('success', 'تمت إضافة الأدمن بنجاح!');
    // }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Control;
use App\Models\User;
use App\Models\Order;

class AdminController extends Controller
{

    public function earningsReport(Request $request)
    {
        $type = $request->query('type', 'monthly'); // افتراضيًا شهري

        if ($type == 'daily') {
            $earnings = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->get();
        } else {
            $earnings = Order::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_amount) as total')
                ->groupBy('year', 'month')
                ->orderBy('year', 'DESC')
                ->orderBy('month', 'DESC')
                ->get();
        }

        $totalEarnings = $earnings->sum('total'); // حساب إجمالي الأرباح

        return view('admin.reports.earnings_report', compact('type', 'earnings', 'totalEarnings'));
    }
    public function create()
    {
        return view('admin.admins.add-admin');
    }

    public function storeAdmin(Request $request)
    {
        // dd($request); // جرب هذه بدل all()
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')],
            'phone_number' => 'required|digits:11',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'role' => 'admin', // إنشاء كأدمن
        ]);

        return redirect()->route('admin.create')->with('success', 'تمت إضافة الأدمن بنجاح!');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class DashboardController extends Controller
{
    //
    public function index()
    {
        return view('admin.dashboard');
    }


    public function DashBoarddata()
    {
        $products_count = Product::count();
        $categories_count = Category::count();
        $total_earnings = Order::sum('total_amount'); // اجمالي الأرباح

        return view('admin.dashboard', compact('products_count', 'categories_count', 'total_earnings'));
    }


    // public function dashboard()
    // {
    //     $notifications = Notification::where('user_id', Auth::id())->latest()->get();
    //     return view('admin.dashboard', compact('notifications'));
    // }
}
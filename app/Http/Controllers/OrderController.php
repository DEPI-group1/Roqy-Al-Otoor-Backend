<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderNotification;
use Illuminate\Notifications\DatabaseNotification;

class OrderController extends Controller
{
    // *********************************************************************************************
    // Admin Operation
    public function index()
    {
        $orders = Order::all();
        $LimitOrders = Order::where('order_status', 'pending')->orderBy('created_at', 'desc')->limit(10)->get();
        $OrdersCount = Order::where('payment_status', 'paid')->count();
        $PendingOrders = Order::where('order_status', 'pending')->count();
        // جلب الطلبات المدفوعة فقط
        $paid_orders = Order::where('payment_status', 'paid')->get();

        // تمرير البيانات إلى كل من الواجهات المطلوبة
        return view('admin.orders.orders_summary', compact('orders'))
            ->with('dashboard', view('admin.dashboard', compact('LimitOrders', 'OrdersCount', 'PendingOrders')))
            ->with('orders', view('admin.orders.order', compact('orders')));
    }
    public function show($id)
    {

        $order = Order::with('items')->findOrFail($id);

        // تحديد الإشعار وقراءته إن وجد
        $notificationID = request()->query('notification');
        $notification = DatabaseNotification::find($notificationID);
        if ($notification && !$notification->read_at) {
            $notification->markAsRead();
        }

        return view('admin.orders.order', compact('order'));
    }
    public function showID($id, $notificationID)
    {
        $notification = DatabaseNotification::find($notificationID);
        // عشان نخلى الاشعار مقروء
        if ($notification && !$notification->read_at) {
            $notification->markAsRead();
        }


        $order = Order::with('items')->findOrFail($id);
        return view('admin.orders.order', compact('order'));
    }
    public function updateOrderStatus(Request $request, $id)
    {
        // البحث عن الطلب باستخدام الـ ID
        $order = Order::findOrFail($id);

        // تحديث حالة الطلب بناءً على البيانات المرسلة
        $order->order_status = $request->status;
        $order->save();

        // إرجاع استجابة JSON لتأكيد التحديث
        // return response()->json(['success' => true]);
        return response()->json(['success' => true, 'message' => 'تم تحديث حالة الطلب بنجاح']);
    }




    // *********************************************************************************************
    // User Operation

    public function getOrders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->with('items')->get();
        return response()->json([
            'user_id' => $user->id,
            'status' => true,
            'orders' => $orders,
            'message' => 'Fetching Orders Success'
        ]);
    }
    public function checkReturnEligibility($id)
    {
        $order = Order::findOrFail($id);

        // التحقق من أن الطلب لم يتجاوز 14 يومًا
        if (now()->diffInDays($order->created_at) > 14) {
            return back()->with('error', 'عذرًا، انتهت فترة الإرجاع لهذا الطلب.');
        }

        // إذا كان الطلب صالحًا، يتم التوجيه لصفحة الإرجاع
        return redirect()->route('return.form', ['id' => $id]);
    }
    public function ReturnForm($id)
    {
        $order = Order::findOrFail($id);
        // return view('user.Return-Form', compact('order'))->with('title', 'إرجاع المنتج');
    }
}
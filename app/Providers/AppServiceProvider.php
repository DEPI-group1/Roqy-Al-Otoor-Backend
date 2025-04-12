<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        View::composer(['admin.orders.orders_summary', 'admin.dashboard', 'admin.orders.accepted_orders', 'admin.orders.orders'], function ($view) {
            $user = Auth::user();
            $view->with('orders', Order::all())
                ->with('products_count', Product::count())
                ->with('categories_count', Category::count())
                ->with('total_earnings', Order::sum('total_amount'))
                ->with('COD_orders', Order::where('payment_method', 'COD')->count())
                ->with('LimitOrders', Order::where('order_status', 'pending')->orderBy('created_at', 'desc')->limit(10)->get())
                ->with('paid_orders', Order::where('payment_status', 'paid')->get())
                ->with('OrdersCount', Order::where('payment_status', 'paid')->count())
                ->with('PendingOrders', Order::where('order_status', 'pending')->count());
        });
    }
}
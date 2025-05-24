<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\bookShelf;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::guard('member')->check()) {
                $userId = Auth::guard('member')->user()->id_member;

                $cartCount = Cart::where('id_member', $userId)->count();
                $bookShelfCount = bookShelf::where('id_member', $userId)->count(); // ตรวจสอบให้แน่ใจว่าชื่อโมเดลถูกต้อง

                // ส่งตัวแปรหลายตัวไปยัง view
                $view->with([
                    'cartCount' => $cartCount,
                    'bookShelfCount' => $bookShelfCount
                ]);
            } else {
                // กรณีไม่ได้ล็อกอิน
                $view->with([
                    'cartCount' => 0,
                    'bookShelfCount' => 0
                ]);
            }
        });
    }
}

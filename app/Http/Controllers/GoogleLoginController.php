<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Providers\RouteServiceProvider;

class GoogleLoginController extends Controller
{
    // Redirect ผู้ใช้ไปที่ Google OAuth 2.0
    public function redirectToGoogle()
    {
        // กำหนดพารามิเตอร์ที่ต้องการส่งไปที่ Google OAuth
        $queryParams = http_build_query([
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'redirect_uri' => env('GOOGLE_REDIRECT_URL'),
            'response_type' => 'code',
            'scope' => 'email profile',
            'access_type' => 'offline',
            'prompt' => 'select_account',
        ]);

        // สร้าง URL สำหรับให้ผู้ใช้เข้าสู่ระบบผ่าน Google
        $googleUrl = 'https://accounts.google.com/o/oauth2/auth?' . $queryParams;

        // Redirect ผู้ใช้ไปยัง Google
        return redirect()->away($googleUrl);
    }

    // Callback หลังจากที่ผู้ใช้ยืนยันตัวตนกับ Google
    public function handleGoogleCallback(Request $request)
    {
        // รับ authorization code ที่ Google ส่งกลับมา
        $code = $request->get('code');

        if ($code) {
            // ขอ access token จาก Google โดยใช้ authorization code
            $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'client_id' => env('GOOGLE_CLIENT_ID'),
                'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                'redirect_uri' => env('GOOGLE_REDIRECT_URL'),
                'grant_type' => 'authorization_code',
                'code' => $code,
            ]);

            // ดึง access token จาก response
            $accessToken = $tokenResponse->json()['access_token'];

            // ใช้ access token เพื่อดึงข้อมูลผู้ใช้จาก Google
            $userInfoResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get('https://www.googleapis.com/oauth2/v1/userinfo?alt=json');

            $googleUser = $userInfoResponse->json();

            // ตรวจสอบว่าผู้ใช้มีอยู่ในฐานข้อมูลหรือไม่
            $user = Member::where('email', $googleUser['email'])->first();

            // ถ้าไม่มีผู้ใช้ ให้สร้างผู้ใช้ใหม่
            if (!$user) {
                $fullName = $googleUser['name'];
                $nameParts = explode(' ', $fullName);

                $Firstname = $nameParts[0]; // ชื่อ
                $LastName = isset($nameParts[1]) ? implode(' ', array_slice($nameParts, 1)) : ''; // นามสกุล (ถ้ามี)

                // สร้างผู้ใช้ใหม่
                $user = Member::create([
                    'Firstname' => $Firstname,
                    'LastName' => $LastName,
                    'email' => $googleUser['email'],
                    'password' => \Hash::make(rand(100000, 999999)), // รหัสผ่านสุ่ม
                ]);
            }

            // ล็อกอินผู้ใช้เข้าสู่ระบบ
            Auth::login($user);

            // ส่งผู้ใช้ไปยังหน้าแรก
            return redirect(RouteServiceProvider::HOME);
        }

        return redirect()->route('login')->withErrors('Failed to login with Google');
    }
}

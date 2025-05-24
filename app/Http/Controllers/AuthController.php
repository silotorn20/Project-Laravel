<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\setBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register()//หน้าสมัครสมาชิก
    {
        $existingEmails = Member::pluck('email')->toArray();

        return view('register',compact('existingEmails'));
    }

    //เพิ่มข้อมูลสมัครสมาชิก
    public function registerPost(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8', // Require minimum of 8 characters
                'regex:/^[a-zA-Z0-9._]+$/', // Only allow letters and numbers (no special characters)
            ],
            'Firstname' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
        ]);

        $member = new Member();
        $member->Firstname = $request->Firstname;
        $member->LastName = $request->LastName;
        $member->email = $request->email;
        $member->password = Hash::make($request->password);

        $member->save();

        session()->flash('success', 'สมัครสมาชิกสำเร็จ');
        return redirect()->route('login');
    }

    public function login()//หน้าล็อกอิน
    {
        return view('login');
    }

    public function loginPost(Request $request)
    {
        if (!$request->filled('login') && !$request->filled('password')) {
            return back()->withErrors(['กรุณากรอกข้อมูล']);
        }

        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ], [
            'login.required' => 'กรุณากรอกอีเมลหรือชื่อผู้ใช้',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        // ตรวจสอบว่าเป็นอีเมลหรือชื่อผู้ใช้
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $login,
            'password' => $password
        ];

        if ($fieldType == 'email' && Auth::guard('member')->attempt(['email' => $login, 'password' => $password])) {
            $user = Auth::guard('member')->user();

            if ($user->status == 'ผู้เขียน') {
                $user->status = 'ผู้เขียนและผู้อ่าน';
                $user->save();
            }

            $request->session()->regenerate();

            return redirect()->intended('/home')->with('success', 'Login Success');
        }
          // ถ้าไม่ใช่สมาชิก ลองตรวจสอบการล็อกอินของแอดมิน
          if ($fieldType == 'username' && Auth::guard('admin')->attempt(['username' => $login, 'password' => $password])) {
            $admin = Auth::guard('admin')->user();

            $request->session()->regenerate();

            return redirect()->intended('/setBook')->with('success', 'Login Success');
        }

        // กรณีล็อกอินไม่สำเร็จ
        return back()->with('error', 'อีเมล ชื่อผู้ใช้ หรือรหัสผ่าน ไม่ถูกต้อง');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            // ล็อกเอาท์แอดมิน
            Auth::guard('admin')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // ส่งกลับไปที่หน้า login พร้อมข้อความแจ้งผล
            return redirect('/login')->with('success', 'Logout Success');
        }

        // หากไม่ใช่แอดมิน ตรวจสอบสถานะการล็อกอินของสมาชิก
        if (Auth::guard('member')->check()) {
            // ล็อกเอาท์สมาชิก
            Auth::guard('member')->logout();

            $request->session()->invalidate();
            // $request->session()->regenerateToken();

            // ส่งกลับไปที่หน้า login พร้อมข้อความแจ้งผล
            return redirect('/')->with('success', 'Logout Success');
        }

        // หากไม่พบสถานะการล็อกอินที่ตรงกัน
        return redirect('/login')->with('error', 'You are not logged in');
    }

    public function showLoginForm()
    {
        if (Auth::guard('member')->check() && session('role') === 'member') {
            return redirect('/home')->with('info', 'You are already logged in as Member');
        }

        if (Auth::guard('admin')->check() && session('role') === 'admin') {
            return redirect('/setBook')->with('info', 'You are already logged in as Admin');
        }

        return view('login');
    }

    public function home()
    {
        $setBooks = SetBook::all();

        return view('home', compact('setBooks'));
    }
}

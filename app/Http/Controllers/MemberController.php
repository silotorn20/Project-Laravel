<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\setBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function addMember()//หน้าสมัครสมาชิก
    {
        $existingEmails = Member::pluck('email')->toArray();

        return view('addMember',compact('existingEmails'));
    }

    //เพิ่มข้อมูลสมัครสมาชิก
    public function addMemberPost(Request $request)
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
            'Phone' => 'nullable|digits:10',
        ],[
            'email.unique' => 'มีอีเมลในระบบแล้วกรุณากรอกใหม่',
            'Phone.digits' => 'เบอร์โทรต้องมีความยาว 10 หลัก',
        ]);
        $member = new Member();
        $member->Firstname = $request->Firstname;
        $member->LastName = $request->LastName;
        $member->email = $request->email;
        $member->password = Hash::make($request->password);
        $member->Phone = $request->Phone;

        if ($request->hasFile('profile')) {
            $image = $request->profile->getClientOriginalName();
            $request->profile->move(public_path('profiles'), $image);
            $member->profile = $image;
        }

        $member->save();

        // return back()->with('success', 'Register successfully');
        return redirect('/show')->with('success', 'Register successfully');
    }

    //show member for admin
    public function show()
    {
        $members = Member::paginate(10);

        return view('showMember',compact('members'));
    }

    public function editmember($id_member)
    {
        $member = Member::findOrFail($id_member);

        return view('editmember', compact('member'));
    }

    //update member for admin
    public function memberUp(Request $request,$id_member)
    {
        $request->validate([
            'Firstname' => 'nullable|string',
            'LastName' => 'nullable|string',
            'email' => [
                'nullable',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|msu\.ac\.th)$/', // ตรวจสอบให้รองรับเฉพาะ @gmail.com และ @msu.ac.th
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/^[a-zA-Z0-9._]+$/',
            ],
            'profile' => 'nullable|mimes:jpg,png,jpeg|max:5048',
            'Phone' => [
            'nullable',
            'digits:10',
            'regex:/^0[0-9]{9}$/' // Ensure the phone number starts with 0 and has exactly 10 digits
        ],
        ], [
            'email.regex' => 'กรุณากรอกอีเมลให้ถูกต้อง', // กำหนดข้อความผิดพลาดสำหรับอีเมล
            'Phone.regex' => 'หมายเลขโทรศัพท์ต้องเริ่มต้นด้วย 0 '
        ]);

        // ค้นหาสมาชิกที่ต้องการอัปเดต
        $member = Member::findOrFail($id_member);

        // ตรวจสอบว่าอีเมลใหม่มีอยู่ในฐานข้อมูลหรือไม่
        if ($request->email && $request->email !== $member->email) {
            $emailExists = Member::where('email', $request->email)->exists();
            if ($emailExists) {
                return redirect()->back()->withErrors(['email' => 'มีอีเมลนี้ในระบบแล้ว กรุณากรอกใหม่ '])->withInput();
            }
        }

        $member->Firstname = $request->Firstname;
        $member->LastName = $request->LastName;
        $member->email = $request->email;
       // ถ้าไม่ได้กรอกรหัสผ่านใหม่ ก็ใช้รหัสผ่านเดิม
        if ($request->filled('password')) {
            $member->password = Hash::make($request->password);
        }
        $member->Phone = $request->Phone;

        if ($request->hasFile('profile')) {
            $image = $request->profile->getClientOriginalName();
            $request->profile->move(public_path('profiles'), $image);
            $member->profile = $image;
        }

        $member->save();
        // Redirect back with success message
        return redirect('/show')->with('success', 'ข้อมูลถูกอัปเดตเรียบร้อยแล้ว');
    }

    //search for admin
    public function search(Request $request)
    {
        $query = $request->input('query');

        // ค้นหาข้อมูลจากตาราง members ที่ตรงกับคำค้น
        $members = Member::where('Firstname', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%")
                        ->orWhere('Phone', 'like', "%{$query}%")
                        ->paginate(10)
                        ->appends(['query' => $query]);

        $allMembers = Member::paginate(10);

        return view('showMember',compact('members','allMembers','query'));
    }

    //delete member for admin
    public function deleteMember($id_member)
    {
        $member = Member::findOrFail($id_member);
        $member->delete();

        return redirect('/show');
    }

    //profile for member
    public function profile($id_member)
    {
       //ดึง ID ของสมาชิกที่ล็อกอินอยู่
        $loggedInUserId = Auth::id();

        // ดึงข้อมูลสมาชิกโดยใช้ ID ที่ล็อกอินอยู่
        $member = Member::find($loggedInUserId);

        if (!$member) {
            abort(404); // ถ้าไม่พบ Member ให้แสดงหน้า 404
        }
        $setBooks = SetBook::all();

        return view('profile',['member' => $member], compact('setBooks'));
    }

    public function editprofile($id_member)
    {
        $member = Member::findOrFail($id_member);
        $setBooks = SetBook::all();

        return view('editProfile', compact('member','setBooks'));
    }

    //update profile for member
   public function profileUp(Request $request, $id_member)
{
    $request->validate([
        'Firstname' => 'nullable|string',
        'LastName' => 'nullable|string',
        'email' => [
            'nullable',
            'email',
            'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|msu\.ac\.th)$/', // ตรวจสอบให้รองรับเฉพาะ @gmail.com และ @msu.ac.th
        ],
        'password' => [
            'nullable',
            'string',
            'min:8',
            'regex:/^[a-zA-Z0-9._]+$/',
        ],
        'profile' => 'nullable|mimes:jpg,png,jpeg|max:5048',
        'Phone' => [
        'nullable',
        'digits:10',
        'regex:/^0[0-9]{9}$/' // Ensure the phone number starts with 0 and has exactly 10 digits
    ],
    ], [
        'email.regex' => 'กรุณากรอกอีเมลให้ถูกต้อง', // กำหนดข้อความผิดพลาดสำหรับอีเมล
        'Phone.regex' => 'หมายเลขโทรศัพท์ต้องเริ่มต้นด้วย 0 '
    ]);

    // ค้นหาสมาชิกที่ต้องการอัปเดต
    $member = Member::findOrFail($id_member);

    // ตรวจสอบว่าอีเมลใหม่มีอยู่ในฐานข้อมูลหรือไม่
    if ($request->email && $request->email !== $member->email) {
        $emailExists = Member::where('email', $request->email)->exists();
        if ($emailExists) {
            return redirect()->back()->withErrors(['email' => 'มีอีเมลนี้ในระบบแล้ว กรุณากรอกใหม่ '])->withInput();
        }
    }

    // อัปเดตข้อมูลสมาชิก
    $member->Firstname = $request->Firstname;
    $member->LastName = $request->LastName;
    $member->email = $request->email;

    // ถ้าไม่ได้กรอกรหัสผ่านใหม่ ก็ใช้รหัสผ่านเดิม
    if ($request->filled('password')) {
        $member->password = Hash::make($request->password);
    }
    $member->Phone = $request->Phone;

    if ($request->hasFile('profile')) {
        $image = $request->profile->getClientOriginalName();
        $request->profile->move(public_path('profiles'), $image);
        $member->profile = $image;
    }

    $member->save();

    // Redirect back with success message
    return redirect()->route('profile', $id_member)->with('success', 'ข้อมูลถูกอัปเดตเรียบร้อยแล้ว');
    
}


}

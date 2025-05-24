<?php
namespace App\Http\Controllers;

use App\Models\setBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SetBookController extends Controller
{
    public function setBook()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/login')->with('error', 'กรุณาเข้าสู่ระบบ');
        }

        $setBooks = SetBook::all();

        return view('setBook', compact('setBooks'));
    }

    public function addSetBook()
    {
        return view('addSetBook');
    }

    public function addSetBookPost(Request $request)
    {
        // ตรวจสอบว่าชื่อหมวดหมู่ซ้ำหรือไม่
        if (setBook::where('nameSetBook', $request->nameSetBook)->exists()) {
            return response()->json(['success' => false, 'message' => 'ชื่อหมวดหมู่ซ้ำ กรุณากรอกชื่อใหม่']);
        }

        $setBook = new setBook();
        $setBook->nameSetBook = $request->nameSetBook;
        $setBook->save();

        return response()->json(['success' => true, 'message' => 'บันทึกสำเร็จ']);
    }

    public function editSetBook($id_setbook)
    {
        $setBook = SetBook::findOrFail($id_setbook);

        return view('editSetBook', compact('setBook'));
    }

    public function updateSetBook(Request $request, $id_setbook)
    {
        $setBook = SetBook::findOrFail($id_setbook);
        if (SetBook::where('nameSetBook', $request->nameSetBook)->where('id_setbook', '!=', $id_setbook)->exists()) {
            return redirect()->back()->with('error', 'ชื่อหมวดหมู่ซ้ำ กรุณากรอกชื่อใหม่');
        }
        $setBook->update([
            'nameSetBook' => $request->input('nameSetBook'),
        ]);

        return redirect()->route('editSetBook', $setBook->id_setbook)->with('success', 'แก้ไขสำเร็จ');
    }

    public function deleteSetBook($id_setbook)
    {
        $setBook = SetBook::findOrFail($id_setbook);
        $setBook->delete();

        return redirect('/setBook');
    }

    // public function show($setBook)
    // {
    //     // ดึงข้อมูลของ setBook ที่เลือก
    //     $setBooks = SetBook::where('nameSetBook', $setBook)->first();

    //     // ตรวจสอบว่าพบข้อมูลหรือไม่
    //     if (!$setBooks) {
    //         return redirect('/')->with('error', 'Set Book not found');
    //     }

    //     // ส่งข้อมูลไปยังหน้า Welcome
    //     return view('welcome', compact('setBooks'));
    // }
}

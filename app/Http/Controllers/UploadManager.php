<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Book;
use App\Models\setBook;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UploadManager extends Controller
{
    public function addbook()
    {
        $setBooks = SetBook::all();

        $existingTitles = Book::pluck('name_book')->toArray(); // สมมุติว่า title คือชื่อคอลัมน์ในฐานข้อมูล

        return view('addBook', compact('setBooks','existingTitles'));
    }

    public function uploadPost(Request $request) {
        // dd($request->all());
        // $file = $request->file("file_book");
        if (Auth::check()) {
            $id_member = Auth::guard('member')->user()->id_member;
        } else {
            return redirect()->back()->with('error', 'User is not logged in');
        }

        // ตรวจสอบไฟล์รูปภาพและไฟล์หนังสือ
        if (!$request->hasFile('image_book') || !$request->file('image_book')->isValid()) {
            return redirect()->back()->with('error', 'Invalid or missing image file.');
        }

        if (!$request->hasFile('file_book') || !$request->file('file_book')->isValid()) {
            return redirect()->back()->with('error', 'Invalid or missing book file.');
        }

        // ตรวจสอบว่าไฟล์ที่อัปโหลดเป็น PDF หรือไม่
        if ($request->file('file_book')->getClientMimeType() !== 'application/pdf') {
            return redirect()->back()->with('error', 'กรุณาอัพโหลดไฟล์ PDF เท่านั้น.');
        }

        // ตรวจสอบชื่อหนังสือว่ามีในระบบแล้วหรือไม่
        $bookTitle = $request->input('bookTitle');
        $existingBook = Book::where('name_book', $bookTitle)->first();

        if ($existingBook) {
            return redirect()->back()->with('error', 'ชื่อหนังสือนี้มีอยู่ในระบบแล้ว');
        }

        // ย้ายไฟล์ไปที่โฟลเดอร์
        $imageName = $request->file('image_book')->getClientOriginalName();
        if (!$request->file('image_book')->move(public_path('images'), $imageName)) {
            return redirect()->back()->with('error', 'Failed to upload image.');
        }

        $fileName = $request->file('file_book')->getClientOriginalName();
        if (!$request->file('file_book')->move(public_path('uploads'), $fileName)) {
            return redirect()->back()->with('error', 'Failed to upload book file.');
        }

        // สร้างรายการข้อมูลหนังสือในฐานข้อมูล
        $book = new Book();
        $book->id_setbook = $request->input('category');
        $book->id_member = $id_member;
        $book->name_book = $request->input('bookTitle');
        $book->image_book = $imageName;
        $book->file_book = $fileName;
        $book->price = $request->input('price');
        $book->amount_page = $request->input('numPages');

        if ($book->save()) {
            // return redirect('/home')->with('success', 'File uploaded successfully and data added to the database.');
            return redirect()->route('writer.showWorks', $id_member);
        } else {
            return redirect()->back()->with('error', 'Failed to save data to the database.');
        }
    }
}

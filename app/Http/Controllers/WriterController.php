<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\setBook;
use App\Models\Book;
use App\Models\Review;
use App\Models\bookShelf;
use App\Models\Buy_Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class WriterController extends Controller
{
    public function regisWriter($id_member)//ลงทะเบียนนักเขียน
    {
        try {
            $member = Member::findOrFail($id_member);
            $setBooks = SetBook::all();

            return view('regisWriter', compact('member', 'setBooks'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลนักเขียน: ' . $e->getMessage());
        }
    }

    public function regisWriterUp(Request $request,$id_member)//อัพเดตข้อมูลที่ลงทะเบียนลงในฐานข้อมูล
    {
        $request->validate([
            'Firstname' => 'required',
            'LastName' => 'required',
            'email' => 'required|email',
            'Phone' => 'required|digits:10',
        ], [
            'Phone.digits' => 'เบอร์โทรต้องมีความยาว 10 หลัก',
        ]);

        // Update member using update method
        $member = Member::findOrFail($id_member);

        $member->Firstname = $request->Firstname;
        $member->LastName = $request->LastName;
        $member->email = $request->email;
        $member->Phone = $request->Phone;
        $member->status = 'ผู้เขียน'; // Assuming 'status' is an attribute in your 'members' table

        $member->save();
        // Redirect back with success message
        return redirect('/home')->with('success', 'ข้อมูลนักเขียนถูกอัปเดตเรียบร้อยแล้ว');
    }

    public function writer()
    {
        $setBooks = SetBook::all();

        return view('writer', compact('setBooks'));
    }


    public function showWorks($id_member)//โชว์ผลงานนักเขียน
    {
        // ดึงข้อมูลนักเขียน
        $member = Member::findOrFail($id_member);

        if (!$member) {
            return redirect()->back()->with('error', 'ไม่พบนักเขียน');
        }

        // ดึงข้อมูลหนังสือของนักเขียน
        $books = Book::where('id_member', $id_member)->get();

        //นับจำนวนหนังสือที่อยู่แต่งอัพ
        $bookCount = Book::where('id_member', $id_member)->count();

        //นับจำนวนรีวิวและแสดงความคิดเห็นทั้งหมด
        $reviewCount = Review::whereIn('id_book', $books->pluck('id_book'))->count();
        //นับจำนวนรีวิวและแสดงความคิดเห็นตาม id_book
        $reviewsCountBybook = Review::whereIn('id_book', $books->pluck('id_book'))
        ->select('id_book', DB::raw('count(*) as count'))
        ->groupBy('id_book')
        ->get()
        ->pluck('count', 'id_book')
        ->toArray();

        //นับจำนวนรายการโปรดทั้งหมด
        $favoriteCount = bookShelf::whereIn('id_book', $books->pluck('id_book'))->count();
        //นับจำนวนรายการโปรดตาม id_book
        $favoriteCountBybook = bookShelf::whereIn('id_book', $books->pluck('id_book'))
        ->select('id_book', DB::raw('count(*) as count'))
        ->groupBy('id_book')
        ->get()
        ->pluck('count', 'id_book')
        ->toArray();

        //นับจำนวนการซื้อทั้งหมด
        $buyCount = Buy_Book::whereIn('id_book', $books->pluck('id_book'))->count();
        //นับจำนวนการซื้อตาม id_book
        $buyCountBybook = Buy_Book::whereIn('id_book', $books->pluck('id_book'))
        ->select('id_book', DB::raw('count(*) as count'))
        ->groupBy('id_book')
        ->get()
        ->pluck('count', 'id_book')
        ->toArray();

        //นับจำนวนเงินทั้งหมด
        $totalPrice = Buy_Book::whereIn('id_book', $books->pluck('id_book'))->sum('total_price');
        //นับจำนวนเงินแต่ละเล่ม
        $totalPriceBybook = Buy_Book::whereIn('id_book', $books->pluck('id_book'))
        ->select('id_book', DB::raw('sum(total_price) as sum'))
        ->groupBy('id_book')
        ->get()
        ->pluck('sum', 'id_book')
        ->toArray();

        //นับยอดวิว
        $totalViews = $books->sum('view_count');
        //นับยอดวิวแต่ละเล่ม
        $totalViewsBybook = Book::whereIn('id_book', $books->pluck('id_book'))
        ->select('id_book', DB::raw('sum(view_count) as sum'))
        ->groupBy('id_book')
        ->get()
        ->pluck('sum', 'id_book')
        ->toArray();

        $setBooks = SetBook::all();

        $loggedInMember = Auth::guard('member')->user();

        // นับจำนวนผู้ติดตามเรา
        $followersCount = DB::table('follow')
            ->where('id_follow', $loggedInMember->id_member)
            ->count();

        // นับจำนวนผู้ที่เรากำลังติดตาม
        $followingCount = DB::table('follow')
            ->where('id_member', $loggedInMember->id_member)
            ->count();

        return view('writer',
        compact('member', 'books','setBooks',
        'bookCount','reviewCount','reviewsCountBybook',
        'favoriteCount','favoriteCountBybook','buyCount',
        'totalPrice','totalPriceBybook','buyCountBybook','totalViews','totalViewsBybook',
        'followersCount', 'followingCount'));
    }

    public function editBookByid($id_book)
    {
        $book = Book::findOrFail($id_book);

        $setBooks = SetBook::all();

        return view('editbook', compact('setBooks','book'));
    }

    //update book for writer
    public function updateBook(Request $request, $id_book)
    {
        $book = Book::findOrFail($id_book);

        // ตรวจสอบให้แน่ใจว่าค่า name_book, price และ amount_page ไม่เป็นค่าว่าง
        $request->validate([
            'name_book' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'amount_page' => 'required|integer|min:0',
            'category' => 'required|exists:set_books,id_setbook',
            'image_book' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file_book' => 'nullable|file|mimes:pdf|max:20480', // จำกัดประเภทไฟล์และขนาดไฟล์
        ],[
            'name_book.required' => 'กรุณาระบุชื่อหนังสือ',
            'file_book.mimes' => 'กรุณาอัพโหลดเป็นไฟล์ pdf เท่านั้น ',
            'category.required' => 'กรุณาเลือกหมวดหมู่',
            'price.required' => 'กรุณาระบุราคา',
            'price.numeric' => 'กรุณาระบุราคาเป็นตัวเลข',
            'amount_page.required' => 'กรุณาระบุจำนวนหน้า',
            'amount_page.integer' => 'กรุณาระบุจำนวนหน้าเป็นตัวเลข',
        ]
    
    );
        

        // ตรวจสอบชื่อหนังสือว่ามีในระบบแล้วหรือไม่ (ยกเว้นตัวเอง)
        $existingBook = Book::where('name_book', $request->name_book)
            ->where('id_book', '!=', $id_book)
            ->first();

        if ($existingBook) {
            return redirect()->back()->with('error', 'ชื่อหนังสือนี้มีอยู่ในระบบแล้ว');
        } 

        $book->name_book = $request->name_book;
        $book->price = $request->price ?? 0;
        $book->amount_page = $request->amount_page ?? 0;
        $book->id_setbook = $request->category;


        // ตรวจสอบและอัปโหลดรูปภาพใหม่ถ้ามีการอัปโหลด
        if ($request->hasFile('image_book')) {
            $imageName = $request->image_book->getClientOriginalName();
            $request->image_book->move(public_path('images'), $imageName);
            $book->image_book = $imageName; // อัปเดตชื่อไฟล์ในฐานข้อมูล
        }

            // ตรวจสอบและอัปโหลดไฟล์หนังสือใหม่ถ้ามีการอัปโหลด
        if ($request->hasFile('file_book')) {
            if ($request->file('file_book')->getClientMimeType() !== 'application/pdf') {
                return redirect()->back()->with('error', 'กรุณาอัปโหลดไฟล์ PDF เท่านั้น.');
            }
            $fileName = $request->file_book->getClientOriginalName();
            $request->file_book->move(public_path('uploads'), $fileName);
            $book->file_book = $fileName; // อัปเดตชื่อไฟล์ในฐานข้อมูล
        }
        
        

        $book->save();

        $id_member = auth()->user()->id_member;

        // return redirect('/home')->with('success', 'ข้อมูลถูกอัปเดตเรียบร้อยแล้ว');
        // return redirect()->route('writer.showWorks', $id_member);
        return redirect()->route('writer.showWorks', $id_member)->with('success', 'ข้อมูลถูกอัปเดตเรียบร้อยแล้ว');
    }

    //delete book for writer
    public function deleteBook($id_book)
    {
        $book = Book::findOrFail($id_book);
        $book->delete();

        $id_member = auth()->user()->id_member;

        // return redirect('/home');
        return redirect()->route('writer.showWorks', $id_member);
    }

}
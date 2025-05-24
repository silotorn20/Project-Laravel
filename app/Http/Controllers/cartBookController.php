<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use App\Models\setBook;
use App\Models\Cart;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class cartBookController extends Controller
{
    public function cartBook()
    {
        $cartBooks = cartBook::all(); // Use the correct class name
        return view('cartBook', compact('cartBooks')); // Pass the data to the view
    }
    public function showcart($id_member)
    {
        //เข้าถึงข้อมูลในตาราง carts แล้วทำการทjoin 
        $showcart = DB::table('carts')
            ->join('book', 'carts.id_book', '=', 'book.id_book')
            ->join('members', 'carts.id_member', '=', 'members.id_member')
            ->where('carts.id_member', $id_member)
            ->select('book.*', 'book.name_book', 'book.image_book', 'book.price')
            ->distinct('book.id_book')
            ->get();
         //คำนวณหาราคารวม
        $totalPrice = $showcart->sum('price');
        //จะดึงข้อมูลทั้งหมดจาก SetBook เก็บไว้ในตัวแปล setBooks
        $setBooks = SetBook::all();
         //ส่งข้อมูล 3 ตัวคือ showcart totalPrice setBooks ไปยังหน้า cartBook
        return view('cartBook', ['showcart' => $showcart, 'totalPrice' => $totalPrice] ,compact('setBooks'));
    }

    public function removeBook($id_book)
    {
        //ดึงค่า id_member ของสมาชิกที่ล็อกอินอยู่ ผ่าน guard 
        $id_member = Auth::guard('member')->user()->id_member;

        // ค้นหาข้อมูลที่ตรงตาม id_book และ id_member
        $cartItem = Cart::where('id_book', $id_book)
                        ->where('id_member', $id_member)
                        ->firstOrFail();
        // ลบข้อมูลจากฐานข้อมูล
        $cartItem->delete();

        // Redirect ไปยังหน้า cartBook ของผู้ใช้
        return redirect()->route('cartBook', ['id_member' => $id_member])
                         ->with('success', 'Book removed successfully.');
    }

    public function checkout(Request $request)
    {
        $id_member = Auth::guard('member')->user()->id_member; // Get the ID of the logged-in member
        $showcart = DB::table('carts')
            ->join('book', 'carts.id_book', '=', 'book.id_book')
            ->join('members', 'carts.id_member', '=', 'members.id_member')
            ->where('carts.id_member', $id_member)
            ->select('book.*', 'book.name_book', 'book.image_book', 'book.price')
            ->get();

        $totalPrice = $showcart->sum('price'); // Calculate total price

        // Update the total price in the sum_price column of the carts table
        DB::table('carts')
            ->where('id_member', $id_member)
            ->update(['sum_price' => $totalPrice]);

        // Redirect to the payment page
        return redirect()->route('payment', ['id_member' => $id_member]);
    }

    public function addToCart(Request $request,$id_book)
    {
        $book = Book::find($id_book);

        $member = Auth::guard('member')->user();
        // ตรวจสอบว่าผู้ใช้ไม่สามารถเพิ่มหนังสือของตนเองเข้าตะกร้าได้
        if($book->id_member == $member->id_member){
            return redirect()->back()->with('error','คุณไม่สามารถเพิ่มเข้าตะกร้าได้');
          }
        // ตรวจสอบว่าหนังสืออยู่ในชั้นของผู้ใช้แล้วหรือไม่
        // $existingBookShelf = Cart::where('id_book', $id_book)
        //     ->where('id_member', $member->id_member)
        //     ->first();

        // if ($existingBookShelf) {
        //     return redirect()->back()->with('error', 'หนังสือเล่มนี้อยู่ในชั้นของคุณแล้ว');
        // }
         // ตรวจสอบว่าหนังสือมีอยู่ในตะกร้าแล้วหรือไม่
         $existingCartItem = Cart::where('id_book', $id_book)
         ->where('id_member', $member->id_member)
         ->where('status', 1) // เช็คเฉพาะหนังสือที่อยู่ในสถานะ "ตะกร้า" เท่านั้น
         ->first();
 
        if ($existingCartItem) {
            // ตั้งค่า session แจ้งเตือนว่ามีหนังสือในตะกร้าแล้ว
            // session(['book_in_cart' => true]); 
            return redirect()->back()->with('error', 'หนังสือเล่มนี้มีอยู่ในตะกร้าของคุณแล้ว');
         }
        // เพิ่มหนังสือเข้าไปในตะกร้า
        $cart = new Cart();
        $cart->date = Carbon::now()->toDateString();
        $cart->sum_price = $book->price;
        $cart->status = 1;
        $cart->id_book = $id_book;
        $cart->id_member = $member->id_member;

        $cart->save();

        return redirect()->back()->with('success', 'เพิ่มหนังสือเรียบร้อย!');
    }
}


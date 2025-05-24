<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use App\Models\setBook;
use App\Models\Cart;
use App\Models\Buy_Book;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class paymentController extends Controller
{
    public function payMent()
    {
        return view('payment');
    }


    public function showpayment($id_member)
    {
        $member = Auth::guard('member')->user();
         //เข้าถึงข้อมูลในตาราง carts แล้วทำการทjoin
        $showpayment = DB::table('carts')
            ->join('book', 'carts.id_book', '=', 'book.id_book')
            ->join('members', 'carts.id_member', '=', 'members.id_member')
            ->where('carts.id_member', '=', $id_member)
            ->select('book.name_book', 'book.price')
            ->get();
        //ดึงข้อมูลจจาก carts เพื่อจะเอา ราคารวมออกมาโชวื
        $totalPrice = DB::table('carts')
            ->where('id_member', $id_member)
            ->value('sum_price');
        // ดึงข้อมูลทั้งหมดจาก SetBook
        $setBooks = SetBook::all();
          //ส่งข้อมูล 3 ตัวคือ showpayment totalPrice setBooks ไปยังหน้า payment
        return view('payment', [ 'showpayment' => $showpayment, 'totalPrice' => $totalPrice,'member' => $member,],compact('setBooks'));
    }

    //เข้าไปในหน้าสั่งซื้อแล้ว
    public function add($id_member)
    {
        // ดึงข้อมูลจากตาราง cart ที่เกี่ยวข้องกับสมาชิก
        $carts = Cart::where('id_member', $id_member)->get();

        foreach ($carts as $cart) {
            // สร้างข้อมูลใหม่ในตาราง buy_book
            Buy_Book::create([
                'id_book' => $cart->id_book,
                'id_member' => $id_member,
                'total_price' => $cart->sum_price,
                'date' => now(),
                'status' => 2,
                // เพิ่มข้อมูลอื่น ๆ ตามที่ต้องการ
            ]);
        }

        // ลบข้อมูลในตาราง cart หลังจากบันทึกข้อมูลเสร็จ
        Cart::where('id_member', $id_member)->delete();

        // เปลี่ยนเส้นทางไปยังหน้าที่คุณต้องการหลังจากบันทึกเสร็จ
        return redirect()->route('showmyBook', $id_member);
    }
}

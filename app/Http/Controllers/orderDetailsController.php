<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\setBook;
use App\Models\Buy_Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class orderDetailsController extends Controller
{
    public function OrderDetails(){
        $setBooks = SetBook::all();

        return view('orderDetails', compact('setBooks'));
    }

    public function showOrderDetails($id_member)
    {
        $books = DB::table('buy_book')
            ->join('book', 'buy_book.id_book', '=', 'book.id_book')
            ->join('members', 'members.id_member', '=', 'buy_book.id_member')
            ->where('book.id_member', $id_member)
            ->where('buy_book.id_member', '<>', $id_member)
            ->select(
                'buy_book.idbuy_book',
                'members.Firstname',
                'book.name_book',
                'buy_book.total_price',
                'buy_book.date',
                'buy_book.status',
            )
            ->orderBy('buy_book.date', 'desc')  // เพิ่มคำสั่งนี้เพื่อเรียงลำดับตาม idbuy_book
            ->get();
            //  dump($books);
        // ส่งข้อมูลไปยัง view หรือคืนค่าเป็น JSON
        // return response()->json($books);
        $setBooks = SetBook::all();
        return view('orderDetails', compact('books','setBooks'));
    }

    public function updateStatus(Request $request, $idbuy_book)
    {
        // ตรวจสอบและอัปเดตสถานะในฐานข้อมูล
        $order = Buy_Book::find($idbuy_book);
        if ($order) {
            $order->status = $request->input('status');
            $order->save();

            return redirect()->back()->with('success', 'สถานะอัปเดตเรียบร้อย');
        } else {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลคำสั่งซื้อ');
        }
    }

}


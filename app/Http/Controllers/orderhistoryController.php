<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use App\Models\setBook;
use App\Models\carts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class orderhistoryController extends Controller
{
    public function orderHistory()
    {
        return view('orderHistory');
    }
    public function showOrderHistory($id_member)
    {
        $books = DB::table('buy_book')
            ->join('book', 'buy_book.id_book', '=', 'book.id_book')
            ->join('members', 'members.id_member', '=', 'buy_book.id_member')
            ->select(
                'buy_book.id_member',
                'book.name_book',
                'buy_book.total_price',
                'buy_book.date',
                
            )
            ->where('buy_book.id_member', '=', $id_member)
            ->get();
            //  dump($books);   
        // ส่งข้อมูลไปยัง view หรือคืนค่าเป็น JSON
        // return response()->json($books);
        $setBooks = SetBook::all();
        return view('orderHistory', compact('books','setBooks'));
    }

}

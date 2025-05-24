<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Book;
use App\Models\setBook;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
class searchControlloer extends Controller
{
    public function searchBook()
    {
        return view('searchBook');
    }

    public function showSearchbook($id_book)
    {
        $Book = Book::find($id_book);

        if (!$Book) {
            return view('searchBook')->with('message', 'Book not found');
        }

        // Fetch $setbook from database or initialize as empty array
        $setbook = DB::table('book')
            ->join('set_books', 'book.id_setbook', '=', 'set_books.id_setbook')
            ->join('members', 'book.id_member', '=', 'members.id_member')
            ->where('book.id_book', $id_book)
            ->select('book.*', 'set_books.nameSetBook')
            ->get();

        // Pass $setbook to the view
        return view('searchBook', compact('Book', 'setbook'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $searchBy = $request->input('search_by');
        $category = $request->input('category');



        $writers = [];
        $books = [];
        $bookCounts = [];
        $followersCount = [];
        $setBooks = DB::table('set_books')->get();
        if ($searchBy == 'writer') {
            $writers = Member::where(function($q) use ($query) {
                $q->where('Firstname', 'LIKE', "%{$query}%")
                  ->orWhere('Lastname', 'LIKE', "%{$query}%"); // Optionally search by Lastname
            })
            ->whereIn('status', ['ผู้เขียน', 'ผู้เขียนและผู้อ่าน']) // Status filter
            ->get();
            foreach ($writers as $writer) {
                $bookCounts[$writer->id_member] = Book::where('id_member', $writer->id_member)->count();
                }
            foreach ($writers as $writer) {
                // นับจำนวนผู้ติดตามสำหรับนักเขียนแต่ละคน
                $followersCount[$writer->id_member] = DB::table('follow')
                    ->where('id_follow', $writer->id_member)
                    ->count();
        }
        } else if ($searchBy == 'book') {
            $booksQuery = DB::table('book')
                ->join('set_books', 'book.id_setbook', '=', 'set_books.id_setbook')
                ->where('book.name_book', 'LIKE', "%{$query}%");

                if ($category && $category !== 'ทั้งหมด') {
                    $booksQuery->where('set_books.id_setbook', $category); // Filter by selected category ID
                }
                // if ($query) {
                //     $booksQuery->where('book.name_book', 'LIKE', "%{$query}%");
                // }
                $books = $booksQuery->select('book.*', 'set_books.nameSetBook')->get();
        }

        return view('searchWriter', compact('writers', 'books', 'setBooks','bookCounts','followersCount'));
    }



// public function search(Request $request)
// {
//     $query = $request->input('query');
//     $searchBy = $request->input('search_by');

//     $writers = [];
//     $books = [];

//     if ($searchBy == 'writer') {
//         $writers = Member::where('Firstname', 'LIKE', "%{$query}%")->get();
//     } else if ($searchBy == 'book') {
//         $books = DB::table('books')
//             ->join('set_books', 'books.id_setbook', '=', 'set_books.id_setbook')
//             ->join('members', 'books.id_member', '=', 'members.id_member')
//             ->where('books.name_book', 'LIKE', "%{$query}%")
//             ->select('books.*', 'set_books.nameSetBook', 'members.Firstname')
//             ->get();
//     }

//     return view('searchWriter', compact('writers', 'books'));
// }

}

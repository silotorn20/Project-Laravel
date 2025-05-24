<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\bookShelf;
use App\Models\setBook;
use App\Models\Review;
use App\Models\Follow;
use App\Models\Member;
use App\Models\Buy_Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookController extends Controller
{
    public function show($id_book)//ดึงข้อมูลหนังสือตาม id_book
    {
        $Book = Book::find($id_book);
        $setbook = DB::table('book')
                    ->join('set_books', 'book.id_setbook', '=', 'set_books.id_setbook')
                    ->join('members', 'book.id_member', '=', 'members.id_member')
                    ->where('book.id_book', $id_book)
                    ->select('book.*', 'set_books.nameSetBook','members.Firstname')
                    ->get();
        //  return response()->json(  $setbook);
        if (!$Book) {
            return view('bookPage')->with('message', 'Book not found');
        }

        $book = Book::findOrFail($id_book);

        // เพิ่มจำนวนการเข้าชม
        $book->view_count += 1;
        $book->save();


       // ดึง ID ของสมาชิกที่ล็อกอินอยู่
       $id_member = Auth::id(); // ใช้เพื่อดึง ID ของสมาชิกที่ล็อกอินอยู่

       // ตรวจสอบว่าสมาชิกคนนี้ได้ทำการซื้อหนังสือเล่มนี้หรือไม่
       $hasPurchased = Buy_Book::where('id_member', $id_member)
           ->where('id_book', $id_book)
           ->exists(); // ใช้ exists() เพื่อเช็คว่ามีการซื้อหนังสือหรือไม่
        $setBooks = SetBook::all();
        $books = Book::where('id_member', $Book->id_member)->get();
        $reviewsCountBybook = Review::whereIn('id_book', $books->pluck('id_book'))
        ->select('id_book', DB::raw('count(*) as count'))
        ->groupBy('id_book')
        ->get()
        ->pluck('count', 'id_book')
        ->toArray();

        // Count total views for the book
        $totalViewsBybook = Book::whereIn('id_book', $books->pluck('id_book'))
            ->select('id_book', DB::raw('sum(view_count) as sum'))
            ->groupBy('id_book')
            ->get()
            ->pluck('sum', 'id_book')
            ->toArray();

        $author = Member::findOrFail($book->id_member); // หาข้อมูลสมาชิกที่เป็นผู้เขียน

        $loggedInMember = Auth::guard('member')->user(); //

         // ดึงข้อมูล myBooks ของผู้ใช้ที่ล็อกอินอยู่
        //  $myBooks = Auth::guard('member')->check()
        // ? DB::table('buy_book')
        //     ->where('id_member', Auth::guard('member')->id())
        //     ->pluck('id_book')
        //     ->toArray()
        // : [];
        // Return the view with the relevant data
        return view('bookPage', compact('Book', 'setbook', 'setBooks', 'reviewsCountBybook', 'totalViewsBybook','book','author','loggedInMember', 'hasPurchased'))
        ->with('success', 'เพิ่มหนังสือในตะกร้าแล้ว');
    }

    public function showAllBooks()
    {
        if (!Auth::guard('member')->check()) {
            return redirect('/login')->with('error', 'กรุณาเข้าสู่ระบบ');
        }

        $memberId = Auth::guard('member')->id();

        // ดึงข้อมูลหนังสือทั้งหมด
        $books = DB::table('book')
            ->join('set_books', 'book.id_setbook', '=', 'set_books.id_setbook')
            ->join('members', 'book.id_member', '=', 'members.id_member')
            ->select('book.*', 'set_books.nameSetBook', 'members.Firstname')
            ->orderBy('book.id_book', 'asc')
            ->get();

            //   return response()->json( $books);
            $setBooks = SetBook::all();


        // ดึงข้อมูลหนังสือที่ขายดี 5 อันดับแรก
        $topBookIds = DB::table('buy_book')
        ->select('id_book', DB::raw('COUNT(DISTINCT id_member) as member_count'))
        ->groupBy('id_book')
        ->orderBy('member_count', 'desc')
        ->limit(5)
        ->pluck('id_book') // ดึงแค่ id_book
        ->toArray();

        $topBooks = DB::table('book')
            ->join('set_books', 'book.id_setbook', '=', 'set_books.id_setbook')
            ->join('members', 'book.id_member', '=', 'members.id_member')
            ->whereIn('book.id_book', $topBookIds) // ใช้ id_book ที่ได้
            ->select('book.*', 'set_books.nameSetBook', 'members.Firstname')
            ->orderByRaw('FIELD(book.id_book, ' . implode(',', $topBookIds) . ')') // เรียงลำดับตาม $topBookIds
            ->get();

        $otherBooks = DB::table('book')
            ->join('set_books', 'book.id_setbook', '=', 'set_books.id_setbook')
            ->join('members', 'book.id_member', '=', 'members.id_member')
            ->whereNotIn('book.id_book', $topBookIds) // กรองออก 5 อันดับแรก
            ->select('book.*', 'set_books.nameSetBook', 'members.Firstname')
            ->inRandomOrder()
            ->get();

        // ดึงหนังสือจากนักเขียนที่ผู้ใช้ติดตาม
        $followingAuthorIds = DB::table('follow')
        ->where('id_member', $memberId)
        ->pluck('id_follow')
        ->toArray();

          // ตรวจสอบว่าผู้ใช้ติดตามนักเขียนหรือไม่
          if (!empty($followingAuthorIds)) {
            // สร้างคอลเล็กชันว่างเพื่อเก็บหนังสือที่ติดตาม
            $followedBooksCollection = collect();

            // ดึงหนังสือจากนักเขียนที่ผู้ใช้ติดตามแต่ละคน
            foreach ($followingAuthorIds as $authorId) {
                $booksByAuthor = DB::table('book')
                    ->join('set_books', 'book.id_setbook', '=', 'set_books.id_setbook')
                    ->join('members', 'book.id_member', '=', 'members.id_member')
                    ->where('book.id_member', $authorId)
                    ->whereNotIn('book.id_book', $topBookIds)
                    ->select('book.id_book', 'book.*', 'set_books.nameSetBook', 'members.Firstname')
                    ->inRandomOrder() // สุ่มเรื่อง
                    ->limit(3) // จำกัดเรื่องละ 2 เรื่องต่อหนึ่งนักเขียน
                    ->get();

                // รวมหนังสือแต่ละนักเขียนเข้าไปในคอลเล็กชันหลัก
                $followedBooksCollection = $followedBooksCollection->merge($booksByAuthor);
            }

            // ดึง ID ของหนังสือที่ติดตามเพื่อนำไปกรอง
            $followedBookIds = $followedBooksCollection->pluck('id_book')->toArray();

            // ดึงหนังสืออื่นๆ โดยไม่รวมหนังสือที่ติดตาม
            $otherBooks = DB::table('book')
                ->join('set_books', 'book.id_setbook', '=', 'set_books.id_setbook')
                ->join('members', 'book.id_member', '=', 'members.id_member')
                ->whereNotIn('book.id_book', $followedBookIds) // กรองหนังสือที่ซ้ำ
                ->whereNotIn('book.id_book', $topBookIds)
                ->select('book.*', 'set_books.nameSetBook', 'members.Firstname')
                ->inRandomOrder()
                ->get();

            // แสดงหนังสือที่ผู้ใช้ติดตามเป็นอันดับแรก และรวมกับหนังสืออื่นๆ ที่ไม่ซ้ำ
            $booksToDisplay = $followedBooksCollection->merge($otherBooks);
        } else {
            // ถ้ายังไม่ติดตามนักเขียนใดๆ ให้แสดงหนังสืออื่นๆ
            $booksToDisplay = $otherBooks;
        }

        return view('home', compact('setBooks','books', 'topBooks','booksToDisplay'));
    }
        // ดึงข้อมูลหนังสือทั้งหมด


    public function showAll()
    {
        // ดึงข้อมูลหนังสือทั้งหมด
        $books = DB::table('book')
        ->join('set_books', 'book.id_setbook', '=', 'set_books.id_setbook')
        ->join('members', 'book.id_member', '=', 'members.id_member')
        ->select('book.*', 'set_books.nameSetBook', 'members.Firstname')
        ->orderBy('book.id_book', 'asc')
        ->get();

        //   return response()->json( $books);
        $setBooks = SetBook::all();


        // ดึงข้อมูลหนังสือที่ขายดี 5 อันดับแรก
        $topBookIds = DB::table('buy_book')
            ->select('id_book', DB::raw('COUNT(DISTINCT id_member) as member_count'))
            ->groupBy('id_book')
            ->orderBy('member_count', 'desc')
            ->limit(5)
            ->pluck('id_book') // ดึงแค่ id_book
            ->toArray();

        $topBooks = DB::table('book')
            ->join('set_books', 'book.id_setbook', '=', 'set_books.id_setbook')
            ->join('members', 'book.id_member', '=', 'members.id_member')
            ->whereIn('book.id_book', $topBookIds) // ใช้ id_book ที่ได้
            ->orderByRaw('FIELD(book.id_book, ' . implode(',', $topBookIds) . ')') // เรียงลำดับตาม $topBookIds
            ->get();

        $otherBooks = DB::table('book')
            ->join('set_books', 'book.id_setbook', '=', 'set_books.id_setbook')
            ->join('members', 'book.id_member', '=', 'members.id_member')
            ->whereNotIn('book.id_book', $topBookIds) // กรองออก 5 อันดับแรก
            ->select('book.*', 'set_books.nameSetBook', 'members.Firstname')
            // ->orderBy('book.id_book', 'asc')
            ->inRandomOrder()
            ->get();
        return view('welcome', compact('setBooks','books', 'topBooks','otherBooks'));
    }
    //historyRead
    public function historyRead($id_member)
    {
        $historyRead = DB::table('read_book')
        ->join('book', 'read_book.id_book', '=', 'book.id_book')
        ->join('members as authors', 'book.id_member', '=', 'authors.id_member') // join กับตาราง members สำหรับผู้เขียน
        ->where('read_book.id_member', $id_member) // ดึงข้อมูลตาม id_member
        ->select('read_book.*', 'book.name_book', 'authors.Firstname as author_firstname', 'book.image_book') // ดึงชื่อผู้เขียน
        ->get();

        $setBooks = SetBook::all();

        return view('historyRead', compact('historyRead','setBooks'));

    }

    public function review()
    {
        $setBooks = SetBook::all();

        return view('review', compact('setBooks'));
    }
    //book_shelf
    public function showBooksByMember($id_member)
    {
        // ดึงข้อมูลหนังสือตาม id_MEMBER
        $books = DB::table('book_shelf')
        ->join('book', 'book_shelf.id_book', '=', 'book.id_book')
        ->join('members', 'members.id_member', '=', 'book.id_member')
        ->join('set_books', 'book.id_setbook', '=', 'set_books.id_setbook')
        ->select('book.*', 'set_books.nameSetBook', 'members.Firstname')
            ->where('book_shelf.id_member', '=', $id_member)
            ->orderBy('book.id_book', 'asc')
            ->distinct('book.id_book')
            ->get();
            $setBooks = setBook::all();
        return view('bookShelf', compact('setBooks', 'books'));
    }

    //show pdf and show review
    public function showPdf($id_book)
    {
        $book = Book::find($id_book);

        $reviews = DB::table('reviews')
        ->join('members', 'reviews.id_member', '=', 'members.id_member')
        ->select('reviews.*', 'members.Firstname','members.profile')
        ->where('reviews.id_book', $id_book)
        ->orderBy('reviews.score_review', 'desc')
        ->get();

        $pdfUrl = '../../public/uploads/' . $book->file_book;

        return view('pdf-viewer', ['pdfUrl' => $pdfUrl,'id_book' => $id_book,'reviews' => $reviews]);
    }

     // ฟังก์ชันสำหรับการเพิ่มข้อมูลเข้าชั้น
     public function addToShelf(Request $request,$id_book)
     {
            $book = Book::find($id_book);
            $member = Auth::guard('member')->user();

            if($book->id_member == $member->id_member){
                return redirect()->back()->with('error','คุณไม่สามารถเพิ่มเข้าชั้นหนังสือได้');
              }

            $existingBookShelf = bookShelf::where('id_book', $id_book)
              ->where('id_member', $member->id_member)
              ->first();

            if ($existingBookShelf) {
                return redirect()->back()->with('error', 'หนังสือเล่มนี้อยู่ในชั้นของคุณแล้ว');
            }

            $bookSelf = new bookShelf();
            $bookSelf->id_book = $id_book;
            $bookSelf->id_member = $member->id_member;

            $bookSelf->save();

         // ส่งกลับหรือแสดงผลตามต้องการ
         return redirect()->back()->with('success', 'เพิ่มเข้าชั้นเรียบร้อย');
    }

     public function removeBookShelf($id_book)
    {
        $id_member = Auth::guard('member')->user()->id_member;
        // $id_member = Auth::id(); // รับ id ของผู้ใช้ที่เข้าสู่ระบบ
        // $id_member =  3; //testการลบ ฟิกค่า id_member///////////////////////////////////////////
        // ค้นหาข้อมูลที่ตรงตาม id_book และ id_member
        $bookShelfItem = bookShelf ::where('id_book', $id_book)
                              ->where('id_member', $id_member)
                              ->firstOrFail();
        // ลบข้อมูลจากฐานข้อมูล
        $bookShelfItem->delete();

        // Redirect ไปยังหน้า cartBook ของผู้ใช้
        return redirect()->route('bookShelf', ['id_member' => $id_member])
                         ->with('success', 'Book removed successfully.');
    }

     //showmyBook
     public function showmyBook($id_member)
     {
         // ดึงข้อมูลหนังสือตาม id_MEMBER
         $books = DB::table('buy_book')
                 ->join('book', 'buy_book.id_book', '=', 'book.id_book')
                 ->join('members', 'members.id_member', '=', 'book.id_member')
                 ->join('set_books', 'book.id_setbook', '=', 'set_books.id_setbook')
                 ->select('book.*', 'set_books.nameSetBook', 'members.Firstname', 'buy_book.status')
                   ->where('buy_book.id_member', '=', $id_member)
                   ->orderBy('book.id_book', 'asc')
                   ->distinct('book.id_book') //ใช้ distinct เพื่อให้แน่ใจว่าหนังสือแต่ละเล่มปรากฏเพียงครั้งเดียวในผลลัพธ์
                   ->get();

         $setBooks = setBook::all();

         return view('myBook', compact('setBooks', 'books'));

     }

     //show pdf and show review
     public function showPdfmybook($id_book)
     {
        //ค้นหาข้อมูลหนังสือตาม id_book
         $book = Book::find($id_book);
        //ดึงข้อมูลจากตารางรีวิว
         $reviews = DB::table('reviews')
         ->join('members', 'reviews.id_member', '=', 'members.id_member')
         ->select('reviews.*', 'members.Firstname','members.profile')
         ->where('reviews.id_book', $id_book)
         ->orderBy('reviews.score_review', 'desc')
         ->get();
        //ดึงไฟล์ pdf ที่ถูกบันทึกแล้วเอามาเก็บไว้ในตัวแปล pdfUrl
         $pdfUrl = '../../public/uploads/' . $book->file_book;
          //ส่งข้อมูล 2 ตัวคือ pdfUrl reviews  ไปยังหน้า readpdf
         return view('readpdf', ['pdfUrl' => $pdfUrl,'id_book' => $id_book,'reviews' => $reviews]);
     }

     //เก็บประวัติการอ่านลงฐานข้อมูล
     public function storeReadBook(Request $request, $id_book)
    {
        $member = Auth::guard('member')->user();

        // ตรวจสอบว่าหนังสือเคยถูกอ่านหรือไม่
        $existingRead = DB::table('read_book')
                            ->where('id_book', $id_book)
                            ->where('id_member', $member->id_member)
                            ->first();

        if (!$existingRead) {
            // ถ้าไม่เคยถูกอ่าน ให้บันทึกข้อมูลใหม่
            DB::table('read_book')->insert([
                'date' => now(),
                'id_book' => $id_book,
                'id_member' => $member->id_member,
            ]);
        } else{
             // ถ้าเคยถูกอ่าน ให้บันทึกวันที่ใหม่
        DB::table('read_book')
            ->where('id_book', $id_book)
            ->where('id_member', $member->id_member)
            ->update([
                'date' => now(),
            ]);
        }

        return redirect()->route('books.showPdfmybook', $id_book);
    }
}

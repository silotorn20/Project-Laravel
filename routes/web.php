<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SetBookController;
use App\Http\Controllers\WriterController;
use App\Http\Controllers\UploadManager;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\searchControlloer;
use App\Http\Controllers\cartBookController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\orderhistoryController;
use App\Http\Controllers\orderDetailsController;
use App\Http\Controllers\reviewController;
use App\Http\Controllers\FollowController;
use App\Models\setBook;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $setBooks = SetBook::all();

    return view('welcome', compact('setBooks'));
});
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login');
Route::get('/home', [AuthController::class, 'home'])->name('home');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

//หมวดหมู่
Route::get('/setBook', [SetBookController::class, 'setBook'])->name('setBook');
Route::get('/addSetBook', [SetBookController::class, 'addSetBook'])->name('addSetBook');
Route::post('/addSetBook', [SetBookController::class, 'addSetBookPost'])->name('addSetBook');
Route::get('/editSetBook/{id}', [SetBookController::class, 'editSetBook'])->name('editSetBook');
Route::put('/editSetBook/{id}', [SetBookController::class, 'updateSetBook'])->name('editSetBook');
Route::delete('/deleteSetBook/{id}', [SetBookController::class, 'deleteSetBook'])->name('deleteSetBook');

//ลงทะเบียนนักเขียน
Route::get('/regisWriter/{id_member}', [WriterController::class, 'regisWriter'])->name('regisWriter');
Route::put('/regisWriter/{id_member}', [WriterController::class, 'regisWriterUp'])->name('updateWriter');

Route::get('/writer', [WriterController::class, 'writer'])->name('writer');

//for writer
Route::get('/addbook', [UploadManager::class, 'addbook'])->name('addbook');
Route::post('/addbook', [UploadManager::class, 'uploadPost'])->name('upload.post');
// Route::get('/editwriter', [WriterController::class, 'editBook'])->name('editwriter');
Route::get('/editbook/{id_book}', [WriterController::class, 'editBookByid'])->name('editbook');
Route::put('/editbook/{id_book}', [WriterController::class, 'updateBook'])->name('editbook');
Route::delete('/deleteBook/{id_book}',[WriterController::class, 'deleteBook'])->name('deleteBook');
Route::get('/writer/{id_member}', [WriterController::class, 'showWorks'])->name('writer.showWorks');

//for admin
Route::get('/show', [MemberController::class, 'show']);
Route::get('/addMember', [MemberController::class, 'addMember'])->name('addMember');
Route::post('/addMember', [MemberController::class, 'addMemberPost'])->name('addMember');
Route::get('/editMember/{id_member}', [MemberController::class, 'editmember'])->name('editmember');
Route::put('/editMember/{id_member}', [MemberController::class, 'MemberUp'])->name('Update');
Route::delete('/deleteMember/{id_member}',[MemberController::class, 'deleteMember'])->name('deleteMember');
Route::get('/searchMembers', [MemberController::class, 'search'])->name('searchMembers');

//book
Route::get('/bookPage/{id_book}', [BookController::class, 'show'])->name('book.show');
Route::get('/book/{id_book}', [BookController::class, 'showAll'])->name('book.show');
Route::get('/home', [BookController::class, 'showAllBooks'])->name('home');
Route::get('/', [BookController::class, 'showAll']);
Route::get('/historyRead/{id_member}', [BookController::class, 'historyRead']);

//เช้คว่าแจ้งเตือนว่ามีหนังสือในตะกร้าแล้ว
// Route::post('/cart/add/{id_book}', [BookController::class, 'addToCart'])->name('cart.add');
// ติดตามผู้ใช้และยกเลิกการติดตามผู้ใช้
Route::get('/follow/{id_follow}', [FollowController::class, 'follow'])->name('member.follow');
Route::get('/unfollow/{id_follow}', [FollowController::class, 'unfollow'])->name('member.unfollow');

//profile
Route::get('/profile/{id_member}', [MemberController::class, 'profile'])->name('profile');
Route::get('/editProfile/{id_member}', [MemberController::class, 'editprofile'])->name('editprofile');
Route::put('/editProfile/{id_member}', [MemberController::class, 'profileUp'])->name('UpProfile');

Route::get('/searchBook', [searchControlloer::class, 'searchBook'])->name('searchBook');
Route::get('/search', [searchControlloer::class, 'search'])->name('search');

Route::get('/cart/add/{id_book}', [cartBookController::class, 'addToCart'])->name('cart.add');

Route::get('/cartBook/{id_member}', [cartBookController::class, 'showcart'])->name('cartBook');
Route::delete('/cartBook/{id_cart}', [cartBookController::class, 'removeBook'])->name('cartBooks.remove');

Route::get('/bookShelf/{id_member}', [BookController::class, 'showBooksByMember'])->name('bookShelf');
Route::get('/bookShelf/add/{id_book}', [BookController::class, 'addToShelf'])->name('bookShelf.add');
Route::delete('/bookShelf/{id}', [BookController::class, 'removeBookShelf'])->name('BookShelfs.remove');

// Route::get('/{setBook}', [SetBookController::class, 'show'])->name('welcome.show');

//ทดลองอ่าน
Route::get('/review', [BookController::class, 'review'])->name('review');
Route::post('/books/{id_book}/pdf', [reviewController::class, 'review'])->name('reviews.store');
Route::get('/books/{id_book}/pdf', [BookController::class, 'showPdf'])->name('books.showPdf');

//showmyBook and readBook
Route::get('/showmyBook/{id_member}', [BookController::class, 'showmyBook'])->name('showmyBook');
Route::post('/Mybooks/{id_book}/pdf', [reviewController::class, 'reviewMybook'])->name('reviews.storeMybbok');
Route::get('/Mybooks/{id_book}/pdf', [BookController::class, 'showPdfmybook'])->name('books.showPdfmybook');
Route::get('/pdf-viewer/{id_book}', [BookController::class, 'showPdfmybook'])->name('pdf.viewer');

Route::post('/checkout', [cartBookController::class, 'checkout'])->name('checkout');
Route::get('/payment/{id_member}', [paymentController::class, 'showpayment'])->name('payment');
Route::post('/checkpayment/add/{id_member}', [paymentController::class, 'add'])->name('checkpayment.add');


// Route::get('/mybook/{id_member}', [paymentController::class, 'myBook'])->name('myBook');
// Route::get('/checkpayment/{id_cart}/{id_book}', [paymentController::class, 'checkpayment'])->name('checkpayment.add');

Route::get('/OrderHistory/{id_member}', [orderhistoryController::class, 'showOrderHistory']);

// Route::get('/OrderDetails', [orderDetailsController::class, 'OrderDetails'])->name('orderDetail');
Route::get('/OrderDetails/{id_member}', [orderDetailsController::class, 'showOrderDetails'])->name('orderDetails');
Route::post('/update-status/{idbuy_book}', [orderDetailsController::class, 'updateStatus'])->name('update.status');

Route::post('/books/read/{id_book}', [BookController::class, 'storeReadBook'])->name('books.storeReadBook');

Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return 'Connection successful!';
    } catch (\Exception $e) {
        return 'Connection failed: ' . $e->getMessage();
    }
});

//Login google
Route::get('/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');


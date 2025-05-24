<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bookShelf extends Model
{
    use HasFactory;

    protected $table = 'book_shelf';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_book',
        'id_member',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'id_book');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }
}

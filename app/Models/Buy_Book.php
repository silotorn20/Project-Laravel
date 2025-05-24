<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy_Book extends Model
{
    use HasFactory;

    protected $table = 'buy_book';
    protected $primaryKey = 'idbuy_book';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_cart',
        'id_book',
        'id_member',
        'total_price',
        'date',
        'status',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'id_cart');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'id_book');
    }
}

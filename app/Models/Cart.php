<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'id_cart';

    protected $fillable = [
        'date',
        'sum_price',
        'status',
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

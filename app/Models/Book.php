<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'book';
    protected $primaryKey = 'id_book';


    protected $fillable = [
        'id_setbook',
        'id_member',
        'name_book',
        'image_book',
        'file_book',
        'price',
        'amount_page',
        'view_count',
    ];

    public function setbook()
    {
        return $this->belongsTo(setBook::class, 'id_setbook');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }
}

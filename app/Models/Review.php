<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $primaryKey = 'id_review';
    public $timestamps = false;

    protected $fillable = [
        'score_review',
        'detail',
        'date',
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

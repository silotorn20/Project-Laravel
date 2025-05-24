<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Read_Book extends Model
{
    use HasFactory;

    protected $table = 'read_book';
    protected $primaryKey = 'id_read';
    public $incrementing = false;

    protected $fillable = [
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

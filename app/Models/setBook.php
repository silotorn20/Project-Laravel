<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class setBook extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'set_books';
    protected $primaryKey = 'id_setbook';
    public $timestamps = false;

    protected $fillable = [
        'nameSetBook',
    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $table = 'follow';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable =[
        'id_member',
        'id_follow'
    ];

    public function follower()
    {
        return $this->belongsTo(Member::class, 'id_member'); // or User::class if using users table
    }

    // Define relationship for the following (the member being followed)
    public function following()
    {
        return $this->belongsTo(Member::class, 'id_follow'); // or User::class if using users table
    }
}

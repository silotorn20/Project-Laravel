<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'members';
    protected $primaryKey = 'id_member';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard = 'member';
    protected $fillable = [
        'Firstname',
        'LastName',
        'email',
        'password',
        'profile',
        'Phone',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

     // ฟังก์ชันความสัมพันธ์สำหรับการติดตาม
     public function following()
     {
         return $this->hasMany(Follow::class, 'id_member');
     }

     // Define the relationship to get all the members who are following this member
     public function follower()
     {
         return $this->hasMany(Follow::class, 'id_follow');
     }

     // Check if this member is following another member
     public function isFollowing($id_member)
     {
         return $this->following()->where('id_follow', $id_member)->exists();
     }
}

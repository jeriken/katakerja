<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class UserModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'id_role',
        'tglLahir',
        'telp',
        'member_sejak',
        'staff_sejak',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function borrow()
    {
        return $this->hasMany(BorrowModel::class);
    }

    public function wish()
    {
        return $this->hasMany(WishModel::class);
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishModel extends Model
{
    use HasFactory;

    protected $table = 'wish';

    protected $fillable = [
        'user_id',
        'book_id'
    ];

    public function books(){
        return $this->belongsTo(BookModel::class,'book_id','id');
    }

    public function users(){
        return $this->belongsTo(UserModel::class,'user_id','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowModel extends Model
{
    use HasFactory;

    protected $table = 'borrows';

    protected $fillable = [
        'user_id',
        'book_id',
        'borrow_date',
        'return_date',
        'status'
    ];

    public function books(){
        return $this->belongsTo(BookModel::class,'book_id','id');
    }

    public function users(){
        return $this->belongsTo(UserModel::class,'user_id','id');
    }

}

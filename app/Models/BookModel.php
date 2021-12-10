<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookModel extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'isbn',
        'judul',
        'author',
        'foto_buku',
        'tahun_terbit',
        'penerbit',
        'kategori',
        'stock',
        'deskripsi'
    ];

    public function borrow()
    {
        return $this->hasMany(BorrowModel::class);
    }
}

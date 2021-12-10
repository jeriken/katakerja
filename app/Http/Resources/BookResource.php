<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'isbn' => $this->isbn,
            'judul' => $this->judul,
            'author' => $this->author,
            'foto_buku' => $this->foto_buku,
            'tahun_terbit' => $this->tahun_terbit,
            'penerbit' => $this->penerbit,
            'kategori' => $this->kategori,
            'stock' => $this->stock,
            'deskripsi' => $this->deskripsi,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}

<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\BookResource as BookResource;
use App\Models\BookModel as Book;
use Illuminate\Support\Facades\Auth;
use Validator;

use Illuminate\Http\Request;

class BookController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $book = Book::paginate(10);

        return $this->sendResponse(new BookResource($book), 'Books retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);

        if (is_null($book)) {
            return $this->sendError('Book not found.');
        }

        return $this->sendResponse(new BookResource($book), 'Books retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function isbn($id)
    {
        $book = Book::where('isbn',$id)->paginate(10);

        if (is_null($book)) {
            return $this->sendError('Book not found.');
        }

        return $this->sendResponse(new BookResource($book), 'Book retrieved successfully.');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $input = $request->all();
        $book = Book::query()->where('judul', 'LIKE', "%{$input['q']}%")->paginate(10);

        return $this->sendResponse(new BookResource($book), 'Book retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function category($id)
    {
        $book = Book::where('kategori', $id)->paginate(10);

        if (is_null($book)) {
            return $this->sendError('Book not found.');
        }

        return $this->sendResponse(new BookResource($book), 'Book retrieved successfully.');
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'isbn' => 'required|max:50',
            'judul' => 'required',
            'author' => 'required|max:20',
            'foto_buku' => 'required',
            'tahun_terbit' => 'required|numeric',
            'penerbit' => 'required',
            'kategori' => 'required',
            'stock' => 'required|numeric',
            'deskripsi' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $book = Book::create($input);

        return $this->sendResponse(new BookResource($book), 'Add book succesfull');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();
        $book = book::findOrFail($id);
        $book->update($input);

        return $this->sendResponse(new BookResource($book), 'Books updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return $this->sendResponse([], 'Books deleted successfully.');
    }
}

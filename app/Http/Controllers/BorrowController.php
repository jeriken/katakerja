<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\BorrowModel as Borrow;
use App\Http\Resources\BorrowResource as BorrowResource;
use Validator;

use Illuminate\Http\Request;

class BorrowController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $borrow = Borrow::with('books','users')->paginate(10);

        return $this->sendResponse(new BorrowResource($borrow), 'Borrow retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $borrow = Borrow::find($id)->with('books','users')->paginate(10);

        if (is_null($borrow)) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse(new BorrowResource($borrow), 'Borrow retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function byuser($id)
    {
        $borrow = Borrow::where('user_id', $id)->with('books','users')->paginate(10);

        if (is_null($borrow)) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse(new BorrowResource($borrow), 'Borrow retrieved successfully.');
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'book_id' => 'required|numeric',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date',
            'status' => 'required|max:4',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $borrow = Borrow::create($input);

        return $this->sendResponse(new BorrowResource($borrow), 'Add borrow succesfull');
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
        $borrow = borrow::findOrFail($id);
        $borrow->update($input);

        return $this->sendResponse(new BorrowResource($borrow), 'Borrow updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $borrow = Borrow::findOrFail($id);
        $borrow->delete();

        return $this->sendResponse([], 'Borrow deleted successfully.');
    }
}

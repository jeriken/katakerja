<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\WishModel as Wish;
use App\Http\Resources\WishResource as WishResource;
use Validator;

use Illuminate\Http\Request;

class WishController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wish = Wish::with('books','users')->paginate(10);

        return $this->sendResponse(new WishResource($wish), 'Wish retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wish = Wish::find($id);

        if (is_null($wish)) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse(new WishResource($wish), 'Wish retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function byuser($id)
    {
        $wish = Wish::where('user_id', $id)->with('books','users')->get();

        if (is_null($wish)) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse(new WishResource($wish), 'Borrow retrieved successfully.');
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
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $wish = Wish::create($input);

        return $this->sendResponse(new WishResource($wish), 'Add wish succesfull');
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
        $wish = wish::findOrFail($id);
        $wish->update($input);

        return $this->sendResponse(new WishResource($wish), 'Wish updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wish = Wish::findOrFail($id);
        $wish->delete();

        return $this->sendResponse([], 'Wish deleted successfully.');
    }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\UserResource as UserResource;
use App\Models\UserModel as User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::paginate(10);

        return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id)->paginate(10);

        if (is_null($user)) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'id_role' => 'required',
            'telp' => 'required|max:20',
            'member_sejak' => 'required|date',
            'staff_sejak' => 'required|date',
            'email' => 'required|email',
            'tglLahir' => 'required|date',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('KKOkeJoss')->accessToken;
        $success['id'] =  $user->id;
        $success['name'] =  $user->name;
        $success['id_role'] =  $user->id_role;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('KKOkeJoss')->accessToken;
            $success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['id_role'] =  $user->id_role;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
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
        $user = User::findOrFail($id);
        $user->update($input);

        return $this->sendResponse(new UserResource($user), 'User updated successfully.');
    }
}

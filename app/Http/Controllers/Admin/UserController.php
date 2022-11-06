<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        if (!$users) {
            return response(['message' => 'Not found'], 204);
        }

        return response([ 'users' => UserResource::collection($users),
            'message' => 'Successful'], 200);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response(['message' => 'Not found'], 204);
        }

        return response([ 'user' => new UserResource($user), 'message' => 'Success'], 200);

    }

    public function update(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => 'required|integer',
            'name' => 'required|string',
            'email' => 'required|email',
        ]);


        if($validator->fails()){
            return response(['error' => $validator->errors(),
                'Validation Error']);
        }

        $result = User::where('id', $data['id'])
            ->update($request->only(
                ['name','email'])
            );

        return response(['message' => $result], 200);

    }
}

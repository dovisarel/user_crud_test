<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getAll()
    {
        $users = User::orderBy('last_updated_time', 'desc')->get();

        return response()->json($users);
    }

    public function get($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->first_name = $request->post('first_name');
        $user->last_name = $request->post('last_name');
        $user->email = $request->post('email');
        $user->username = $request->post('username');
        $user->is_active = $request->post('is_active');

        if( $request->post('password') ){
            $user->password = $request->post('password');
        }

        if( ! $user->IsValidate() ){
            return response()->json([
                'success' => false,
                'msg' => 'User data not valid.',
            ]);
        }

        $user->save();

        return response()->json([
            'success' => true,
        ]);
    }

    public function delete($id)
    {
        $user = User::find($id);

        if( $user ){
            $user->delete();
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function create(Request $request)
    {
        $user = new User;

        $user->first_name = $request->post('first_name');
        $user->last_name = $request->post('last_name');
        $user->email = $request->post('email');
        $user->username = $request->post('username');
        $user->password = $request->post('password');
        $user->is_active = $request->post('is_active');

        if( ! $user->IsValidate() ){
            return response()->json([
                'success' => false,
                'msg' => 'User data not valid.',
            ]);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'id' => $user->id,
        ]);
    }
}
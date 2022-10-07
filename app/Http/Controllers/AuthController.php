<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
class AuthController extends Controller
{

    public function register(Request $request){

        $validator = Validator::make($request->all(),
        [
            'name'=> 'required',
            'email' => 'required|email',
            'password' => 'required'

        ]);

        if($validator->fails()){

            return response()->json(['status_code' => 400, 'message'=>'Bad Request']);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();


        return response()->json([
            'status_code'=>200,
            'message'=> 'User created successfully'

        ]);


    }

    public function login(Request $request){

        $validator = Validator::make($request->all(),
        [
            'email' => 'required|email',
            'password' => 'required'

        ]);

        if($validator->fails()){

            return response()->json(['status_code' => 400, 'message'=>'Bad Request']);
        }

        $credentials = request(['email', 'password']);
       
        if(!Auth::attempt($credentials)){

            return response()->json([
                'status_code',
                'message' => 'Unauthorized'
            ]);
        }


        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('token')->plainTextToken;

        return response([

            'success' => 'true',
            'token' => $token
        ],200);

    }



    public function authUser(){

        $user = request()->user();

        return response([

            'user' => $user
        ],200);


    }

    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();
       // $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return response(['success'=>1],200 );
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Validator;
use App\User;
use Carbon\Carbon;
use Auth;
use App\Reservationstore;
use App\Reservation;
use App\Room;

class ApiUserController extends Controller
{
    public function userRegister(Request $request){
    	$validator = Validator::make($request->all(),[
    		'firstName' => 'required',
            'lastName' => 'required',
    		'email' => 'required|email|unique:users',
    		'password' => 'required',
    		'c_password' => 'required|same:password',

    	]);

    	if($validator->fails()){
    		return response()->json(['error' => $validator->errors()], 401);
    	}




    	$input = $request->all();
    	$input['password'] = bcrypt($input['password']);
    	$user = User::create($input);

        $tokenResult = $user->createToken('MyApp');
        $tokenResult->token->expires_at = Carbon::now()->addDays(1);
        $tokenResult->token->save();

    	$success['token'] = $tokenResult->accessToken;
    	$success['userID'] = $user->id;
        $success['firstName'] = $user->firstName;
        $success['lastName'] = $user->lastName;

    	return response()->json(['success'=>$success],200);
    }
    public function userLogin(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        if(Auth::attempt(['email' => request('email') , 'password' => request('password')])){
            $user = Auth::user();
            $tokenResult = $user->createToken('MyApp');
            $tokenResult->token->expires_at = Carbon::now()->addDays(1);
            $tokenResult->token->save();
            
            $success['token'] = $tokenResult->accessToken;
    	    $success['userID'] = $user->id;
            $success['firstName'] = $user->firstName;
            $success['lastName'] = $user->lastName;

            return response()->json(['success'=>$success],200);
        }
        else{
            return response()->json(['error' => 'Unuthorised'], 401);
        }
    }
}

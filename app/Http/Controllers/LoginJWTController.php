<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginJWTController extends Controller
{
  public function __construct()
  {
    $this->guard = "api"; // add
  }
  
  public function login(Request $request)
  {
    //var_dump($request->all());die();
    /*
    $validator = Validator::make($request->all(), [
        'email' => 'required|string',
        'password' => 'required|string',
    ]);
    //var_dump($request->all());die();
    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }
    */

    $user = User::where([
        'email' => $request["email"],
        //'password' => md5($request->password)
        'password' => $request["password"]
    ])->first();
    //var_dump($request->all(), $user["name"]);die();
    if (! $user ) return response()->json([ 'email' => ['Unauthorized = ! $user'] ], 401);

    if (! $token = auth( $this->guard )->login( $user ) ) {
      return response()->json([ 'email' => ['Unauthorized = ! $token'] ], 401);
    }

    return $this->respondWithToken($token);
  }


  protected function respondWithToken($token)
  {
    return response()->json([
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' => auth( $this->guard )
                      ->factory()
                      ->getTTL() * 3600
    ]);
  }
}

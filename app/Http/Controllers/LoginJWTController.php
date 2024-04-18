<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginJWTRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginJWTController extends Controller
{
  public function __construct()
  {
    $this->guard = "api"; // add
  }

  //retorna um token usando o formulario validado por LoginJWTRequest.
  public function login(LoginJWTRequest $request)
  {
    
    $validated = $request->validated();
    
    $user = User::where([
        'email' => $validated["email"],
        //'password' => md5($request->password);
        'password' => $validated["password"]
    ])->first();
    
    if (! $user ){
      return response()->json([ 'email' => ['Unauthorized = ! $user'] ], 401);
    } 

    if (! $token = auth( $this->guard )->login( $user ) ) {
      return response()->json([ 'email' => ['Unauthorized = ! $token'] ], 401);
    }

    return $this->respondWithToken($token);
  }

  //retorna novo token usando token anterior MAS VÁLIDO sem a necessidade de formulário:
  public function refresh()
  {
    return $this->respondWithToken(auth($this->guard)->refresh());
  }
  
  //Desvalida o token recebido pelo cabeçalho.
  public function logout()
  {
    auth($this->guard)->logout();
    return response()->json(['message' => 'Successfully logged out']);
  }

  //usado para criar e criptografar.
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

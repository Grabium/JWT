<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware; //inserido manualmente
//use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Facades\JWTAuth;

//extender BaseMiddleware
class UserRoutesProtectedsMiddleware extends BaseMiddleware
{
  /**
   * JWTAuth::parseToken()->authenticate();
   * Irá buscar um cabeçalho da requisição:
   * $header = $request->header('Authorization');//teste que captura o token.
   * Acho que é enviado pelo blade assim:
   * @headder('Authorization', $token);
   */
  public function handle(Request $request, Closure $next)
  {
    //$header = $request->header('Authorization');//teste que captura o token.
    //dump($header, $request->all()); die(); //não se esqueça que metodo get retorna vazio em $request->all()
    try{
      $user = JWTAuth::parseToken()->authenticate();
    }catch(\Exception $e){
      return response()->json(['msg' => "excepition: usuário não definido"]);
    }

    if(! $user){
      return response()->json(['msg' => "if: usuário não definido"]);
    }
    //dump($user); die();
    return $next($request);
  }
}

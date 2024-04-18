<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware; 

//inseridos manualmente:
use Tymon\JWTAuth\Facades\JWTAuth;


//extender BaseMiddleware manualmente:
class UserRoutesProtectedsMiddleware extends BaseMiddleware
{
  protected $openRoutes = ['user.store'];
  /**
   * $user irá receber um cabeçalho da requisição:
   * $header = $request->header('Authorization');//teste que captura o token.
   * Acho que é enviado pelo blade assim:
   * @headder('Authorization', $token);
   */
  public function handle(Request $request, Closure $next)
  {
    $rota = $request->route()->getName();
    
    if(in_array($rota, $this->openRoutes)){
      //echo 'rota livre: '.$rota.'<br/>';
      return $next($request);
    }

    //echo 'rota mediada: '.$rota.'<br/>';

    try{
      $user = JWTAuth::parseToken()->authenticate();
    }catch(\Exception $e){
      //criar exceptions mais detalhadas. if($user==null){...} Pois essa não ajuda muito.
      return response()->json(['msg' => "excepition: usuário não definido"]);
    }

    if(! $user){
      return response()->json(['msg' => "if: usuário não definido"]);
    }
    
    return $next($request);
  }
}

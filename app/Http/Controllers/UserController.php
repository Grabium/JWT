<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;


//php artisan make:controller UserController --resource --api

class UserController extends Controller
{
  protected $options = ['cost' => 12];
  
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $msg = DB::table('users')
      ->select('id', 'email', 'password')
      ->get();
    return response()->json(['msg' => $msg]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request['password'] = password_hash($request['password'], PASSWORD_BCRYPT, $this->options);
    //$data    = $request->all(); //apenas para controle maior e redirecionamento.
    $msg = User::create($request->all());  //registro... 
    return response()->json(['msg' => $msg]);//, 'pass' => $data['password']]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $msg = User::findOrFail($id);
    //outras opções:
    //$msg = DB::table('users')->select('id', 'email', 'info')->find($id);
    //$msg = DB::table('users')->select('id', 'email', 'info')->where('name', $id)->first(); //achar pelo nome
    return response()->json(['msg' => $msg]);
    
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $data = $request->all();
    $msg  = User::findOrFail($id);
    $msg  = $msg->update($data);//boole
    return response()->json(['msg' => $msg, 'data' => $data]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $msg = User::findOrFail($id);
    $msg = $msg->delete();
    return response()->json(['msg' => $msg ]);
  }
}

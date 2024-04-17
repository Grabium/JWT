<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginJWTRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    //input => [ rules ]
    return [
      'email' => ['required', 'email', 'max:60'],
      'password' => ['required', 'max:10']
    ];
  }

  public function messages(): array
  {
    //Há 2 formatos: "rule => mensagem"  ou  "input.rule => mensagem"
    return [
      'required' => 'O campo :attribute é um campo obrigatório.',
      'email' => 'O campo :attribute deve ser preenchido com um email válido.',
      'password.max' => 'O campo password deve ser preenchido com no máximo 10 caracteres',
      'email.max' => 'O campo password deve ser preenchido com no máximo 60 caracteres'
    ];
  }
}

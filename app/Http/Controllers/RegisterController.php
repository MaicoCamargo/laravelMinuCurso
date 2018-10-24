<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Redirect;
use Hash; 
use Validator;
use App\User;//classe usuario 

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('criar-conta');//nome da rota do arquivo web.php
    }

    public function createAccount(Request $resquest){

        Validator::make($resquest->all(), [
            'name' => 'required|max:255',
            'email' => 'required |  email | unique:users',
            'password' => 'required | min:8'
        ])->validate(); 
        
        //salvar usuario no DB 
        $user =  User::create(
            [
                'name' => $resquest->get('name'),
                'email' => $resquest->get('email'),
                'password' => Hash::make($resquest->get('password'))
            ]
        );

        Auth::login($user);//logar o usuario 
        return Redirect('/');
            
    }

}

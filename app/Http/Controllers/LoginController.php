<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Redirect;

class LoginController extends Controller
{
    //mostra tela de login
    public function showLogin()
    {
        return view('login');//passar apenas nome do arquivo, arquivo que ta dentro da pasta resources 
    }

    //pega os dados do form login
    public function submitLogin(Request $resquest)
    {
        //validar os dados do form
        //recebendo email e senha
        //nome do input depois as regras 
        Validator::make($resquest->all(),[
            'email' => 'required |  email ',
            'password' => 'required | min:8'
        ])->validate();        

        //tentar logar
        if(Auth::attempt($resquest->only('email','password')))
        {//autenticado
            return Redirect::to('/');//pagina inicial do blog
        }
        else
        {//erro no autenticar 
            return Redirect::back()->withErrors(['Usuário ou senha incorretos']);// volta para pagina com a mensagem de erro
        }
    }

    public function logOut(){
        Auth::logout();
        return Redirect::to('/');
    }
}

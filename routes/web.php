<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//retorna todos os posts cadastrados
Route::get('/', 'PostsController@getPosts');

//retorna todos os posts cadastrados
Route::get('/artigo/{slug}', 'PostsController@getPost');

//remover um post
Route::get('artigo/remover/{slug}','PostsController@deletePost');

//pagina com os dados para editar um post
Route::get('artigo/editar/{slug}', 'PostsController@getPostEdit');

//salvar dados do post editado
Route::post('artigo/editar/{slug}', 'PostsController@updatePost');

// nome do controller depois nome do metodo que deve executar sem os paremetros
Route::get('/login', 'LoginController@showlogin');

//deslogar usuario 
Route::get('/logout', 'LoginController@logOut'); 

//post no metodo submitLogin
Route::post('/login', 'LoginController@submitLogin'); 

//mostra pagina de criar conta
Route::get('/criar-conta','RegisterController@showRegister');

//pega os dados do form de cadastro do usuário 
Route::post('/criar-conta', 'RegisterController@createAccount');

//manda pra tela de criar post 
Route::get('/criar-artigo','PostsController@createPost');

//form com dados do post
Route::post('/criar-artigo', 'PostsController@postSubmit');



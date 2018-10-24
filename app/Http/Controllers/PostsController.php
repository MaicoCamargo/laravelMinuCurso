<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Validator;
use Storage;//salvar img de capa no servidor 
use Redirect;
use Auth;

class PostsController extends Controller
{
    // retorna a tela de criação  de posts
    //estar autenticado para postar 
    public function createPost()
    {
        if(!Auth::check())
        {
            return redirect::to('/login');
        }
        return view('criar-artigo');
    }

    //pega os dados de um post que esta sendo cadastrado 
    public function postSubmit(Request $request)
    {
        if (!Auth::check()) {
            return redirect::to('/login');
        }
        Validator::make($request->all(), [
            'image' => 'nullable | image',
            'text' => 'required | min:4',
            'title' => 'required|max:255|unique:posts'
        ])->validate();

        $imagePath = '';
        //caso a imagem for null não atribui o caminho da imagem
        if($request->file('image')){
            //Salvando a imagem e retornando o seu caminho 
            $imagePath = Storage::disk('public')->put('posts-images', $request->file('image'));

        }
        
        $postCreated = Post::create( [
            'title' => $request->get('title'),
            'text' => $request->get('text'),
            'image_location' => $imagePath,
            'author_id' => Auth::id(),
            'slug' => str_slug($request->get('title'))
        ]);

        return redirect::to('/');

    }

    //retorna todos os post cadastrados 
    public function getPosts()
    {
        $allPosts = Post::all();
        return view('artigos')->with('artigos', $allPosts);//posts é o nome que é usado para pegar os dados na view 
    }

    //ver um post especifico pelo seu slug
    public function getPost($slug){
        $post = Post::where('slug',$slug)->first();
        return view('ver-artigo')->with('post',$post);
    }

    //deletar um post especifico pelo seu slug
    public function deletePost($slug)
    {
        //buscar post
        $post = Post::where('slug', $slug)->first();
        
        //ver se pode deletar
        if($post && Auth::id() == $post->author->id)
        {
            $post->delete(); 
        }
        
        return Redirect::to('/');
    }

    // tela editar post
    public function getPostEdit($slug){

        //caso o usuario n esteja logado
        if (!Auth::check()) {
            return redirect::to('/');
        }
        
        $postEdit = Post::where('slug', $slug)->first();
        return view('editar-artigo')->with('artigo', $postEdit); 
    }

    //salvar dados de um post editado
    public function updatePost(Request $request, $slug){
        
        //caso o usuario n esteja logado
        if (!Auth::check()) {
            return redirect::to('/');
        }

        $postEdit = Post::where('slug', $slug)->first();//retorna os dados do post que vai ser editado

        Validator::make($request->all(), [
            'image' => 'nullable | image',
            'text' => 'required | min:4',
            'title' => 'required|max:255|unique:posts,id,'.$postEdit->id,
        ])->validate();
        
        
        if(!$postEdit || $postEdit->author->id != Auth::id()){//caso o post n for do usuario logado manda para /
            return Redirect::to('/');
        }
        $postEdit->title = $request->get('title');
        $postEdit->text = $request->get('text');
        $postEdit->slug = str_slug($request->get('title'));
        
        $imagePath = '';
        //caso a imagem for null não atribui o caminho da imagem
        if ($request->has('image')) {
            if($postEdit->image_location){
                Storage::disk('public')->delete($postEdit->image_location);            
            }
            //Salvando a imagem e retornando o seu caminho 
            $imagePath = Storage::disk('public')->put('posts-images', $request->file('image'));
            $postEdit->image_location = $imagePath;    
        }

        $postEdit->save();

        return Redirect::to('/artigo/'.$postEdit->slug);
    }
}

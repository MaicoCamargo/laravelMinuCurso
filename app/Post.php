<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';// nome da tabela dentro do banco 
    protected $primaryKey = 'id';//primary key do banco 
    protected $fillable = [
        'title',
        'text',
        'image_location',
        'author_id',
        'slug',
        
    ];

    /**
     * author de um post 
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');//falando que um post petence a um usuario 
    }
    /**
     * retorna os comentarios do post 
     */
    public function coments()
    {
        return $this->hasMany(Comment::Class, 'post_id', 'id');// relacionando os comentarios a um post 
    }
}


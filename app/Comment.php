<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');//relacionando com a tabela post
    }


    public function user()
    {
        return $this->belongsTo(Post::class, 'user_id', 'id');//relacionando com a tabela usuario 
    }
}

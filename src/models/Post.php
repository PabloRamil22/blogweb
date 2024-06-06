<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'title', 
        'body', 
        'image', 
        'create_date', 
        'user_id'
    ];

    public $timestamps = false;

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Categorias::class, 'posts_categories', 'post_id', 'categories_id');
    }

}
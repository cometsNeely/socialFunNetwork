<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';
    protected $primaryKey = "id";
    protected $fillable = ['user_like', "user_author", 'user_author_review', 'showOrHideUserAlert'];
}

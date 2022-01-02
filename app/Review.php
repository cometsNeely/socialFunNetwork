<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = "id";
    protected $fillable = ['user_id', "show_id", 'user_name', 'user_review', 'isClick', 'currentCounter'];
}

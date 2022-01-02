<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats';
    protected $primaryKey = "id";
    protected $fillable = ['user_req', "user_resp", 'message', 'date'];
}

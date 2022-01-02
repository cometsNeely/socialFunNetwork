<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{

    protected $table = 'shows';
    protected  $primaryKey = "id";
    protected $fillable = ['user_id', 'title', 'description', 'rate', 'avg_rate', 'href', 'cover_src', 'status', 'rateChecked'];

    public function showTags() {
        return $this->hasMany('App\Tag');
    }
}

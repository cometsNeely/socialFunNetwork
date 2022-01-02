<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected  $primaryKey = "id";
    protected $fillable = ['show_id', 'tag_name'];

    public function tagsShow() {
        return $this->belongsTo('App\Show');
    }
}

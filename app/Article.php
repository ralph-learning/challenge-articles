<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'status'];
    protected $hidden = ['created_at', 'updated_at'];
}

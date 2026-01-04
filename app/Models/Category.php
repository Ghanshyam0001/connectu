<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Content;

class Category extends Model
{
    protected $fillable = ['name'];
    //one to many relation in contant
    public function content()
    {
        return $this->hasMany(Content::class);
    }
}

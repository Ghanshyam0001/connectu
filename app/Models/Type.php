<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Content;


class Type extends Model
{
     protected $fillable = ['name'];
    // one to many relationship to contant
    public function content()
    {
        return $this->hasMany(Content::class);
    }
}

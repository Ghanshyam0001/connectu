<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Content;
use App\Models\User;

class Like extends Model
{
    protected $fillable = [
        'content_id',
        'user_id',
    ];

     // inverse relation
      public function user()
    {
        return $this->belongsTo(User::class);
    }

      // inverse relation
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    
}

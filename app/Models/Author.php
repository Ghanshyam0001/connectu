<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Content;


class Author extends Authenticatable
{
    use Notifiable;
     protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'status',
        'token'
    ];
     protected $hidden = [
        'password',
    ];

    protected $casts = [
    'password' => 'hashed',
     'token_created_at' => 'datetime',

];

    // one to many relationship to contant
    public function content()
    {
        return $this->hasMany(Content::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Content;
use App\Models\User;


class Comment extends Model
{
    protected $fillable = [
        'comment',
        'user_id',
        'content_id',
        'parent_id',
    ];
    //   inverse relation
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    //   inverse relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Self relation: replies
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}

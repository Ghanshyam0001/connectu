<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Content;


class Report extends Model
{
    protected $fillable = [
        'report',
        'content_id',
        'user_id',
    ];
    // A report belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // A report belongs to a content
    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }
}

<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Author;
use App\Models\Category;
use App\Models\Type;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use  App\Models\Report;






class Content extends Model
{
 protected $fillable = [
    'title',
    'description',
    'slug',
    'image',
    'video', 
    'author_id',
    'category_id',
    'type_id',
];
    // inverse relation
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    // inverse relation
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // inverse relation
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    // one to many relation 
    public function comment()
    {
        return $this->hasMany(Comment::class, 'content_id');
    }

    // A content can have many likes
    public function like()
    {
        return $this->hasMany(Like::class, 'content_id');
    }

    // Shortcut: all users who liked this content (Many-to-Many)
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes', 'content_id', 'user_id')
            ->withTimestamps();
    }

    // one to many relation
    public function report()
    {
        return $this->hasMany(Report::class, 'content_id');
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use  App\Models\Comment;
use  App\Models\Like;
use  App\Models\Content;
use  App\Models\Report;




class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */


    // one to many relation 
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    
    // one to many relation 
    public function like()
    {
        return $this->hasMany(Like::class);
    }
    // Shortcut: all contents the user liked (Many-to-Many)
    public function likedContents()
    {
        return $this->belongsToMany(Content::class, 'likes', 'user_id', 'content_id')
                    ->withTimestamps();
    }
  public function report()
    {
        return $this->hasMany(Report::class, 'user_id');
    }

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

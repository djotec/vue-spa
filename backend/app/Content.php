<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text', 'image', 'link', 'posted_at'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'content_id', 'user_id');
    }

    public function getPostedAtAttribute($value){
        $posted_at = date('d/m/Y à\s H:i', strtotime($value));
        return $posted_at;
    }
}

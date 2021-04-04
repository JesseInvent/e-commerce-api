<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'review',
        'user_id'
    ];

    public function ownedBy($user)
    {
        return $this->user_id == $user->id;
    }

    public function likes()
    {
        return $this->hasMany(ReviewLike::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'user_id'
    ];

    public function wasCreatedBy($user)
    {
        return (int) $this->user_id === (int) $user->id;
    }

    public function belongsToProductCreatedBy($user)
    {
        return (int) $this->user_id === (int) $this->product()->user_id;
    }

    public function hasBeenlikedBy(User $user)
    {
        return !!$this->likes()->where('user_id', $user->id)->count();
    }

    public function likes()
    {
        return $this->hasMany(ReviewLike::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}

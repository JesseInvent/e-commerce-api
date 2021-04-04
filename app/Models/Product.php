<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Product extends Model
{
    use HasFactory;

    protected static function boot ()
    {
        parent::boot();
        static::creating(function($product){
            $product->slug = Str::slug($product->name);
        });
    }

    protected $fillable = [
        'name',
        'slug',
        'price',
        'images',
        'description'
    ];

    public function hasBeenlikedBy(User $user)
    {
        return !!$this->likes()->where('user_id', $user->id)->count();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function likes()
    {
        return $this->hasMany(ProductLike::class);
    }

}

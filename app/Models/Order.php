<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'units',
        'total_price',
        'user_id',
        'paid_status'
    ];

    public function belongsToProductCreatedBy($user)
    {
       return (int) $user->id === (int) $this->product()->first()->id;
    }

    public function wasCreatedBy(User $user)
    {
        return (int) $this->user_id === (int) $user->id;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}

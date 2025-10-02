<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

   protected $fillable = [
        'user_id',
        'total_amount',
        'status', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'user_id', 'user_id');
    }


}

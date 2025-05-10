<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'game_id',
        'quantity',
        'total_price',
        'status',
        'rental_date',
        'rental_duration',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function game()
    {
        return $this->belongsTo(Games::class);
    }
}
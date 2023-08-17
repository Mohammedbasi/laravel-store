<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'first_name', 'last_name', 'type', 'email', 'phone_number',
        'street_address', 'state', 'postal_code', 'city', 'country',
    ];

    public $timestamps = false;
}

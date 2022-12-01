<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable=[
        'application_id',
        'amount',
        'currency',
        'merchantOrderId',
        'notify_url',
        'return_url',
    ];
}

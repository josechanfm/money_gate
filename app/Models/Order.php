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
        'merchantOrderNumber',
        'order_number',
        'order',
        'payer',
        'send_json',
        'result_json',
        'notify_url',
        'return_url',
    ];
}

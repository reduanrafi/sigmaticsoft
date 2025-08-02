<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id'  , // future implementation
        'order_number'  ,
        'customer_name'  ,
        'customer_phone'  ,
        'delivery_address' ,
        'total_amount'  ,
        'discount'  ,
        'vat'  ,
        'status' ,
    ];
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

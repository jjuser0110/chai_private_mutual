<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_no',
        'user_id',
        'shop_item_id',
        'user_address_id',
        'status',
    ];

    public function shop_item()
    {
        return $this->belongsTo('App\Models\ShopItem');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function user_address()
    {
        return $this->belongsTo('App\Models\UserAddress');
    }
}
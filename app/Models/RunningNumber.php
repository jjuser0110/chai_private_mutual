<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RunningNumber extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'year',
        'month',
        'no_of_digit_behind',
        'running_no',
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

    public function userShopPointHistories()
    {
        return $this->morphMany('App\Models\UserShopPointHistory', 'content');
    }
}
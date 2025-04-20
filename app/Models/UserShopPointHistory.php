<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserShopPointHistory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'content_id',
        'content_type',
        'user_id',
        'type',
        'prev_amount',
        'amount',
        'final_amount',
    ];

    public function content()
    {
        return $this->morphTo();
    }
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

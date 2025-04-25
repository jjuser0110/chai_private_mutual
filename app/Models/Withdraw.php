<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdraw extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'user_bank_id',
        'amount',
        'status',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function user_bank()
    {
        return $this->belongsTo('App\Models\UserBank');
    }
}

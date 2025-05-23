<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoneyRecord extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'type',
        'type_id',
        'before_amount',
        'amount',
        'after_amount',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

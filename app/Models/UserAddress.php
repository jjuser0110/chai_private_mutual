<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'contact_name',
        'phone_number',
        'address',
        'is_active',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBank extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'bank_id',
        'account_no',
        'full_name',
        'is_active',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }
}
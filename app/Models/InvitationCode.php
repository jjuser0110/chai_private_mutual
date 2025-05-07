<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvitationCode extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'user_id',
    ];
}

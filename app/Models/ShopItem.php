<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'item_name',
        'item_point',
        'item_details',
        'is_active',
    ];

	public function last_file()
    {
        return $this->morphOne('App\Models\FileAttachment', 'content')->latest();
    }

    public function thumbnail()
    {
        return $this->morphOne('App\Models\FileAttachment', 'content')->orderBy('id')->first();
    }

    public function file_attachments()
    {
        return $this->morphMany('App\Models\FileAttachment', 'content');
    }
}
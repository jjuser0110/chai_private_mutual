<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_category_id',
        'product_name',
        'product_price',
        'product_percentage',
        'product_size',
        'earning_yield',
        'project_deadline',
        'user_level',
        'investment_amount',
        'investment_amount_to',
        'project_rules',
        'is_active',
        'display',
        'earning_yield_unit',
        'project_deadline_unit',
        'product_type',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\ProductCategory','product_category_id');
    }

	public function last_file()
    {
        return $this->morphOne('App\Models\FileAttachment', 'content')->latest();
    }

    public function thumbnail()
    {
        return $this->morphOne(\App\Models\FileAttachment::class, 'content')->oldest('id');
    }

    public function file_attachments()
    {
        return $this->morphMany('App\Models\FileAttachment', 'content');
    }
}

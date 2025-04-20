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
        'project_rules',
        'is_active',
    ];

    public function product_category()
    {
        return $this->belongsTo('App\Models\ProductCategory');
    }

	public function last_file()
    {
        return $this->morphOne('App\Models\FileAttachment', 'content')->latest();
    }

    public function file_attachments()
    {
        return $this->morphMany('App\Models\FileAttachment', 'content');
    }
}

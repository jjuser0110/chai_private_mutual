<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'short_description',
        'description',
        'article_date',
        'arrangement',
        'is_active',
    ];

	public function last_file()
    {
        return $this->morphOne('App\Models\FileAttachment', 'content')->latest();
    }

    public function file_attachments()
    {
        return $this->morphMany('App\Models\FileAttachment', 'content');
    }
}

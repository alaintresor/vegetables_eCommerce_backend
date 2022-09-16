<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogSubCategory extends Model
{
    use HasFactory;
    protected $table = 'blog_sub_categories';
    protected $fillable = [
        'name',
        'category_id',
        
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function blog()
    {
        return $this->hasMany(Blog::class, 'id');
    }
}

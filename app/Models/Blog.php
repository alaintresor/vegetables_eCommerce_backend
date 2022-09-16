<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blogs';
    protected $fillable = [
        'sub_category_id',
        'title',
        'description',
        'requirements',
        'image',
        'link',
        
        
    ];

    
    public function subcategory()
    {
        return $this->belongsTo(Blogsubcategory::class ,'sub_category_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
        protected $table="subcategories";
        protected $primaryKey="id";
        public $timestamps = true;
    
        protected $fillable=[
            "name",
            "meta_tag",
            "meta_description",
            "slug",
            "category_id",
        ];
        
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}

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
}

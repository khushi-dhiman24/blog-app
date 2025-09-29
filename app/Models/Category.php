<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table="categories";
    protected $primaryKey="id";
    protected $timestamp=true;
    protected $increament=true;
    protected $fillable=[
        "meta_name",
        "meta_title",
    ];
}

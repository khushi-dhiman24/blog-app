<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business_banner extends Model
{
    protected $table = 'business_banners';
    protected $fillable = ['business_id', 'photo'];
}

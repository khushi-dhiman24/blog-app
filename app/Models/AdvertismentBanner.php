<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertismentBanner extends Model
{
    protected $table = 'advertisement_banner';
    protected $fillable = ['business_id', 'location', 'category'];
    
    public function business()
    {
        return $this->belongsTo(New_Businesses::class, 'business_id');
    }
}

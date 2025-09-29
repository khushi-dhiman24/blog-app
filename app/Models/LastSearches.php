<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LastSearches extends Model
{
    protected $table = 'last_searches';
    protected $fillable = [
        'search', 'name', 'phone_number', 'lat', 'longi', 
        'city', 'cat_id', 'sub_cat_id', 'state', 'agent', 
        'ip', 'bot_type', 'bot', 'link', 'device_type'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessTimes extends Model
{
    protected $table="BusinessTimes";
    protected $primaryKey="id";
     protected $increamenting=true;
    protected $timestamp=true;
    protected $fillable=[
        "business_id",
        "day_of_week",
        "open_time",
        "close_time",
    ];
}

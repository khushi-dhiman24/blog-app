<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class newcitylatlong extends Model
{
    protected $table="newcitylatlong";
    protected $primaryKey="id";
    protected $increment =true;
    protected $timestamp=true;
    protected $fillable=[
        "latitude",
        "longitude",
        "city",
    ];

}

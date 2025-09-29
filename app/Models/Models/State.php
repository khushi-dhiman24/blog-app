<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class State extends Model
{
   
       protected $table ='states';
    protected $primarykey ='id';
    protected $increment = true;
    protected $timestamps =true;
   
    protected $attributes =[
        'name'=>"",
        'country_id'=>"",
    ];
    public $fillable =[
        'name',
        'country_id',
    ];
}

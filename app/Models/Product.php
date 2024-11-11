<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $hidden = [];
    protected $fillable = ['name', 'price', 'quantity'];
    public $timestamps = false;
}

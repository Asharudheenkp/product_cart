<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMaster extends Model
{
    protected $fillable = ['product_name', 'product_image', 'price'];
}

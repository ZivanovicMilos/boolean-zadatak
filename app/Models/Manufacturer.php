<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $fillable = ['manufacturer_name'];
    protected $table = 'manufacturers';

    public function products() {
        return $this->hasMany(Product::class);
    }
}


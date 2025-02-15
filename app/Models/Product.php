<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $primaryKey = 'product_number';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'products';

    protected $fillable = ['product_number', 'description', 'regular_price', 'sale_price'];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function department(): BelongsTo {
        return $this->belongsTo(Department::class);
    }

    public function manufacturer(): BelongsTo {
        return $this->belongsTo(Manufacturer::class);
    }
}

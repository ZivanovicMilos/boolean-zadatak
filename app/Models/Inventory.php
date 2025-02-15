<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    protected $table = 'inventory';
    protected $primaryKey = 'sku';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['sku', 'upc', 'product_number', 'category_id', 'department_id', 'manufacturer_id'];

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class, 'product_number', 'product_number');
    }

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

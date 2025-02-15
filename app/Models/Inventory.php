<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $primaryKey = 'sku';
    protected $keyType = 'string';
    public $incrementing = false;

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Product::class, 'product_number', 'product_number');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function department(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Department::class);
    }

    public function manufacturer(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Manufacturer::class);
    }
}

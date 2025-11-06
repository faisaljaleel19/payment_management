<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Products extends Model
{

    protected $table = 'products';

    protected $fillable = [
        'order_id',
        'product_name',
        'product_description',
        'product_price',
        'product_quantity',
        'currency',
    ];

    public function orders(): BelongsTo
    {
        return $this->belongsTo(Orders::class, 'order_id', 'order_id');
    }
}

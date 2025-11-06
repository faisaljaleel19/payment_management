<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * Class Orders
 * @mixin Builder
 *
 */
class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'id',
        'order_id',
        'order_date',
        'customer_id',
        'customer_address_id',
        'product_name',
        'product_price',
        'product_quantity',
        'currency',
        'remarks',
        'created_by',
    ];

    public function customers(): BelongsTo
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'id');
    }

    public function customerAddress(): BelongsTo
    {
        return $this->belongsTo(CustomerAddress::class, 'customer_address_id', 'id');
    }
}

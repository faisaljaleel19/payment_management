<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $table = 'customer_address';

    protected $fillable = [
        'customer_id',
        'street_address1',
        'street_address2',
        'street_address3',
        'city',
        'state',
        'country',
        'zip_code',
        'phone_number',
    ];

    public function customers(): BelongsTo
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'id');
    }
}

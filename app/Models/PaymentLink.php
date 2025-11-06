<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentLink extends Model
{
    use HasFactory;

    protected $table = 'payment_link';

    protected $fillable = [
        'order_id',
        'token',
        'expiry_date',
    ];

    public function orders(): BelongsTo
    {
        return $this->belongsTo(Orders::class, 'order_id', 'order_id');
    }
}

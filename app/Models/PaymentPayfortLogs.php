<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentPayfortLogs extends Model
{
    use HasFactory;

    protected $table = 'payment_payfort_logs';

    protected $fillable = [
        'messages',
    ];
}

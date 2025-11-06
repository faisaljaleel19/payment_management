<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'order_id',
        'request_type',
        'currency',
        'customer_email',
        'command',
        'language',
        'return_url',
        'response_code',
        'payment_option',
        'customer_ip',
        'fort_id',
        'response_message',
        'transaction_status'
    ];
}

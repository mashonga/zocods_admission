<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'application_id',
        'reference',
        'amount',
        'currency',
        'status',
        'transaction_id',
        'payment_response',
        'paid_at',
        'attempts',
        'last_error',
    ];

    protected $casts = [
        'payment_response' => 'array',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
        'attempts' => 'integer',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed' || $this->status === 'cancelled';
    }
}

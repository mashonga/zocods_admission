<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    protected $fillable = [
        'full_name',
        'gender',
        'marital_status',
        'date_of_birth',
        'nationality',
        'district',
        'phone',
        'email',
        'address',
        'postal_address',
        'program',
        'occupation',
        'employer',
        'sponsor',
        'sponsor_phone',
        'exam_board',
        'highest_qualification',
        'other_qualifications',
        'previous_school',
        'certificate_file',
        'id_file',
        'message',
        'agreed',
        'status',
        'payment_status',
        'submitted_at',
    ];

    protected $casts = [
        'agreed' => 'boolean',
        'date_of_birth' => 'date',
        'submitted_at' => 'datetime',
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->latest();
    }

    public function scopePendingPayment($query)
    {
        return $query->where('status', 'Pending Payment');
    }

    public function scopeSubmitted($query)
    {
        return $query->where('status', 'Paid');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'Draft');
    }

    public function isSubmitted(): bool
    {
        return $this->status === 'Paid';
    }

    public function markAsSubmitted(): void
    {
        $this->update([
            'status' => 'Paid',
            'submitted_at' => now(),
        ]);
    }

    public function markAsPendingPayment(): void
    {
        $this->update([
            'status' => 'Pending Payment',
            'submitted_at' => null,
        ]);
    }
}

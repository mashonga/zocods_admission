<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoardFee extends Model
{
    use HasUuids;

    protected $fillable = [
        'exam_board_id',
        'fee_name',
        'amount',
        'currency',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function examBoard(): BelongsTo
    {
        return $this->belongsTo(ExamBoard::class);
    }
}
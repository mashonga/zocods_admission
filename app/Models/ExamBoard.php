<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamBoard extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'code',
    ];

    public function fees(): HasMany
    {
        return $this->hasMany(BoardFee::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Intake extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'start_month',
        'end_month',
        'study_mode',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function intakePrograms(): HasMany
    {
        return $this->hasMany(IntakeProgram::class);
    }
}
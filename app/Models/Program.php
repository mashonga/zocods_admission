<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'duration',
        'introduction',
        'entry_requirements',
        'mode_of_delivery',
        'duration_details',
        'module_summary',
        'qualification_levels',
        'assessment_details',
        'grading_system',
        'progression_details',
        'field_practicals',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
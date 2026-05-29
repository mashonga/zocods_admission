<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];
}
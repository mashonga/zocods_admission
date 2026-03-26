<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'full_name',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'program',
        'address',
        'highest_qualification',
        'previous_school',
        'certificate_file',
        'id_file',
        'message',
        'status',
    ];
}
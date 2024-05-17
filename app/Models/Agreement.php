<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;
    protected $table = 'agreement';
    protected $fillable = [
        // Other fillable fields,
        'agreement_response',
    ];
}

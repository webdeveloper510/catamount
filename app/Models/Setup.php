<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setup extends Model
{
    protected $table = 'setup';
    protected $fillable = [
        'image',
        'description',
    ];
}

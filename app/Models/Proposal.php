<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Proposal extends Model
{
    protected $table = 'proposal';
    protected $fillable = [
        // Other fillable fields,
        'proposal_response',
    ];
}
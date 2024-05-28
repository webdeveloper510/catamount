<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalInfo extends Model
{
    use HasFactory;
    protected $table = 'proposalinfo';
    protected $fillable = [
        'email',
        'lead_id',
        'proposal_mode',
        'proposal_data',
    ];
}

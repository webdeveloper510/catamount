<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PowerBiReport extends Model
{
    use HasFactory;
    protected $table = 'powerbi_reports';
    protected $fillable = [
        'report_name',
        'PBI_group_id',
        'PBI_report_id',
        'PBI_dataset_id',
        'PBI_embed_url',
        'permissions',
        'is_rls_enabled',
    ];
}

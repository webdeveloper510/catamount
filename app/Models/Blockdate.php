<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blockdate extends Model
{
    protected $table= 'blockdate';
    protected $fillable = [
        'id',
        'start_date',
        'end_date',
        'purpose',
	    'unique_id',
        'venue',
        'created_by',
    ];

    public function user()
    {
    return $this->belongsTo(User::class, 'created_by');
    }


}
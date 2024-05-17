<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixedBill extends Model
{
    protected $table= 'fixedbillvalue';
    protected $fillable = [
        'venue',
        'venue_cost',
        'wedding',
        'equipment',
        'bar_package',
        'dinner',
        'lunch',
        'brunch',
        'special_req',
        'specialsetup',
        'rehearsalsetup',
        'welcomesetup',
    ];
}

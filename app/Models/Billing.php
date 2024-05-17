<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{   
    // protected $table = 'billinginfo';
    protected $table= 'billing';
    public static $status   = [
        'Create Estimated Invoice',
        'Invoice created',
        'Payment Pending',
        'Partially Paid',
        'Payment Completed',
    ];
}

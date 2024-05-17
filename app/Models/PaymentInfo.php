<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PaymentInfo extends Model
{
    use HasFactory;
    use SoftDeletes;
    // protected $table = 'payment_info';
    protected $table = 'billinginfo';

}

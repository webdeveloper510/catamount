<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emailcontent extends Model
{
    use HasFactory;
    protected $fillable = [
      'subject',
      'content'
    ];

}

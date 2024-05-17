<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UserImport extends Model
{
    use HasFactory;
    protected $table = 'import_users';
    protected $fillable = ['name','email','phone','address','organization','category','created_by','notes'];

    public static $status = [
        'Active' ,
        'In Active'
    ];
    public static $convertedto =[
        'Yes',
        'no'
    ];

}

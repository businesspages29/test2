<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fcm extends Model
{
    use HasFactory;
    protected $table = 'fcms';//Firebase
    protected $fillable = [
        'user_id',
        'token',
    ];
}

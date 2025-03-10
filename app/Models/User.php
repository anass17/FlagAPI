<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{

    use HasApiTokens;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];
}

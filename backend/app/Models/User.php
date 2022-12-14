<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model {
    use hasFactory;

    protected $table = 'user';

    protected $fillable = [
        'id',
        'name',
        'login',
        'created_at',
        'updated_at',
        'password'
    ];
}

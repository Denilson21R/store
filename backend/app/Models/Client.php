<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model {
    use hasFactory;

    protected $table = 'client';

    protected $fillable = [
        'id',
        'name',
        'address',
        'phone',
        'created_at',
        'updated_at'
    ];
}

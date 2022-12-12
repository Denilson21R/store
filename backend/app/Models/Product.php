<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use hasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'value',
        'created_at',
        'updated_at'
    ];
}

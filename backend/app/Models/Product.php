<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use hasFactory;

    protected $table = 'product';

    protected $fillable = [
        'id',
        'name',
        'description',
        'value',
        'created_at',
        'updated_at'
    ];

    public function sales()
    {
        return $this->belongsToMany(
            Sale::class,
            'sale_product',
            'id_product',
            'id_sale'
        );
    }
}

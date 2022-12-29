<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model {
    use hasFactory;

    protected $table = 'sale';

    protected $fillable = [
        'id',
        'id_client',
        'total_value',
        'created_at',
        'updated_at'
    ];

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'sale_product',
            'id_sale',
            'id_product'
        );
    }
}

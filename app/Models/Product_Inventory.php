<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Inventory extends Model
{
    use HasFactory;

    protected $table = 'products_inventory';

    protected $fillable = [
        'id_product',
        'store_id',
        'product_name',
        'price',
        'quantity',
        'category',
    ];

    /**
     * Relationship to the User model.
     */
    public function conn_store()
    {
        return $this->belongsTo(StoreInfo::class);
    }
}

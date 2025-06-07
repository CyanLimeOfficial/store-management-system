<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price'
    ];

    /**
     * Get the transaction that owns the item.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Get the product associated with the item.
     */
    public function product()
    {
        return $this->belongsTo(Product_Inventory::class, 'product_id');
    }

    /**
     * Calculate the subtotal for the item.
     */
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;
    }
}
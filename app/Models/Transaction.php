<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'costumer_store_id',
        'customer_name',
        'transaction_class'
    ];

    protected $casts = [
        'transaction_class' => 'string'
    ];

    /**
     * Get the store associated with the transaction.
     */
    public function store()
    {
        return $this->belongsTo(StoreInfo::class, 'costumer_store_id');
    }

    /**
     * Get all items for the transaction.
     */
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    /**
     * Calculate the total amount of the transaction.
     */
    public function getTotalAttribute()
    {
        return $this->items->sum(function($item) {
            return $item->quantity * $item->price;
        });
    }
}
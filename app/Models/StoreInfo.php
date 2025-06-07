<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreInfo extends Model
{
    use HasFactory;

    protected $table = 'store_info';

    protected $fillable = [
        'user_id',
        'store_name',
        'logo',
        'address',
        'description',
    ];

    /**
     * Relationship to the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

        /**
     * Get all transactions for the store.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'costumer_store_id');
    }
}

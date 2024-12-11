<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'status',
        'price',
        'delivery_time',
        'delivery_address',
        'customer_phone'
    ];
    const ORDER_STATUSES = ['created', 'cooking', 'delivery', 'completed'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

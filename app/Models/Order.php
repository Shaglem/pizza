<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'user_id',
        'status',
        'price',
        'delivery_time',
        'delivery_address',
        'customer_phone'
    ];
    const ORDER_STATUSES = [self::CREATED_ORDER_STATUS, 'cooking', 'delivery', 'completed'];
    const CREATED_ORDER_STATUS = 'created';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCurrentUser(Builder $query): void
    {
        $query->where('user_id', Auth::id());
    }
}

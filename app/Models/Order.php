<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'shipping',
        'status',
        'status_timeline',
        'full_name',
        'phone',
        'address',
        'address_line',
        'city',
        'state',
        'pincode',
    ];

    protected $casts = [
        'status_timeline' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function allStatuses(): array
    {
        return [
            'placed'     => ['label' => 'Order Placed',    'icon' => '🛒'],
            'processing' => ['label' => 'Processing',       'icon' => '🧵'],
            'shipped'    => ['label' => 'Shipped',          'icon' => '🚚'],
            'delivered'  => ['label' => 'Delivered',        'icon' => '✅'],
        ];
    }

    public function statusIndex(): int
    {
        $keys = array_keys(self::allStatuses());
        $index = array_search($this->status, $keys);
        return $index === false ? 0 : $index;
    }

    public function statusTimestamp(string $status): ?string
    {
        $timeline = $this->status_timeline ?? [];
        return $timeline[$status] ?? null;
    }

    public function statusLabel(): string
    {
        return self::allStatuses()[$this->status]['label']
            ?? ucfirst($this->status);
    }
}

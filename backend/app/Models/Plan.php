<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'slug',
        'price',
        'billing_cycle',
        'max_bookings',
        'max_resources',
        'max_staff',
        'features',
        'is_active',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    /** @return HasMany<Subscription, $this> */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}

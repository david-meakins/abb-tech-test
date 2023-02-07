<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use App\Events\ApplicationCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperApplication
 */
class Application extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => ApplicationStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => ApplicationCreated::class,
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    /**
     * Scope a query to only include Applications with a certain Plan type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasPlanType(\Illuminate\Database\Eloquent\Builder $query, string $type): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereRelation('plan', 'type', $type);
    }

}

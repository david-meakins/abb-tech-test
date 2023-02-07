<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperCustomer
 */
class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name'];

    public function getFullNameAttribute(): string
    {
        return implode(' ', array_filter([$this->first_name, $this->last_name]));
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}

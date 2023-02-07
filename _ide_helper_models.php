<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Application
 *
 * @property int $id
 * @property \App\Enums\ApplicationStatus $status
 * @property int $customer_id
 * @property int $plan_id
 * @property string $address_1
 * @property string|null $address_2
 * @property string $city
 * @property string $state
 * @property string $postcode
 * @property string|null $order_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\Plan $plan
 * @method static \Database\Factories\ApplicationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Application hasPlanType(string $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUpdatedAt($value)
 */
	class IdeHelperApplication {}
}

namespace App\Models{
/**
 * App\Models\Customer
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $last_name
 * @property string $email
 * @property string|null $mobile
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Application[] $applications
 * @property-read int|null $applications_count
 * @method static \Database\Factories\CustomerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 */
	class IdeHelperCustomer {}
}

namespace App\Models{
/**
 * App\Models\Plan
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int $monthly_cost
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Application[] $applications
 * @property-read int|null $applications_count
 * @method static \Database\Factories\PlanFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereMonthlyCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Plan whereUpdatedAt($value)
 */
	class IdeHelperPlan {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class IdeHelperUser {}
}


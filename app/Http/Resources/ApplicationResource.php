<?php

namespace App\Http\Resources;

use App\Enums\ApplicationStatus;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Application
 */
class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * The Customer and Plan objects are also candidates for having their own resource
     * objects, and then embedding those in the data instead.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_full_name' => $this->customer->full_name,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'city' => $this->city,
            'state' => $this->state,
            'postcode' => $this->postcode,
            'plan_type' => $this?->plan->type,
            'plan_name' => $this?->plan->name,
            // Assuming that "human readable dollar format" means the defaults for `number_format` and no dollar sign
            'plan_monthly_cost' => number_format(($this->plan->monthly_cost / 100), 2),
            'order_id' => $this->when($this->status === ApplicationStatus::Complete, $this->order_id),
        ];
    }
}

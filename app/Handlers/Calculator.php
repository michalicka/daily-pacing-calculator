<?php

namespace App\Handlers;

use DateTime;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Delivery;
use App\Models\Inputs;
use App\Models\Outputs;

class Calculator
{
    /** @var Carbon */
    private $date;

    /** @var Inputs */
    private $inputs;

    public function from(Carbon $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function process(Order $order): self
    {
        $inputs = new Inputs();
        $inputs->id = $order->id;
        $inputs->delivery = $order->client->deliveries
            ->where(Delivery::DELIVERY_DATE, '>=', $order->period_from)
            ->where(Delivery::DELIVERY_DATE, '<=', $this->date)
            ->count();
        $inputs->period_app_limit = $order->period_app_limit;
        $inputs->period_from = Carbon::parse($order->period_from);
        $inputs->period_to = Carbon::parse($order->period_to)->addSeconds(1);
        $inputs->remaining_apps = $inputs->period_app_limit - $inputs->delivery;
        $inputs->remaining_days = $this->date->diffInDays($inputs->period_to);
        $inputs->time_since_period_start = $inputs->period_from->diffInSeconds($this->date);
        $inputs->time_period_full = $inputs->period_from->diffInSeconds($inputs->period_to);
        $inputs->period_in_days = $inputs->period_from->diffInDays($inputs->period_to);

        $this->inputs = $inputs;

        return $this;
    }

    /** @var Callable[] $rules */
    public function with(array $rules): self
    {
        array_walk($rules, function ($rule) {
            $rule($this->inputs);
        });
        return $this;
    }

    public function result(): Outputs
    {
        $result = new Outputs();
        $result->id = $this->inputs->id;
        $result->rule = $this->inputs->rule;
        $result->daily_app_limit = $this->inputs->daily_app_limit;
        return $result;
    }
}

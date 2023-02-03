<?php

namespace App\Handlers;

use App\Models\Inputs;

class UnderdeliveryRule
{
    public function __invoke(Inputs $inputs): void 
    {
        if ($inputs->delivery / $inputs->period_app_limit < $inputs->time_since_period_start / $inputs->time_period_full) {
            $inputs->rule = 'underdelivery';
            $inputs->daily_app_limit = null;
        }
    }
}

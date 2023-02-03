<?php

namespace App\Handlers;

use App\Models\Inputs;

class EndOfPeriodRule
{
    public function __invoke(Inputs $inputs): void 
    {
        if (($inputs->time_period_full - $inputs->time_since_period_start) / $inputs->time_period_full * 100 <= 15) {
            $inputs->rule = 'end of period';
            $inputs->daily_app_limit = null;
        }
    }
}

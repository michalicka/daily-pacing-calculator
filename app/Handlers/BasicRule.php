<?php

namespace App\Handlers;

use App\Models\Inputs;

class BasicRule
{
    public function __invoke(Inputs $inputs): void 
    {
        $inputs->daily_app_limit = $inputs->remaining_days <= 0 ? 0 : (int)($inputs->remaining_apps / $inputs->remaining_days);
        $inputs->daily_app_limit = $inputs->daily_app_limit < 0 ? 0 : $inputs->daily_app_limit;
    }
}

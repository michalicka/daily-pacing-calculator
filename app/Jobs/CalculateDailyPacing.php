<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Inputs;
use App\Models\Outputs;
use App\Handlers\Calculator;
use App\Handlers\BasicRule;
use App\Handlers\EndOfPeriodRule;
use App\Handlers\UnderdeliveryRule;

class CalculateDailyPacing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Carbon */
    private $date;

    public function __construct(string $date = 'now')
    {
        $this->date = Carbon::parse($date)->startOfDay();
    }

    public function handle()
    {
        $rules = [
            new BasicRule,
            new EndOfPeriodRule,
            new UnderdeliveryRule,
        ];
        foreach (Order::all() as $order) {
            $result = (new Calculator)
                ->from($this->date)
                ->process($order)
                ->with($rules)
                ->result();

            $order->daily_app_limit = $result->daily_app_limit;
            $order->save();
            
            $this->log($result);
        }
    }

    private function log(Outputs $result): void
    {
        $message = sprintf(
            'Order %s daily app limit updated to "%s" by rule: %s',
            $result->id,
            $result->daily_app_limit !== null ? (string)$result->daily_app_limit : 'null',
            $result->rule
        );

        Log::info($message);
    }
}

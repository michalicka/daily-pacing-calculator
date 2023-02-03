<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CalculateDailyPacing as CalculateJob;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateDailyPacing extends Command
{
    private const DATE = 'date';

    protected $signature = 'pacing:calculate';
    protected $description = 'Calculate daily app pacing limit';

    /** @var string */
    private $date;

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument(self::DATE, InputArgument::OPTIONAL);
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->date = $input->getArgument(self::DATE) ?? 'now';
    }

    public function handle()
    {
        (new CalculateJob($this->date))->handle();
        return 0;
    }
}

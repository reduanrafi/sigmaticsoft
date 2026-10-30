<?php

namespace App\Console\Commands;

use App\Services\TrendIntelligence\TrendForecastEvaluationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class TrendEvaluateForecastsCommand extends Command
{
    protected $signature = 'trends:evaluate';

    protected $description = 'Evaluate published or archived forecasts whose target horizon date has completed.';

    public function handle(TrendForecastEvaluationService $evaluationService): int
    {
        $lock = Cache::lock('trends:evaluate:lock', 300);

        if (!$lock->get()) {
            $this->warn('Another trends:evaluate process is currently running. Skipping.');
            return self::SUCCESS;
        }

        try {
            $evaluations = $evaluationService->evaluateDueForecasts();
            $this->info(sprintf('Evaluated %d due forecast(s).', count($evaluations)));
            return self::SUCCESS;
        } finally {
            $lock->release();
        }
    }
}


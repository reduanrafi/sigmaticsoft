<?php

namespace App\Jobs;

use App\Models\TrendCategory;
use App\Models\TrendSource;
use App\Services\TrendIntelligence\TrendAnalysisService;
use App\Services\TrendIntelligence\TrendCollectionService;
use App\Services\TrendIntelligence\TrendForecastEvaluationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class RunTrendIntelligencePipelineJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $uniqueFor = 600;

    public function __construct(
        public bool $respectInterval = true
    ) {
    }

    public function uniqueId(): string
    {
        return 'trend-intelligence-pipeline';
    }

    public function backoff(): array
    {
        return [30, 120];
    }

    public function handle(
        TrendCollectionService $collectionService,
        TrendAnalysisService $analysisService,
        TrendForecastEvaluationService $evaluationService
    ): void {
        $lock = Cache::lock('trend-intelligence-pipeline-lock', 600);

        if (!$lock->get()) {
            return;
        }

        try {
            TrendCategory::ensureDefaultsExist();
            TrendSource::ensureDefaultSourcesExist();

            $collectionService->collectAllActive('scheduled', null, $this->respectInterval);
            $analysisService->analyzeAllCategories();
            $evaluationService->evaluateDueForecasts();
        } finally {
            $lock->release();
        }
    }
}


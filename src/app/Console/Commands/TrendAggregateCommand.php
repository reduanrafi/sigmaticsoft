<?php

namespace App\Console\Commands;

use App\Models\TrendCategory;
use App\Services\TrendIntelligence\TrendAnalysisService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class TrendAggregateCommand extends Command
{
    protected $signature = 'trends:aggregate {--category= : Optional category slug or ID}';

    protected $description = 'Aggregate normalized observations into weekly historical metrics and compute trend scores.';

    public function handle(TrendAnalysisService $analysisService): int
    {
        $lock = Cache::lock('trends:aggregate:lock', 300);

        if (!$lock->get()) {
            $this->warn('Another trends:aggregate process is currently running. Skipping.');
            return self::SUCCESS;
        }

        try {
            TrendCategory::ensureDefaultsExist();

            $categoryOption = $this->option('category');
            if ($categoryOption) {
                $category = TrendCategory::where('slug', $categoryOption)
                    ->orWhere('id', $categoryOption)
                    ->first();

                if (!$category) {
                    $this->error("Category '{$categoryOption}' not found.");
                    return self::FAILURE;
                }

                $metrics = $analysisService->analyzeCategory($category);
                $this->info("Aggregated {$metrics->count()} weekly metric record(s) for [{$category->slug}].");
                return self::SUCCESS;
            }

            $results = $analysisService->analyzeAllCategories();
            $this->info(sprintf('Aggregated weekly metrics for %d active categories.', count($results)));
            return self::SUCCESS;
        } finally {
            $lock->release();
        }
    }
}


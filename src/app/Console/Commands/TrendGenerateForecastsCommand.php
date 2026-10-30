<?php

namespace App\Console\Commands;

use App\Models\TrendCategory;
use App\Models\TrendForecast;
use App\Services\TrendIntelligence\TrendForecastService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class TrendGenerateForecastsCommand extends Command
{
    protected $signature = 'trends:forecast
                            {--category= : Optional category slug or ID}
                            {--horizon=3 : Horizon in months (3, 6, or 12)}
                            {--force : Generate even if a draft already exists for this week and horizon}';

    protected $description = 'Generate deterministic draft forecasts from stored weekly metrics without duplicating scheduled work.';

    public function handle(TrendForecastService $forecastService): int
    {
        $lock = Cache::lock('trends:forecast:lock', 300);

        if (!$lock->get()) {
            $this->warn('Another trends:forecast process is currently running. Skipping.');
            return self::SUCCESS;
        }

        try {
            TrendCategory::ensureDefaultsExist();

            $horizon = (int) $this->option('horizon');
            if (!in_array($horizon, TrendForecastService::ALLOWED_HORIZONS, true)) {
                $this->error('Invalid horizon. Allowed values: 3, 6, or 12.');
                return self::FAILURE;
            }

            $categoryOption = $this->option('category');
            $categories = $categoryOption
                ? TrendCategory::where('slug', $categoryOption)->orWhere('id', $categoryOption)->get()
                : TrendCategory::where('is_active', true)->orderBy('display_order')->get();

            $generatedCount = 0;
            $weekStart = Carbon::now()->startOfWeek(Carbon::MONDAY);

            foreach ($categories as $category) {
                if (!$this->option('force')) {
                    $alreadyGeneratedThisWeek = TrendForecast::where('trend_category_id', $category->id)
                        ->where('horizon_months', $horizon)
                        ->where('generated_at', '>=', $weekStart)
                        ->exists();

                    if ($alreadyGeneratedThisWeek) {
                        continue;
                    }
                }

                $forecastService->generateDraftForecast($category, $horizon);
                $generatedCount++;
            }

            $this->info("Generated {$generatedCount} draft forecast(s) for {$horizon}-month horizon.");
            return self::SUCCESS;
        } finally {
            $lock->release();
        }
    }
}


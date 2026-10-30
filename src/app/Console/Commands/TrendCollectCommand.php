<?php

namespace App\Console\Commands;

use App\Models\TrendCategory;
use App\Models\TrendSource;
use App\Services\TrendIntelligence\TrendCollectionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class TrendCollectCommand extends Command
{
    protected $signature = 'trends:collect
                            {--source= : Optional source slug or ID to collect}
                            {--force : Ignore fetch interval check}';

    protected $description = 'Collect public software industry trend observations with duplicate and overlap protection.';

    public function handle(TrendCollectionService $collectionService): int
    {
        $lock = Cache::lock('trends:collect:lock', 300);

        if (!$lock->get()) {
            $this->warn('Another trends:collect process is currently running. Skipping overlapping execution.');
            return self::SUCCESS;
        }

        try {
            TrendCategory::ensureDefaultsExist();
            TrendSource::ensureDefaultSourcesExist();

            $respectInterval = !$this->option('force');
            $sourceOption = $this->option('source');

            if ($sourceOption) {
                $source = TrendSource::where('slug', $sourceOption)
                    ->orWhere('id', $sourceOption)
                    ->first();

                if (!$source) {
                    $this->error("Trend source '{$sourceOption}' not found.");
                    return self::FAILURE;
                }

                $run = $collectionService->collectSource($source, 'cli', null, $respectInterval);
                $this->info("Source [{$source->slug}] run status: {$run->status} | Stored: {$run->items_stored} | Duplicates: {$run->items_skipped_duplicate}");
                return $run->status === 'failed' ? self::FAILURE : self::SUCCESS;
            }

            $runs = $collectionService->collectAllActive('scheduled', null, $respectInterval);
            $stored = collect($runs)->sum('items_stored');
            $dups = collect($runs)->sum('items_skipped_duplicate');

            $this->info(sprintf('Completed %d source collection run(s). Stored: %d, Duplicates skipped: %d.', count($runs), $stored, $dups));
            return self::SUCCESS;
        } finally {
            $lock->release();
        }
    }
}


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for Global Software Industry Trend Intelligence.
     */
    public function up(): void
    {
        // 1. Trend Categories
        if (!Schema::hasTable('trend_categories')) {
            Schema::create('trend_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('slug', 255)->unique();
                $table->text('description')->nullable();
                $table->string('primary_metric_unit', 64)->default('index_points');
                $table->unsignedInteger('display_order')->default(0);
                $table->unsignedInteger('min_observations_required')->default(3);
                $table->unsignedInteger('min_independent_sources')->default(1);
                $table->unsignedInteger('baseline_weeks')->default(4);
                $table->unsignedInteger('recent_weeks')->default(4);
                $table->json('keywords')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->index(['is_active', 'display_order']);
            });
        }

        // 2. Trend Sources
        if (!Schema::hasTable('trend_sources')) {
            Schema::create('trend_sources', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('slug', 255)->unique();
                $table->string('connector_type', 64); // hn_algolia, rss_feed, public_json_api
                $table->string('endpoint_url', 1000);
                $table->string('source_domain', 255)->nullable();
                $table->foreignId('default_category_id')
                    ->nullable()
                    ->constrained('trend_categories')
                    ->nullOnDelete();
                $table->text('description')->nullable();
                $table->text('terms_summary')->nullable();
                $table->unsignedInteger('rate_limit_per_minute')->default(10);
                $table->unsignedInteger('fetch_interval_minutes')->default(360);
                $table->decimal('trust_weight', 4, 2)->default(0.80);
                $table->boolean('allows_direct_metric_proof')->default(false);
                $table->json('config')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamp('last_collected_at')->nullable();
                $table->timestamps();

                $table->index(['is_active', 'connector_type']);
                $table->index('default_category_id');
            });
        }

        // 3. Collection Runs
        if (!Schema::hasTable('trend_collection_runs')) {
            Schema::create('trend_collection_runs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('trend_source_id')
                    ->constrained('trend_sources')
                    ->cascadeOnDelete();
                $table->string('triggered_by', 32)->default('manual'); // manual, scheduled, cli
                $table->foreignId('triggered_by_user_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();
                $table->string('status', 32)->default('running'); // running, completed, partial, failed
                $table->timestamp('started_at');
                $table->timestamp('finished_at')->nullable();
                $table->unsignedInteger('items_fetched')->default(0);
                $table->unsignedInteger('items_stored')->default(0);
                $table->unsignedInteger('items_skipped_duplicate')->default(0);
                $table->unsignedInteger('items_rejected_irrelevant')->default(0);
                $table->unsignedInteger('error_count')->default(0);
                $table->unsignedSmallInteger('http_status')->nullable();
                $table->unsignedInteger('duration_ms')->nullable();
                $table->text('summary_notes')->nullable();
                $table->timestamps();

                $table->index(['trend_source_id', 'started_at']);
                $table->index('status');
            });
        }

        // 4. Collection Errors
        if (!Schema::hasTable('trend_collection_errors')) {
            Schema::create('trend_collection_errors', function (Blueprint $table) {
                $table->id();
                $table->foreignId('trend_collection_run_id')
                    ->constrained('trend_collection_runs')
                    ->cascadeOnDelete();
                $table->foreignId('trend_source_id')
                    ->constrained('trend_sources')
                    ->cascadeOnDelete();
                $table->string('error_type', 64)->default('general'); // network, rate_limit, validation, parse, ssrf_blocked, auth_or_paywall
                $table->string('error_code', 64)->nullable();
                $table->text('message');
                $table->json('context')->nullable();
                $table->timestamp('occurred_at');
                $table->timestamps();

                $table->index(['trend_source_id', 'occurred_at']);
                $table->index('error_type');
            });
        }

        // 5. Normalized Observations
        if (!Schema::hasTable('trend_observations')) {
            Schema::create('trend_observations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('trend_source_id')
                    ->constrained('trend_sources')
                    ->cascadeOnDelete();
                $table->foreignId('trend_collection_run_id')
                    ->nullable()
                    ->constrained('trend_collection_runs')
                    ->nullOnDelete();
                $table->foreignId('trend_category_id')
                    ->constrained('trend_categories')
                    ->cascadeOnDelete();
                $table->string('source_name', 255);
                $table->string('original_url', 1000);
                $table->string('external_id', 255)->nullable();
                $table->string('duplicate_hash', 64)->unique();
                $table->string('title', 500);
                $table->text('summary')->nullable();
                $table->timestamp('published_at');
                $table->timestamp('collected_at');
                $table->string('metric_key', 100)->nullable();
                $table->decimal('metric_value', 16, 4)->nullable();
                $table->string('metric_unit', 64)->nullable();
                $table->string('evidence_type', 64)->default('article_signal'); // empirical_metric, survey_benchmark, official_report, article_signal, discussion_activity, repository_activity
                $table->boolean('is_direct_metric')->default(false);
                $table->decimal('evidence_quality_score', 5, 2)->default(0.50);
                $table->string('quality_status', 32)->default('provisional'); // verified, provisional, low_quality, flagged_contradictory
                $table->string('relevance_status', 32)->default('relevant'); // relevant, marginal, irrelevant, excluded
                $table->boolean('is_contradictory')->default(false);
                $table->text('contradiction_notes')->nullable();
                $table->json('raw_metadata')->nullable();
                $table->timestamps();

                $table->index(['trend_category_id', 'published_at']);
                $table->index(['trend_source_id', 'published_at']);
                $table->index(['relevance_status', 'quality_status', 'is_direct_metric'], 'trend_obs_rel_qual_direct_idx');
            });
        }

        // 6. Aggregated Historical Weekly Metrics
        if (!Schema::hasTable('trend_weekly_metrics')) {
            Schema::create('trend_weekly_metrics', function (Blueprint $table) {
                $table->id();
                $table->foreignId('trend_category_id')
                    ->constrained('trend_categories')
                    ->cascadeOnDelete();
                $table->string('year_week', 16); // e.g. 2026-W44
                $table->date('week_start_date');
                $table->date('week_end_date');
                $table->unsignedInteger('observation_count')->default(0);
                $table->unsignedInteger('empirical_observation_count')->default(0);
                $table->unsignedInteger('signal_only_count')->default(0);
                $table->unsignedInteger('independent_source_count')->default(0);
                $table->unsignedInteger('contradictory_observation_count')->default(0);
                $table->decimal('primary_metric_mean', 16, 4)->nullable();
                $table->decimal('primary_metric_median', 16, 4)->nullable();
                $table->decimal('primary_metric_sum', 16, 4)->nullable();
                $table->string('metric_unit', 64)->nullable();
                $table->decimal('baseline_mean', 16, 4)->nullable();
                $table->decimal('percent_change_vs_baseline', 10, 4)->nullable();
                $table->string('direction', 32)->default('insufficient_evidence'); // increasing, decreasing, stable, insufficient_evidence, contradictory
                $table->unsignedInteger('persistence_weeks')->default(0);
                $table->decimal('trend_score', 6, 2)->nullable();
                $table->string('evidence_sufficiency', 64)->default('insufficient_evidence'); // sufficient, insufficient_evidence, signal_only_no_direct_proof
                $table->json('score_breakdown')->nullable();
                $table->text('data_limitations')->nullable();
                $table->text('contradiction_summary')->nullable();
                $table->string('methodology_version', 32)->default('v1.0-deterministic');
                $table->timestamp('aggregated_at');
                $table->timestamps();

                $table->unique(['trend_category_id', 'year_week'], 'trend_weekly_cat_week_unique');
                $table->index(['trend_category_id', 'week_start_date']);
            });
        }

        // 7. Forecasts (Preserved as historical records, never overwritten)
        if (!Schema::hasTable('trend_forecasts')) {
            Schema::create('trend_forecasts', function (Blueprint $table) {
                $table->id();
                $table->string('forecast_code', 40)->unique();
                $table->foreignId('trend_category_id')
                    ->constrained('trend_categories')
                    ->cascadeOnDelete();
                $table->unsignedSmallInteger('horizon_months'); // 3, 6, or 12
                $table->string('title', 500);
                $table->string('slug', 255);
                $table->string('trend_direction', 32); // increasing, decreasing, stable, insufficient_evidence, contradictory
                $table->decimal('internal_trend_score', 6, 2)->nullable();
                $table->string('confidence_level', 32)->default('insufficient_data'); // high, moderate, low, insufficient_data
                $table->text('confidence_justification');
                $table->text('what_is_happening_now');
                $table->text('what_may_happen_next');
                $table->text('why_generated');
                $table->text('uncertainties_and_alternatives');
                $table->text('data_limitations')->nullable();
                $table->json('supporting_evidence');
                $table->json('baseline_snapshot')->nullable();
                $table->date('target_date');
                $table->string('methodology_version', 32)->default('v1.0-deterministic');
                $table->string('status', 32)->default('draft'); // draft, approved, published, unpublished, archived
                $table->timestamp('generated_at');
                $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('approved_at')->nullable();
                $table->foreignId('published_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('published_at')->nullable();
                $table->timestamp('unpublished_at')->nullable();
                $table->timestamp('archived_at')->nullable();
                $table->text('editorial_notes')->nullable();
                $table->timestamps();

                $table->index(['status', 'published_at']);
                $table->index(['trend_category_id', 'status', 'horizon_months'], 'trend_fc_cat_status_horizon_idx');
                $table->index('target_date');
            });
        }

        // 8. Forecast Evaluations
        if (!Schema::hasTable('trend_forecast_evaluations')) {
            Schema::create('trend_forecast_evaluations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('trend_forecast_id')
                    ->constrained('trend_forecasts')
                    ->cascadeOnDelete();
                $table->foreignId('evaluated_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();
                $table->timestamp('evaluated_at');
                $table->string('outcome_status', 32)->default('pending_horizon'); // verified_accurate, partially_accurate, inaccurate, inconclusive, pending_horizon
                $table->decimal('actual_baseline_value', 16, 4)->nullable();
                $table->decimal('actual_outcome_value', 16, 4)->nullable();
                $table->decimal('actual_percent_change', 10, 4)->nullable();
                $table->string('actual_direction', 32)->nullable();
                $table->text('evaluation_summary');
                $table->json('supporting_outcome_evidence')->nullable();
                $table->text('methodology_notes')->nullable();
                $table->boolean('is_public')->default(true);
                $table->timestamps();

                $table->index(['trend_forecast_id', 'is_public']);
                $table->index('outcome_status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trend_forecast_evaluations');
        Schema::dropIfExists('trend_forecasts');
        Schema::dropIfExists('trend_weekly_metrics');
        Schema::dropIfExists('trend_observations');
        Schema::dropIfExists('trend_collection_errors');
        Schema::dropIfExists('trend_collection_runs');
        Schema::dropIfExists('trend_sources');
        Schema::dropIfExists('trend_categories');
    }
};


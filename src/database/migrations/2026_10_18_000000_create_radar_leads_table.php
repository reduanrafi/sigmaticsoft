<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('radar_leads')) {
            Schema::create('radar_leads', function (Blueprint $table) {
            $table->string('id', 32)->primary();
            $table->string('source', 64);                     // e.g. reddit/shopify, hackernews, forum/odoo
            $table->string('title', 500);
            $table->mediumText('text')->nullable();
            $table->string('url', 1000);
            $table->string('author', 100)->nullable();
            $table->string('created_at_source', 100)->nullable();
            $table->timestamp('found_at')->useCurrent();

            // Scoring & AI Evaluation
            $table->integer('heuristic_score')->default(0);
            $table->integer('ai_score')->default(0);          // 1 - 10
            $table->text('problem_summary')->nullable();
            $table->string('service_fit', 64)->nullable();    // legacy_modernization, integration, ai_automation, etc.
            $table->string('budget_signal', 32)->nullable();  // none, low, medium, high
            $table->text('suggested_reply')->nullable();      // AI-drafted reply

            // Lead Pipeline Status
            $table->enum('status', [
                'new',
                'initiated',
                'contacted',
                'in_discussion',
                'won',
                'ignored'
            ])->default('new');

            $table->text('notes')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->timestamp('last_action_at')->nullable();
            $table->timestamps();

            // Indexes for fast dashboard filtering
            $table->index(['status', 'ai_score']);
            $table->index('found_at');
            $table->index('service_fit');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radar_leads');
    }
};

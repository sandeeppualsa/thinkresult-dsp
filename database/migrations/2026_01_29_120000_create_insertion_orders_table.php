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
        Schema::create('insertion_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->string('insertion_order_name');
            $table->enum('status', ['draft', 'active'])->default('draft');
            
            // Budget and Pacing
            $table->enum('budget_type', ['impressions', 'amount'])->nullable();
            $table->json('budget_items')->nullable(); // For impressions or amount items
            $table->enum('pacing_type', ['flight', 'daily'])->nullable();
            $table->enum('pacing_strategy', ['asap', 'even', 'ahead'])->nullable();
            $table->integer('pacing_daily_value')->nullable();
            
            // Goal
            $table->string('goal_type')->nullable(); // Cost per thousand impression (CPM)
            $table->decimal('impression_amount', 15, 2)->nullable();
            
            // Billable Outcome
            $table->string('billable_outcome')->nullable(); // impression
            
            // Optimization
            $table->enum('optimization_type', ['automate', 'control'])->nullable();
            $table->string('automate_strategy')->nullable(); // Maximize conversions, etc.
            $table->decimal('do_not_exceed_cpm', 15, 2)->nullable();
            $table->boolean('prioritize_deals')->default(false);
            $table->boolean('auto_optimize_budget')->default(false);
            
            // Frequency Cap
            $table->enum('frequency_cap_type', ['no_limit', 'limit'])->default('no_limit');
            $table->integer('frequency_cap_value')->nullable();
            $table->enum('frequency_cap_period', ['minute', 'hour', 'day', 'week', 'month'])->nullable();
            
            // Inventory Source
            $table->json('inventory_sources')->nullable();
            
            // Targeting - all stored as JSON
            $table->json('demographics')->nullable();
            $table->json('geography')->nullable();
            $table->json('languages')->nullable();
            $table->json('brand_safety')->nullable();
            $table->json('app_url')->nullable();
            $table->json('categories')->nullable();
            $table->json('environment')->nullable(); // Web, App checkboxes
            $table->string('viewability')->nullable();
            $table->json('device')->nullable(); // device_type, operating_system, make_model
            $table->json('keyword_contextual')->nullable();
            $table->json('position')->nullable();
            $table->json('day_time')->nullable(); // day, start_time, end_time, timezone
            $table->json('connection_speed')->nullable(); // target_by, netspeeds
            $table->json('browser')->nullable();
            $table->json('carrier_targeting')->nullable();
            $table->json('first_party_audience')->nullable();
            $table->json('third_party_audience')->nullable();
            $table->json('media_planner')->nullable();
            
            // Note
            $table->text('note')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insertion_orders');
    }
};


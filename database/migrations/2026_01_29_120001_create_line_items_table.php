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
        Schema::create('line_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            
            // Basic Fields
            $table->string('line_item_name');
            $table->enum('status', ['draft', 'active'])->default('draft');
            
            // Inventory Source
            $table->json('inventory_sources')->nullable();
            
            // Targeting Fields (all JSON)
            $table->json('demographics')->nullable();
            $table->json('geography')->nullable();
            $table->json('languages')->nullable();
            $table->json('brand_safety')->nullable();
            $table->json('app_url')->nullable();
            $table->json('categories')->nullable();
            $table->json('environment')->nullable();
            $table->string('viewability')->nullable();
            $table->json('device')->nullable();
            $table->json('keyword_contextual')->nullable();
            $table->json('position')->nullable();
            $table->json('day_time')->nullable();
            $table->json('connection_speed')->nullable();
            $table->json('browser')->nullable();
            $table->json('carrier_targeting')->nullable();
            $table->json('first_party_audience')->nullable();
            $table->json('third_party_audience')->nullable();
            $table->json('media_planner')->nullable();
            
            // Flight Dates
            $table->enum('flight_dates_type', ['use_campaign', 'custom'])->default('use_campaign');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            // Budget and Pacing
            $table->enum('budget_pacing_type', ['auto_adjust', 'fixed'])->default('auto_adjust');
            $table->enum('fixed_budget_type', ['flight', 'daily'])->nullable();
            $table->enum('fixed_budget_pacing', ['asap', 'even'])->nullable();
            $table->decimal('fixed_budget_amount', 15, 2)->nullable();
            $table->decimal('fixed_bid', 15, 2)->nullable();
            $table->enum('fixed_budget_limit_type', ['unlimited', 'custom'])->nullable();
            $table->decimal('fixed_budget_custom_limit', 15, 2)->nullable();
            
            // Note
            $table->text('note')->nullable();
            
            // Frequency Cap
            $table->enum('frequency_cap_type', ['no_limit', 'limit'])->default('no_limit');
            $table->integer('frequency_cap_value')->nullable();
            $table->enum('frequency_cap_period', ['month', 'week', 'day', 'hour', 'minute'])->nullable();
            
            // Creatives
            $table->json('creatives')->nullable();
            $table->enum('creatives_assignment_type', ['click', 'conversion', 'even'])->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_items');
    }
};


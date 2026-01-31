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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advertiser_id')->constrained('advertisers')->onDelete('cascade');
            $table->string('campaign_name');
            $table->enum('status', ['draft', 'active', 'paused'])->default('draft');
            $table->foreignId('overall_campaign_goal_id')->nullable()->constrained('campaign_goals')->onDelete('set null');
            $table->foreignId('kpi_id')->nullable()->constrained('kpis')->onDelete('set null');
            $table->foreignId('creative_type_id')->nullable()->constrained('creative_types')->onDelete('set null');
            $table->decimal('planned_spend', 15, 2)->nullable();
            $table->date('planned_start_date')->nullable();
            $table->date('planned_end_date')->nullable();
            $table->enum('frequency_cap_type', ['no_limit', 'limit'])->default('no_limit');
            $table->integer('frequency_cap_value')->nullable();
            $table->json('inventory_sources')->nullable();
            $table->json('demographics')->nullable();
            $table->json('geography')->nullable();
            $table->json('languages')->nullable();
            $table->json('brand_safety')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};


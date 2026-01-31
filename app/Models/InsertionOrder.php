<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsertionOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'campaign_id',
        'insertion_order_name',
        'status',
        'budget_type',
        'budget_items',
        'pacing_type',
        'pacing_strategy',
        'pacing_daily_value',
        'goal_type',
        'impression_amount',
        'billable_outcome',
        'optimization_type',
        'automate_strategy',
        'do_not_exceed_cpm',
        'prioritize_deals',
        'auto_optimize_budget',
        'frequency_cap_type',
        'frequency_cap_value',
        'frequency_cap_period',
        'inventory_sources',
        'demographics',
        'geography',
        'languages',
        'brand_safety',
        'app_url',
        'categories',
        'environment',
        'viewability',
        'device',
        'keyword_contextual',
        'position',
        'day_time',
        'connection_speed',
        'browser',
        'carrier_targeting',
        'first_party_audience',
        'third_party_audience',
        'media_planner',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'budget_items' => 'array',
            'impression_amount' => 'decimal:2',
            'do_not_exceed_cpm' => 'decimal:2',
            'prioritize_deals' => 'boolean',
            'auto_optimize_budget' => 'boolean',
            'inventory_sources' => 'array',
            'demographics' => 'array',
            'geography' => 'array',
            'languages' => 'array',
            'brand_safety' => 'array',
            'app_url' => 'array',
            'categories' => 'array',
            'environment' => 'array',
            'device' => 'array',
            'keyword_contextual' => 'array',
            'position' => 'array',
            'day_time' => 'array',
            'connection_speed' => 'array',
            'browser' => 'array',
            'carrier_targeting' => 'array',
            'first_party_audience' => 'array',
            'third_party_audience' => 'array',
            'media_planner' => 'array',
        ];
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}


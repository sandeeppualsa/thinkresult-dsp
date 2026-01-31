<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LineItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'campaign_id',
        'line_item_name',
        'status',
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
        'flight_dates_type',
        'start_date',
        'end_date',
        'budget_pacing_type',
        'fixed_budget_type',
        'fixed_budget_pacing',
        'fixed_budget_amount',
        'fixed_bid',
        'fixed_budget_limit_type',
        'fixed_budget_custom_limit',
        'note',
        'frequency_cap_type',
        'frequency_cap_value',
        'frequency_cap_period',
        'creatives',
        'creatives_assignment_type',
    ];

    protected function casts(): array
    {
        return [
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
            'creatives' => 'array',
            'fixed_bid' => 'decimal:2',
            'fixed_budget_amount' => 'decimal:2',
            'fixed_budget_custom_limit' => 'decimal:2',
            'frequency_cap_value' => 'integer',
        ];
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}


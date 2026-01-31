<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'advertiser_id',
        'campaign_name',
        'status',
        'overall_campaign_goal_id',
        'kpi_id',
        'creative_type_id',
        'planned_spend',
        'planned_start_date',
        'planned_end_date',
        'frequency_cap_type',
        'frequency_cap_value',
        'inventory_sources',
        'demographics',
        'geography',
        'languages',
        'brand_safety',
    ];

    protected function casts(): array
    {
        return [
            'planned_spend' => 'decimal:2',
            'planned_start_date' => 'date',
            'planned_end_date' => 'date',
            'inventory_sources' => 'array',
            'demographics' => 'array',
            'geography' => 'array',
            'languages' => 'array',
            'brand_safety' => 'array',
        ];
    }

    public function advertiser()
    {
        return $this->belongsTo(Advertiser::class);
    }

    public function campaignGoal()
    {
        return $this->belongsTo(CampaignGoal::class, 'overall_campaign_goal_id');
    }

    public function kpi()
    {
        return $this->belongsTo(KPI::class);
    }

    public function creativeType()
    {
        return $this->belongsTo(CreativeType::class);
    }

    public function insertionOrders()
    {
        return $this->hasMany(InsertionOrder::class);
    }

    public function lineItems()
    {
        return $this->hasMany(LineItem::class);
    }
}


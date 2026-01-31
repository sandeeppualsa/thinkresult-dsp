<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\InventorySource;
use App\Models\LineItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LineItemController extends Controller
{
    function index(Request $request, $advertiserId, $campaignId)
    {
        $campaign = Campaign::where('advertiser_id', $advertiserId)->find($campaignId);
        if (!$campaign) {
            return redirect('admin/advertisers/' . $advertiserId . '/campaigns')->with('error', 'Campaign not found');
        }

        $per_page = $request->get('per_page', 10);
        $page = $request->get('page', 1);
        $per_page = max(1, min(100, (int)$per_page));
        $page = max(1, (int)$page);

        $num_rows = LineItem::where('campaign_id', $campaignId)->count();
        $lineItems = LineItem::where('campaign_id', $campaignId)
            ->orderBy('id', 'desc')
            ->skip(($page - 1) * $per_page)
            ->take($per_page)
            ->get();

        $url = url('admin/advertisers/' . $advertiserId . '/campaigns/' . $campaignId . '/line-items') . '?';

        $data = [];
        $data['title'] = 'Line Items - ' . $campaign->campaign_name;
        $data['active_tab'] = 'advertisers';
        $data['line_items'] = $lineItems;
        $data['campaign'] = $campaign;
        $data['advertiser_id'] = $advertiserId;
        $data['campaign_id'] = $campaignId;
        $data['per_page'] = $per_page;
        $data['page'] = $page;
        $data['num_rows'] = $num_rows;
        $data['url'] = $url;

        return view('admin.line-items.index', $data);
    }

    function create($advertiserId, $campaignId)
    {
        $campaign = Campaign::where('advertiser_id', $advertiserId)->find($campaignId);
        if (!$campaign) {
            return redirect('admin/advertisers/' . $advertiserId . '/campaigns')->with('error', 'Campaign not found');
        }

        $data = [];
        $data['title'] = 'Add Line Item';
        $data['active_tab'] = 'advertisers';
        $data['campaign'] = $campaign;
        $data['advertiser_id'] = $advertiserId;
        $data['campaign_id'] = $campaignId;
        $data['inventory_sources'] = InventorySource::orderBy('name')->get();
        $data['brand_safety_options'] = [
            'Sexual',
            'Derogatory',
            'Downloads & sharing',
            'Weapons',
            'Gambling',
            'Violence',
            'Suggestive',
            'Profanity',
            'Alcohol',
            'Drugs',
            'Tobacco',
            'Politics',
            'Religion',
            'Tragedy',
            'Transportation accidents',
            'Shocking',
            'Sensitive social issues',
        ];
        $data['viewability_options'] = [
            'All impressions (greatest reach)',
            '90% or greater',
            '80% or greater',
            '70% or greater',
            '60% or greater',
            '50% or greater',
            '40% or greater',
            '30% or greater',
            '20% or greater',
            '10% or greater',
        ];

        return view('admin.line-items.create', $data);
    }

    function store(Request $request, $advertiserId, $campaignId)
    {
        $campaign = Campaign::where('advertiser_id', $advertiserId)->find($campaignId);
        if (!$campaign) {
            $this->response['error'] = 'Campaign not found';
            echo json_encode($this->response);
            return;
        }

        $validationRules = [
            'line_item_name' => 'required',
            'status' => 'required|in:draft,active',
            'flight_dates_type' => 'required|in:use_campaign,custom',
            'start_date' => 'nullable|date|required_if:flight_dates_type,custom',
            'end_date' => 'nullable|date|after_or_equal:start_date|required_if:flight_dates_type,custom',
            'budget_pacing_type' => 'required|in:auto_adjust,fixed',
            'fixed_budget_type' => 'nullable|in:flight,daily',
            'fixed_budget_pacing' => 'nullable|in:asap,even',
            'fixed_budget_amount' => 'nullable|numeric|min:0',
            'fixed_bid' => 'nullable|numeric|min:0',
            'fixed_budget_limit_type' => 'nullable|in:unlimited,custom|required_if:budget_pacing_type,fixed',
            'fixed_budget_custom_limit' => 'nullable|numeric|min:0|required_if:fixed_budget_limit_type,custom',
            'frequency_cap_type' => 'required|in:no_limit,limit',
            'frequency_cap_value' => 'nullable|integer|min:1|required_if:frequency_cap_type,limit',
            'frequency_cap_period' => 'nullable|in:month,week,day,hour,minute|required_if:frequency_cap_type,limit',
            'creatives_assignment_type' => 'nullable|in:click,conversion,even',
            'note' => 'nullable|string',
        ];

        $validation = Validator::make($request->all(), $validationRules);

        if (!$validation->fails()) {
            $lineItem = new LineItem();
            $lineItem->campaign_id = $campaignId;
            $lineItem->line_item_name = $request->line_item_name;
            $lineItem->status = $request->status;

            // Inventory Sources
            if ($request->has('inventory_sources')) {
                $inventorySources = is_array($request->inventory_sources) ? $request->inventory_sources : [];
                $lineItem->inventory_sources = $inventorySources;
            }

            // Targeting - Demographics
            $demographics = [];
            if ($request->has('genders')) {
                $demographics['genders'] = is_array($request->genders) ? $request->genders : [];
            }
            if ($request->has('age_ranges')) {
                $demographics['age_ranges'] = is_array($request->age_ranges) ? $request->age_ranges : [];
            }
            if ($request->has('parental_statuses')) {
                $demographics['parental_statuses'] = is_array($request->parental_statuses) ? $request->parental_statuses : [];
            }
            if ($request->has('household_incomes')) {
                $demographics['household_incomes'] = is_array($request->household_incomes) ? $request->household_incomes : [];
            }
            $lineItem->demographics = !empty($demographics) ? $demographics : null;

            // Geography
            if ($request->has('geography')) {
                $geography = is_array($request->geography) ? array_filter($request->geography) : [];
                $lineItem->geography = !empty($geography) ? $geography : null;
            }

            // Languages
            if ($request->has('languages')) {
                $languages = is_array($request->languages) ? array_filter($request->languages) : [];
                $lineItem->languages = !empty($languages) ? $languages : null;
            }

            // Brand Safety
            if ($request->has('brand_safety')) {
                $brandSafety = is_array($request->brand_safety) ? $request->brand_safety : [];
                $lineItem->brand_safety = !empty($brandSafety) ? $brandSafety : null;
            }

            // App & URL
            if ($request->has('app_url')) {
                $appUrl = is_array($request->app_url) ? array_filter($request->app_url) : [];
                $lineItem->app_url = !empty($appUrl) ? $appUrl : null;
            }

            // Categories
            if ($request->has('categories')) {
                $categories = is_array($request->categories) ? array_filter($request->categories) : [];
                $lineItem->categories = !empty($categories) ? $categories : null;
            }

            // Environment
            if ($request->has('environment')) {
                $environment = is_array($request->environment) ? $request->environment : [];
                $lineItem->environment = !empty($environment) ? $environment : null;
            }

            // Viewability
            $lineItem->viewability = $request->viewability;

            // Device
            $device = [];
            if ($request->has('device_types')) {
                $device['device_types'] = is_array($request->device_types) ? array_filter($request->device_types) : [];
            }
            if ($request->has('operating_systems')) {
                $device['operating_systems'] = is_array($request->operating_systems) ? array_filter($request->operating_systems) : [];
            }
            if ($request->has('make_models')) {
                $device['make_models'] = is_array($request->make_models) ? array_filter($request->make_models) : [];
            }
            $lineItem->device = !empty($device) ? $device : null;

            // Keyword/Contextual
            if ($request->has('keyword_contextual')) {
                $keywordContextual = is_array($request->keyword_contextual) ? array_filter($request->keyword_contextual) : [];
                $lineItem->keyword_contextual = !empty($keywordContextual) ? $keywordContextual : null;
            }

            // Position
            if ($request->has('position')) {
                $position = is_array($request->position) ? array_filter($request->position) : [];
                $lineItem->position = !empty($position) ? $position : null;
            }

            // Day & Time
            if ($request->has('day_time_entries')) {
                $dayTime = is_array($request->day_time_entries) ? $request->day_time_entries : [];
                if ($request->has('day_time_timezone')) {
                    $dayTime['timezone'] = $request->day_time_timezone;
                }
                $lineItem->day_time = !empty($dayTime) ? $dayTime : null;
            }

            // Connection Speed
            $connectionSpeed = [];
            if ($request->has('connection_speed_target_by')) {
                $connectionSpeed['target_by'] = $request->connection_speed_target_by;
            }
            if ($request->has('connection_speed_netspeeds')) {
                $connectionSpeed['netspeeds'] = $request->connection_speed_netspeeds;
            }
            $lineItem->connection_speed = !empty($connectionSpeed) ? $connectionSpeed : null;

            // Browser
            if ($request->has('browser')) {
                $browser = is_array($request->browser) ? array_filter($request->browser) : [];
                $lineItem->browser = !empty($browser) ? $browser : null;
            }

            // Carrier Targeting
            if ($request->has('carrier_targeting')) {
                $carrierTargeting = is_array($request->carrier_targeting) ? array_filter($request->carrier_targeting) : [];
                $lineItem->carrier_targeting = !empty($carrierTargeting) ? $carrierTargeting : null;
            }

            // First Party Audience
            if ($request->has('first_party_audience')) {
                $firstPartyAudience = is_array($request->first_party_audience) ? array_filter($request->first_party_audience) : [];
                $lineItem->first_party_audience = !empty($firstPartyAudience) ? $firstPartyAudience : null;
            }

            // Third Party Audience
            if ($request->has('third_party_audience')) {
                $thirdPartyAudience = is_array($request->third_party_audience) ? array_filter($request->third_party_audience) : [];
                $lineItem->third_party_audience = !empty($thirdPartyAudience) ? $thirdPartyAudience : null;
            }

            // Media Planner
            if ($request->has('media_planner')) {
                $mediaPlanner = is_array($request->media_planner) ? array_filter($request->media_planner) : [];
                $lineItem->media_planner = !empty($mediaPlanner) ? $mediaPlanner : null;
            }

            // Flight Dates
            $lineItem->flight_dates_type = $request->flight_dates_type;
            if ($request->flight_dates_type == 'use_campaign') {
                // Get dates from campaign
                if ($campaign->planned_start_date) {
                    $lineItem->start_date = $campaign->planned_start_date;
                }
                if ($campaign->planned_end_date) {
                    $lineItem->end_date = $campaign->planned_end_date;
                }
            } else {
                $lineItem->start_date = $request->start_date;
                $lineItem->end_date = $request->end_date;
            }

            // Budget and Pacing
            $lineItem->budget_pacing_type = $request->budget_pacing_type;
            if ($request->budget_pacing_type == 'fixed') {
                $lineItem->fixed_budget_type = $request->fixed_budget_type;
                $lineItem->fixed_budget_pacing = $request->fixed_budget_pacing;
                $lineItem->fixed_budget_amount = $request->fixed_budget_amount;
                $lineItem->fixed_budget_limit_type = $request->fixed_budget_limit_type;
                $lineItem->fixed_budget_custom_limit = $request->fixed_budget_limit_type == 'custom' ? $request->fixed_budget_custom_limit : null;
            } else {
                $lineItem->fixed_budget_type = null;
                $lineItem->fixed_budget_pacing = null;
                $lineItem->fixed_budget_amount = null;
                $lineItem->fixed_budget_limit_type = null;
                $lineItem->fixed_budget_custom_limit = null;
            }
            $lineItem->fixed_bid = $request->fixed_bid;
            $lineItem->note = $request->note;

            // Frequency Cap
            $lineItem->frequency_cap_type = $request->frequency_cap_type;
            $lineItem->frequency_cap_value = $request->frequency_cap_type == 'limit' ? $request->frequency_cap_value : null;
            $lineItem->frequency_cap_period = $request->frequency_cap_type == 'limit' ? $request->frequency_cap_period : null;

            // Creatives
            if ($request->has('creatives')) {
                $creatives = $request->creatives;
                if (is_string($creatives)) {
                    $creatives = json_decode($creatives, true);
                }
                $lineItem->creatives = is_array($creatives) ? $creatives : null;
            }
            $lineItem->creatives_assignment_type = $request->creatives_assignment_type;

            $lineItem->save();

            $this->response['status'] = 1;
            $this->response['msg'] = 'Line Item created successfully';
            $this->response['redirect_url'] = url('admin/advertisers/' . $advertiserId . '/campaigns/' . $campaignId . '/line-items');
        } else {
            $this->response['error_array'] = formatErrors($validation->errors()->toArray());
        }

        echo json_encode($this->response);
    }

    function edit($advertiserId, $campaignId, $lineItemId)
    {
        $campaign = Campaign::where('advertiser_id', $advertiserId)->find($campaignId);
        if (!$campaign) {
            return redirect('admin/advertisers/' . $advertiserId . '/campaigns')->with('error', 'Campaign not found');
        }

        $lineItem = LineItem::where('campaign_id', $campaignId)->find($lineItemId);
        if (!$lineItem) {
            return redirect('admin/advertisers/' . $advertiserId . '/campaigns/' . $campaignId . '/line-items')->with('error', 'Line Item not found');
        }

        $data = [];
        $data['title'] = 'Edit Line Item';
        $data['active_tab'] = 'advertisers';
        $data['line_item'] = $lineItem;
        $data['campaign'] = $campaign;
        $data['advertiser_id'] = $advertiserId;
        $data['campaign_id'] = $campaignId;
        $data['inventory_sources'] = InventorySource::orderBy('name')->get();
        $data['brand_safety_options'] = [
            'Sexual',
            'Derogatory',
            'Downloads & sharing',
            'Weapons',
            'Gambling',
            'Violence',
            'Suggestive',
            'Profanity',
            'Alcohol',
            'Drugs',
            'Tobacco',
            'Politics',
            'Religion',
            'Tragedy',
            'Transportation accidents',
            'Shocking',
            'Sensitive social issues',
        ];
        $data['viewability_options'] = [
            'All impressions (greatest reach)',
            '90% or greater',
            '80% or greater',
            '70% or greater',
            '60% or greater',
            '50% or greater',
            '40% or greater',
            '30% or greater',
            '20% or greater',
            '10% or greater',
        ];

        return view('admin.line-items.edit', $data);
    }

    function update(Request $request, $advertiserId, $campaignId, $lineItemId)
    {
        $campaign = Campaign::where('advertiser_id', $advertiserId)->find($campaignId);
        if (!$campaign) {
            $this->response['error'] = 'Campaign not found';
            echo json_encode($this->response);
            return;
        }

        $lineItem = LineItem::where('campaign_id', $campaignId)->find($lineItemId);
        if (!$lineItem) {
            $this->response['error'] = 'Line Item not found';
            echo json_encode($this->response);
            return;
        }

        $validationRules = [
            'line_item_name' => 'required',
            'status' => 'required|in:draft,active',
            'flight_dates_type' => 'required|in:use_campaign,custom',
            'start_date' => 'nullable|date|required_if:flight_dates_type,custom',
            'end_date' => 'nullable|date|after_or_equal:start_date|required_if:flight_dates_type,custom',
            'budget_pacing_type' => 'required|in:auto_adjust,fixed',
            'fixed_budget_type' => 'nullable|in:flight,daily',
            'fixed_budget_pacing' => 'nullable|in:asap,even',
            'fixed_budget_amount' => 'nullable|numeric|min:0',
            'fixed_bid' => 'nullable|numeric|min:0',
            'fixed_budget_limit_type' => 'nullable|in:unlimited,custom|required_if:budget_pacing_type,fixed',
            'fixed_budget_custom_limit' => 'nullable|numeric|min:0|required_if:fixed_budget_limit_type,custom',
            'frequency_cap_type' => 'required|in:no_limit,limit',
            'frequency_cap_value' => 'nullable|integer|min:1|required_if:frequency_cap_type,limit',
            'frequency_cap_period' => 'nullable|in:month,week,day,hour,minute|required_if:frequency_cap_type,limit',
            'creatives_assignment_type' => 'nullable|in:click,conversion,even',
            'note' => 'nullable|string',
        ];

        $validation = Validator::make($request->all(), $validationRules);

        if (!$validation->fails()) {
            $lineItem->line_item_name = $request->line_item_name;
            $lineItem->status = $request->status;

            // Inventory Sources
            if ($request->has('inventory_sources')) {
                $inventorySources = is_array($request->inventory_sources) ? $request->inventory_sources : [];
                $lineItem->inventory_sources = $inventorySources;
            } else {
                $lineItem->inventory_sources = null;
            }

            // Targeting - Demographics
            $demographics = [];
            if ($request->has('genders')) {
                $demographics['genders'] = is_array($request->genders) ? $request->genders : [];
            }
            if ($request->has('age_ranges')) {
                $demographics['age_ranges'] = is_array($request->age_ranges) ? $request->age_ranges : [];
            }
            if ($request->has('parental_statuses')) {
                $demographics['parental_statuses'] = is_array($request->parental_statuses) ? $request->parental_statuses : [];
            }
            if ($request->has('household_incomes')) {
                $demographics['household_incomes'] = is_array($request->household_incomes) ? $request->household_incomes : [];
            }
            $lineItem->demographics = !empty($demographics) ? $demographics : null;

            // Geography
            if ($request->has('geography')) {
                $geography = is_array($request->geography) ? array_filter($request->geography) : [];
                $lineItem->geography = !empty($geography) ? $geography : null;
            } else {
                $lineItem->geography = null;
            }

            // Languages
            if ($request->has('languages')) {
                $languages = is_array($request->languages) ? array_filter($request->languages) : [];
                $lineItem->languages = !empty($languages) ? $languages : null;
            } else {
                $lineItem->languages = null;
            }

            // Brand Safety
            if ($request->has('brand_safety')) {
                $brandSafety = is_array($request->brand_safety) ? $request->brand_safety : [];
                $lineItem->brand_safety = !empty($brandSafety) ? $brandSafety : null;
            } else {
                $lineItem->brand_safety = null;
            }

            // App & URL
            if ($request->has('app_url')) {
                $appUrl = is_array($request->app_url) ? array_filter($request->app_url) : [];
                $lineItem->app_url = !empty($appUrl) ? $appUrl : null;
            } else {
                $lineItem->app_url = null;
            }

            // Categories
            if ($request->has('categories')) {
                $categories = is_array($request->categories) ? array_filter($request->categories) : [];
                $lineItem->categories = !empty($categories) ? $categories : null;
            } else {
                $lineItem->categories = null;
            }

            // Environment
            if ($request->has('environment')) {
                $environment = is_array($request->environment) ? $request->environment : [];
                $lineItem->environment = !empty($environment) ? $environment : null;
            } else {
                $lineItem->environment = null;
            }

            // Viewability
            $lineItem->viewability = $request->viewability;

            // Device
            $device = [];
            if ($request->has('device_types')) {
                $device['device_types'] = is_array($request->device_types) ? array_filter($request->device_types) : [];
            }
            if ($request->has('operating_systems')) {
                $device['operating_systems'] = is_array($request->operating_systems) ? array_filter($request->operating_systems) : [];
            }
            if ($request->has('make_models')) {
                $device['make_models'] = is_array($request->make_models) ? array_filter($request->make_models) : [];
            }
            $lineItem->device = !empty($device) ? $device : null;

            // Keyword/Contextual
            if ($request->has('keyword_contextual')) {
                $keywordContextual = is_array($request->keyword_contextual) ? array_filter($request->keyword_contextual) : [];
                $lineItem->keyword_contextual = !empty($keywordContextual) ? $keywordContextual : null;
            } else {
                $lineItem->keyword_contextual = null;
            }

            // Position
            if ($request->has('position')) {
                $position = is_array($request->position) ? array_filter($request->position) : [];
                $lineItem->position = !empty($position) ? $position : null;
            } else {
                $lineItem->position = null;
            }

            // Day & Time
            if ($request->has('day_time_entries')) {
                $dayTime = is_array($request->day_time_entries) ? $request->day_time_entries : [];
                if ($request->has('day_time_timezone')) {
                    $dayTime['timezone'] = $request->day_time_timezone;
                }
                $lineItem->day_time = !empty($dayTime) ? $dayTime : null;
            } else {
                $lineItem->day_time = null;
            }

            // Connection Speed
            $connectionSpeed = [];
            if ($request->has('connection_speed_target_by')) {
                $connectionSpeed['target_by'] = $request->connection_speed_target_by;
            }
            if ($request->has('connection_speed_netspeeds')) {
                $connectionSpeed['netspeeds'] = $request->connection_speed_netspeeds;
            }
            $lineItem->connection_speed = !empty($connectionSpeed) ? $connectionSpeed : null;

            // Browser
            if ($request->has('browser')) {
                $browser = is_array($request->browser) ? array_filter($request->browser) : [];
                $lineItem->browser = !empty($browser) ? $browser : null;
            } else {
                $lineItem->browser = null;
            }

            // Carrier Targeting
            if ($request->has('carrier_targeting')) {
                $carrierTargeting = is_array($request->carrier_targeting) ? array_filter($request->carrier_targeting) : [];
                $lineItem->carrier_targeting = !empty($carrierTargeting) ? $carrierTargeting : null;
            } else {
                $lineItem->carrier_targeting = null;
            }

            // First Party Audience
            if ($request->has('first_party_audience')) {
                $firstPartyAudience = is_array($request->first_party_audience) ? array_filter($request->first_party_audience) : [];
                $lineItem->first_party_audience = !empty($firstPartyAudience) ? $firstPartyAudience : null;
            } else {
                $lineItem->first_party_audience = null;
            }

            // Third Party Audience
            if ($request->has('third_party_audience')) {
                $thirdPartyAudience = is_array($request->third_party_audience) ? array_filter($request->third_party_audience) : [];
                $lineItem->third_party_audience = !empty($thirdPartyAudience) ? $thirdPartyAudience : null;
            } else {
                $lineItem->third_party_audience = null;
            }

            // Media Planner
            if ($request->has('media_planner')) {
                $mediaPlanner = is_array($request->media_planner) ? array_filter($request->media_planner) : [];
                $lineItem->media_planner = !empty($mediaPlanner) ? $mediaPlanner : null;
            } else {
                $lineItem->media_planner = null;
            }

            // Flight Dates
            $lineItem->flight_dates_type = $request->flight_dates_type;
            if ($request->flight_dates_type == 'use_campaign') {
                // Get dates from campaign
                if ($campaign->planned_start_date) {
                    $lineItem->start_date = $campaign->planned_start_date;
                }
                if ($campaign->planned_end_date) {
                    $lineItem->end_date = $campaign->planned_end_date;
                }
            } else {
                $lineItem->start_date = $request->start_date;
                $lineItem->end_date = $request->end_date;
            }

            // Budget and Pacing
            $lineItem->budget_pacing_type = $request->budget_pacing_type;
            if ($request->budget_pacing_type == 'fixed') {
                $lineItem->fixed_budget_type = $request->fixed_budget_type;
                $lineItem->fixed_budget_pacing = $request->fixed_budget_pacing;
                $lineItem->fixed_budget_amount = $request->fixed_budget_amount;
                $lineItem->fixed_budget_limit_type = $request->fixed_budget_limit_type;
                $lineItem->fixed_budget_custom_limit = $request->fixed_budget_limit_type == 'custom' ? $request->fixed_budget_custom_limit : null;
            } else {
                $lineItem->fixed_budget_type = null;
                $lineItem->fixed_budget_pacing = null;
                $lineItem->fixed_budget_amount = null;
                $lineItem->fixed_budget_limit_type = null;
                $lineItem->fixed_budget_custom_limit = null;
            }
            $lineItem->fixed_bid = $request->fixed_bid;
            $lineItem->note = $request->note;

            // Frequency Cap
            $lineItem->frequency_cap_type = $request->frequency_cap_type;
            $lineItem->frequency_cap_value = $request->frequency_cap_type == 'limit' ? $request->frequency_cap_value : null;
            $lineItem->frequency_cap_period = $request->frequency_cap_type == 'limit' ? $request->frequency_cap_period : null;

            // Creatives
            if ($request->has('creatives')) {
                $creatives = $request->creatives;
                if (is_string($creatives)) {
                    $creatives = json_decode($creatives, true);
                }
                $lineItem->creatives = is_array($creatives) ? $creatives : null;
            } else {
                $lineItem->creatives = null;
            }
            $lineItem->creatives_assignment_type = $request->creatives_assignment_type;

            $lineItem->save();

            $this->response['status'] = 1;
            $this->response['msg'] = 'Line Item updated successfully';
            $this->response['redirect_url'] = url('admin/advertisers/' . $advertiserId . '/campaigns/' . $campaignId . '/line-items');
        } else {
            $this->response['error_array'] = formatErrors($validation->errors()->toArray());
        }

        echo json_encode($this->response);
    }

    function destroy($advertiserId, $campaignId, $lineItemId)
    {
        $lineItem = LineItem::where('campaign_id', $campaignId)->find($lineItemId);
        if ($lineItem) {
            $lineItem->delete();
            $this->response['status'] = 1;
            $this->response['msg'] = 'Line Item deleted successfully';
        } else {
            $this->response['error'] = 'Line Item not found';
        }

        echo json_encode($this->response);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\InsertionOrder;
use App\Models\InventorySource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InsertionOrderController extends Controller
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

        $num_rows = InsertionOrder::where('campaign_id', $campaignId)->count();
        $insertionOrders = InsertionOrder::where('campaign_id', $campaignId)
            ->orderBy('id', 'desc')
            ->skip(($page - 1) * $per_page)
            ->take($per_page)
            ->get();

        $url = url('admin/advertisers/' . $advertiserId . '/campaigns/' . $campaignId . '/insertion-orders') . '?';

        $data = [];
        $data['title'] = 'Insertion Orders - ' . $campaign->campaign_name;
        $data['active_tab'] = 'advertisers';
        $data['insertion_orders'] = $insertionOrders;
        $data['campaign'] = $campaign;
        $data['advertiser_id'] = $advertiserId;
        $data['per_page'] = $per_page;
        $data['page'] = $page;
        $data['num_rows'] = $num_rows;
        $data['url'] = $url;

        return view('admin.insertion-orders.index', $data);
    }

    function create($advertiserId, $campaignId)
    {
        $campaign = Campaign::where('advertiser_id', $advertiserId)->find($campaignId);
        if (!$campaign) {
            return redirect('admin/advertisers/' . $advertiserId . '/campaigns')->with('error', 'Campaign not found');
        }

        $data = [];
        $data['title'] = 'Add Insertion Order';
        $data['active_tab'] = 'advertisers';
        $data['campaign'] = $campaign;
        $data['advertiser_id'] = $advertiserId;
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
        $data['automate_strategy_options'] = [
            'Maximize conversions',
            'Maximize clicks',
            'Maximize viewable impressions',
            'Maximize completed in-view and audible',
            'Maximize viewable for at least 10 second',
        ];

        return view('admin.insertion-orders.create', $data);
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
            'insertion_order_name' => 'required',
            'status' => 'required|in:draft,active',
            'budget_type' => 'nullable|in:impressions,amount',
            'pacing_type' => 'nullable|in:flight,daily',
            'pacing_strategy' => 'nullable|in:asap,even,ahead',
            'pacing_daily_value' => 'nullable|integer|min:1|required_if:pacing_type,daily',
            'goal_type' => 'nullable',
            'impression_amount' => 'nullable|numeric|min:0',
            'billable_outcome' => 'nullable',
            'optimization_type' => 'nullable|in:automate,control',
            'frequency_cap_type' => 'required|in:no_limit,limit',
            'frequency_cap_value' => 'nullable|integer|min:1|required_if:frequency_cap_type,limit',
            'frequency_cap_period' => 'nullable|in:minute,hour,day,week,month|required_if:frequency_cap_type,limit',
        ];

        $validation = Validator::make($request->all(), $validationRules);

        if (!$validation->fails()) {
            $insertionOrder = new InsertionOrder();
            $insertionOrder->campaign_id = $campaignId;
            $insertionOrder->insertion_order_name = $request->insertion_order_name;
            $insertionOrder->status = $request->status;
            
            // Budget and Pacing
            $insertionOrder->budget_type = $request->budget_type;
            if ($request->has('budget_items')) {
                $budgetItems = $request->budget_items;
                if (is_string($budgetItems)) {
                    $budgetItems = json_decode($budgetItems, true);
                }
                $insertionOrder->budget_items = is_array($budgetItems) ? $budgetItems : [];
            }
            $insertionOrder->pacing_type = $request->pacing_type;
            $insertionOrder->pacing_strategy = $request->pacing_strategy;
            $insertionOrder->pacing_daily_value = $request->pacing_daily_value;
            
            // Goal
            $insertionOrder->goal_type = $request->goal_type;
            $insertionOrder->impression_amount = $request->impression_amount;
            
            // Billable Outcome
            $insertionOrder->billable_outcome = $request->billable_outcome;
            
            // Optimization
            $insertionOrder->optimization_type = $request->optimization_type;
            $insertionOrder->automate_strategy = $request->automate_strategy;
            $insertionOrder->do_not_exceed_cpm = $request->has('do_not_exceed_cpm_check') && $request->do_not_exceed_cpm_check ? $request->do_not_exceed_cpm : null;
            $insertionOrder->prioritize_deals = $request->has('prioritize_deals') ? true : false;
            $insertionOrder->auto_optimize_budget = $request->has('auto_optimize_budget') ? true : false;
            
            // Frequency Cap
            $insertionOrder->frequency_cap_type = $request->frequency_cap_type;
            $insertionOrder->frequency_cap_value = $request->frequency_cap_type == 'limit' ? $request->frequency_cap_value : null;
            $insertionOrder->frequency_cap_period = $request->frequency_cap_type == 'limit' ? $request->frequency_cap_period : null;
            
            // Inventory Sources
            if ($request->has('inventory_sources')) {
                $inventorySources = is_array($request->inventory_sources) ? $request->inventory_sources : [];
                $insertionOrder->inventory_sources = $inventorySources;
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
            $insertionOrder->demographics = !empty($demographics) ? $demographics : null;
            
            // Geography
            if ($request->has('geography')) {
                $geography = is_array($request->geography) ? array_filter($request->geography) : [];
                $insertionOrder->geography = !empty($geography) ? $geography : null;
            }
            
            // Languages
            if ($request->has('languages')) {
                $languages = is_array($request->languages) ? array_filter($request->languages) : [];
                $insertionOrder->languages = !empty($languages) ? $languages : null;
            }
            
            // Brand Safety
            if ($request->has('brand_safety')) {
                $brandSafety = is_array($request->brand_safety) ? $request->brand_safety : [];
                $insertionOrder->brand_safety = !empty($brandSafety) ? $brandSafety : null;
            }
            
            // App & URL
            if ($request->has('app_url')) {
                $appUrl = is_array($request->app_url) ? array_filter($request->app_url) : [];
                $insertionOrder->app_url = !empty($appUrl) ? $appUrl : null;
            }
            
            // Categories
            if ($request->has('categories')) {
                $categories = is_array($request->categories) ? array_filter($request->categories) : [];
                $insertionOrder->categories = !empty($categories) ? $categories : null;
            }
            
            // Environment
            if ($request->has('environment')) {
                $environment = is_array($request->environment) ? $request->environment : [];
                $insertionOrder->environment = !empty($environment) ? $environment : null;
            }
            
            // Viewability
            $insertionOrder->viewability = $request->viewability;
            
            // Device
            $device = [];
            if ($request->has('device_type')) {
                $device['device_type'] = is_array($request->device_type) ? array_filter($request->device_type) : [];
            }
            if ($request->has('operating_system')) {
                $device['operating_system'] = is_array($request->operating_system) ? array_filter($request->operating_system) : [];
            }
            if ($request->has('make_model')) {
                $device['make_model'] = is_array($request->make_model) ? array_filter($request->make_model) : [];
            }
            $insertionOrder->device = !empty($device) ? $device : null;
            
            // Keyword/Contextual
            if ($request->has('keyword_contextual')) {
                $keywordContextual = is_array($request->keyword_contextual) ? array_filter($request->keyword_contextual) : [];
                $insertionOrder->keyword_contextual = !empty($keywordContextual) ? $keywordContextual : null;
            }
            
            // Position
            if ($request->has('position')) {
                $position = is_array($request->position) ? array_filter($request->position) : [];
                $insertionOrder->position = !empty($position) ? $position : null;
            }
            
            // Day & Time
            $dayTime = [];
            if ($request->has('day_time_entries')) {
                $entries = $request->day_time_entries;
                if (is_array($entries)) {
                    foreach ($entries as $entry) {
                        if (is_string($entry)) {
                            $decoded = json_decode($entry, true);
                            if ($decoded) {
                                $dayTime[] = $decoded;
                            }
                        } else {
                            $dayTime[] = $entry;
                        }
                    }
                }
            }
            if ($request->has('day_time_timezone')) {
                $dayTime['timezone'] = $request->day_time_timezone;
            }
            $insertionOrder->day_time = !empty($dayTime) ? $dayTime : null;
            
            // Connection Speed
            $connectionSpeed = [];
            if ($request->has('connection_speed_target_by')) {
                $connectionSpeed['target_by'] = $request->connection_speed_target_by;
            }
            if ($request->has('connection_speed_netspeeds')) {
                $connectionSpeed['netspeeds'] = is_array($request->connection_speed_netspeeds) ? $request->connection_speed_netspeeds : [];
            }
            $insertionOrder->connection_speed = !empty($connectionSpeed) ? $connectionSpeed : null;
            
            // Browser
            if ($request->has('browser')) {
                $browser = is_array($request->browser) ? array_filter($request->browser) : [];
                $insertionOrder->browser = !empty($browser) ? $browser : null;
            }
            
            // Carrier Targeting
            if ($request->has('carrier_targeting')) {
                $carrierTargeting = is_array($request->carrier_targeting) ? array_filter($request->carrier_targeting) : [];
                $insertionOrder->carrier_targeting = !empty($carrierTargeting) ? $carrierTargeting : null;
            }
            
            // First Party Audience
            if ($request->has('first_party_audience')) {
                $firstPartyAudience = is_array($request->first_party_audience) ? array_filter($request->first_party_audience) : [];
                $insertionOrder->first_party_audience = !empty($firstPartyAudience) ? $firstPartyAudience : null;
            }
            
            // Third Party Audience
            if ($request->has('third_party_audience')) {
                $thirdPartyAudience = is_array($request->third_party_audience) ? array_filter($request->third_party_audience) : [];
                $insertionOrder->third_party_audience = !empty($thirdPartyAudience) ? $thirdPartyAudience : null;
            }
            
            // Media Planner
            if ($request->has('media_planner')) {
                $mediaPlanner = is_array($request->media_planner) ? array_filter($request->media_planner) : [];
                $insertionOrder->media_planner = !empty($mediaPlanner) ? $mediaPlanner : null;
            }
            
            // Note
            $insertionOrder->note = $request->note;
            
            $insertionOrder->save();

            $this->response['status'] = 1;
            $this->response['msg'] = 'Insertion Order created successfully';
            $this->response['redirect_url'] = url('admin/advertisers/' . $advertiserId . '/campaigns/' . $campaignId . '/insertion-orders');
        } else {
            $this->response['error_array'] = formatErrors($validation->errors()->toArray());
        }

        echo json_encode($this->response);
    }

    function edit($advertiserId, $campaignId, $insertionOrderId)
    {
        $campaign = Campaign::where('advertiser_id', $advertiserId)->find($campaignId);
        if (!$campaign) {
            return redirect('admin/advertisers/' . $advertiserId . '/campaigns')->with('error', 'Campaign not found');
        }

        $insertionOrder = InsertionOrder::where('campaign_id', $campaignId)->find($insertionOrderId);
        if (!$insertionOrder) {
            return redirect('admin/advertisers/' . $advertiserId . '/campaigns/' . $campaignId . '/insertion-orders')->with('error', 'Insertion Order not found');
        }

        $data = [];
        $data['title'] = 'Edit Insertion Order';
        $data['active_tab'] = 'advertisers';
        $data['campaign'] = $campaign;
        $data['advertiser_id'] = $advertiserId;
        $data['insertion_order'] = $insertionOrder;
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
        $data['automate_strategy_options'] = [
            'Maximize conversions',
            'Maximize clicks',
            'Maximize viewable impressions',
            'Maximize completed in-view and audible',
            'Maximize viewable for at least 10 second',
        ];

        return view('admin.insertion-orders.edit', $data);
    }

    function update(Request $request, $advertiserId, $campaignId, $insertionOrderId)
    {
        $campaign = Campaign::where('advertiser_id', $advertiserId)->find($campaignId);
        if (!$campaign) {
            $this->response['error'] = 'Campaign not found';
            echo json_encode($this->response);
            return;
        }

        $insertionOrder = InsertionOrder::where('campaign_id', $campaignId)->find($insertionOrderId);
        if (!$insertionOrder) {
            $this->response['error'] = 'Insertion Order not found';
            echo json_encode($this->response);
            return;
        }

        $validationRules = [
            'insertion_order_name' => 'required',
            'status' => 'required|in:draft,active',
            'budget_type' => 'nullable|in:impressions,amount',
            'pacing_type' => 'nullable|in:flight,daily',
            'pacing_strategy' => 'nullable|in:asap,even,ahead',
            'pacing_daily_value' => 'nullable|integer|min:1|required_if:pacing_type,daily',
            'goal_type' => 'nullable',
            'impression_amount' => 'nullable|numeric|min:0',
            'billable_outcome' => 'nullable',
            'optimization_type' => 'nullable|in:automate,control',
            'frequency_cap_type' => 'required|in:no_limit,limit',
            'frequency_cap_value' => 'nullable|integer|min:1|required_if:frequency_cap_type,limit',
            'frequency_cap_period' => 'nullable|in:minute,hour,day,week,month|required_if:frequency_cap_type,limit',
        ];

        $validation = Validator::make($request->all(), $validationRules);

        if (!$validation->fails()) {
            $insertionOrder->insertion_order_name = $request->insertion_order_name;
            $insertionOrder->status = $request->status;
            
            // Budget and Pacing
            $insertionOrder->budget_type = $request->budget_type;
            if ($request->has('budget_items')) {
                $budgetItems = $request->budget_items;
                if (is_string($budgetItems)) {
                    $budgetItems = json_decode($budgetItems, true);
                }
                $insertionOrder->budget_items = is_array($budgetItems) ? $budgetItems : [];
            } else {
                $insertionOrder->budget_items = null;
            }
            $insertionOrder->pacing_type = $request->pacing_type;
            $insertionOrder->pacing_strategy = $request->pacing_strategy;
            $insertionOrder->pacing_daily_value = $request->pacing_daily_value;
            
            // Goal
            $insertionOrder->goal_type = $request->goal_type;
            $insertionOrder->impression_amount = $request->impression_amount;
            
            // Billable Outcome
            $insertionOrder->billable_outcome = $request->billable_outcome;
            
            // Optimization
            $insertionOrder->optimization_type = $request->optimization_type;
            $insertionOrder->automate_strategy = $request->automate_strategy;
            $insertionOrder->do_not_exceed_cpm = $request->has('do_not_exceed_cpm_check') && $request->do_not_exceed_cpm_check ? $request->do_not_exceed_cpm : null;
            $insertionOrder->prioritize_deals = $request->has('prioritize_deals') ? true : false;
            $insertionOrder->auto_optimize_budget = $request->has('auto_optimize_budget') ? true : false;
            
            // Frequency Cap
            $insertionOrder->frequency_cap_type = $request->frequency_cap_type;
            $insertionOrder->frequency_cap_value = $request->frequency_cap_type == 'limit' ? $request->frequency_cap_value : null;
            $insertionOrder->frequency_cap_period = $request->frequency_cap_type == 'limit' ? $request->frequency_cap_period : null;
            
            // Inventory Sources
            if ($request->has('inventory_sources')) {
                $inventorySources = is_array($request->inventory_sources) ? $request->inventory_sources : [];
                $insertionOrder->inventory_sources = $inventorySources;
            } else {
                $insertionOrder->inventory_sources = null;
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
            $insertionOrder->demographics = !empty($demographics) ? $demographics : null;
            
            // Geography
            if ($request->has('geography')) {
                $geography = is_array($request->geography) ? array_filter($request->geography) : [];
                $insertionOrder->geography = !empty($geography) ? $geography : null;
            } else {
                $insertionOrder->geography = null;
            }
            
            // Languages
            if ($request->has('languages')) {
                $languages = is_array($request->languages) ? array_filter($request->languages) : [];
                $insertionOrder->languages = !empty($languages) ? $languages : null;
            } else {
                $insertionOrder->languages = null;
            }
            
            // Brand Safety
            if ($request->has('brand_safety')) {
                $brandSafety = is_array($request->brand_safety) ? $request->brand_safety : [];
                $insertionOrder->brand_safety = !empty($brandSafety) ? $brandSafety : null;
            } else {
                $insertionOrder->brand_safety = null;
            }
            
            // App & URL
            if ($request->has('app_url')) {
                $appUrl = is_array($request->app_url) ? array_filter($request->app_url) : [];
                $insertionOrder->app_url = !empty($appUrl) ? $appUrl : null;
            } else {
                $insertionOrder->app_url = null;
            }
            
            // Categories
            if ($request->has('categories')) {
                $categories = is_array($request->categories) ? array_filter($request->categories) : [];
                $insertionOrder->categories = !empty($categories) ? $categories : null;
            } else {
                $insertionOrder->categories = null;
            }
            
            // Environment
            if ($request->has('environment')) {
                $environment = is_array($request->environment) ? $request->environment : [];
                $insertionOrder->environment = !empty($environment) ? $environment : null;
            } else {
                $insertionOrder->environment = null;
            }
            
            // Viewability
            $insertionOrder->viewability = $request->viewability;
            
            // Device
            $device = [];
            if ($request->has('device_type')) {
                $device['device_type'] = is_array($request->device_type) ? array_filter($request->device_type) : [];
            }
            if ($request->has('operating_system')) {
                $device['operating_system'] = is_array($request->operating_system) ? array_filter($request->operating_system) : [];
            }
            if ($request->has('make_model')) {
                $device['make_model'] = is_array($request->make_model) ? array_filter($request->make_model) : [];
            }
            $insertionOrder->device = !empty($device) ? $device : null;
            
            // Keyword/Contextual
            if ($request->has('keyword_contextual')) {
                $keywordContextual = is_array($request->keyword_contextual) ? array_filter($request->keyword_contextual) : [];
                $insertionOrder->keyword_contextual = !empty($keywordContextual) ? $keywordContextual : null;
            } else {
                $insertionOrder->keyword_contextual = null;
            }
            
            // Position
            if ($request->has('position')) {
                $position = is_array($request->position) ? array_filter($request->position) : [];
                $insertionOrder->position = !empty($position) ? $position : null;
            } else {
                $insertionOrder->position = null;
            }
            
            // Day & Time
            $dayTime = [];
            if ($request->has('day_time_entries')) {
                $entries = $request->day_time_entries;
                if (is_array($entries)) {
                    foreach ($entries as $entry) {
                        if (is_string($entry)) {
                            $decoded = json_decode($entry, true);
                            if ($decoded) {
                                $dayTime[] = $decoded;
                            }
                        } else {
                            $dayTime[] = $entry;
                        }
                    }
                }
            }
            if ($request->has('day_time_timezone')) {
                $dayTime['timezone'] = $request->day_time_timezone;
            }
            $insertionOrder->day_time = !empty($dayTime) ? $dayTime : null;
            
            // Connection Speed
            $connectionSpeed = [];
            if ($request->has('connection_speed_target_by')) {
                $connectionSpeed['target_by'] = $request->connection_speed_target_by;
            }
            if ($request->has('connection_speed_netspeeds')) {
                $connectionSpeed['netspeeds'] = is_array($request->connection_speed_netspeeds) ? $request->connection_speed_netspeeds : [];
            }
            $insertionOrder->connection_speed = !empty($connectionSpeed) ? $connectionSpeed : null;
            
            // Browser
            if ($request->has('browser')) {
                $browser = is_array($request->browser) ? array_filter($request->browser) : [];
                $insertionOrder->browser = !empty($browser) ? $browser : null;
            } else {
                $insertionOrder->browser = null;
            }
            
            // Carrier Targeting
            if ($request->has('carrier_targeting')) {
                $carrierTargeting = is_array($request->carrier_targeting) ? array_filter($request->carrier_targeting) : [];
                $insertionOrder->carrier_targeting = !empty($carrierTargeting) ? $carrierTargeting : null;
            } else {
                $insertionOrder->carrier_targeting = null;
            }
            
            // First Party Audience
            if ($request->has('first_party_audience')) {
                $firstPartyAudience = is_array($request->first_party_audience) ? array_filter($request->first_party_audience) : [];
                $insertionOrder->first_party_audience = !empty($firstPartyAudience) ? $firstPartyAudience : null;
            } else {
                $insertionOrder->first_party_audience = null;
            }
            
            // Third Party Audience
            if ($request->has('third_party_audience')) {
                $thirdPartyAudience = is_array($request->third_party_audience) ? array_filter($request->third_party_audience) : [];
                $insertionOrder->third_party_audience = !empty($thirdPartyAudience) ? $thirdPartyAudience : null;
            } else {
                $insertionOrder->third_party_audience = null;
            }
            
            // Media Planner
            if ($request->has('media_planner')) {
                $mediaPlanner = is_array($request->media_planner) ? array_filter($request->media_planner) : [];
                $insertionOrder->media_planner = !empty($mediaPlanner) ? $mediaPlanner : null;
            } else {
                $insertionOrder->media_planner = null;
            }
            
            // Note
            $insertionOrder->note = $request->note;
            
            $insertionOrder->save();

            $this->response['status'] = 1;
            $this->response['msg'] = 'Insertion Order updated successfully';
            $this->response['redirect_url'] = url('admin/advertisers/' . $advertiserId . '/campaigns/' . $campaignId . '/insertion-orders');
        } else {
            $this->response['error_array'] = formatErrors($validation->errors()->toArray());
        }

        echo json_encode($this->response);
    }

    function destroy($advertiserId, $campaignId, $insertionOrderId)
    {
        $insertionOrder = InsertionOrder::where('campaign_id', $campaignId)->find($insertionOrderId);
        if ($insertionOrder) {
            $insertionOrder->delete();
            $this->response['status'] = 1;
            $this->response['msg'] = 'Insertion Order deleted successfully';
        } else {
            $this->response['error'] = 'Insertion Order not found';
        }

        echo json_encode($this->response);
    }
}


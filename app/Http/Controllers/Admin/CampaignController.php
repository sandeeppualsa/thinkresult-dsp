<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use App\Models\Campaign;
use App\Models\CampaignGoal;
use App\Models\CreativeType;
use App\Models\InventorySource;
use App\Models\KPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    function index(Request $request, $advertiserId)
    {
        $advertiser = Advertiser::find($advertiserId);
        if (!$advertiser) {
            return redirect('admin/advertisers')->with('error', 'Advertiser not found');
        }

        $per_page = $request->get('per_page', 10);
        $page = $request->get('page', 1);
        $per_page = max(1, min(100, (int)$per_page));
        $page = max(1, (int)$page);

        $num_rows = Campaign::where('advertiser_id', $advertiserId)->count();
        $campaigns = Campaign::where('advertiser_id', $advertiserId)
            ->with(['campaignGoal', 'kpi', 'creativeType'])
            ->orderBy('id', 'desc')
            ->skip(($page - 1) * $per_page)
            ->take($per_page)
            ->get();

        $url = url('admin/advertisers/' . $advertiserId . '/campaigns') . '?';

        $data = [];
        $data['title'] = 'Campaigns - ' . $advertiser->firstname . ' ' . $advertiser->lastname;
        $data['active_tab'] = 'advertisers';
        $data['campaigns'] = $campaigns;
        $data['advertiser'] = $advertiser;
        $data['per_page'] = $per_page;
        $data['page'] = $page;
        $data['num_rows'] = $num_rows;
        $data['url'] = $url;

        return view('admin.campaigns.index', $data);
    }

    function create($advertiserId)
    {
        $advertiser = Advertiser::find($advertiserId);
        if (!$advertiser) {
            return redirect('admin/advertisers')->with('error', 'Advertiser not found');
        }

        $data = [];
        $data['title'] = 'Add Campaign';
        $data['active_tab'] = 'advertisers';
        $data['advertiser'] = $advertiser;
        $data['campaign_goals'] = CampaignGoal::orderBy('name')->get();
        $data['kpis'] = KPI::orderBy('name')->get();
        $data['creative_types'] = CreativeType::orderBy('name')->get();
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

        return view('admin.campaigns.create', $data);
    }

    function store(Request $request, $advertiserId)
    {
        $advertiser = Advertiser::find($advertiserId);
        if (!$advertiser) {
            $this->response['error'] = 'Advertiser not found';
            echo json_encode($this->response);
            return;
        }

        $validationRules = [
            'campaign_name' => 'required',
            'status' => 'required|in:draft,active,paused',
            'overall_campaign_goal_id' => 'nullable|exists:campaign_goals,id',
            'kpi_id' => 'nullable|exists:kpis,id',
            'creative_type_id' => 'nullable|exists:creative_types,id',
            'planned_spend' => 'nullable|numeric|min:0',
            'planned_start_date' => 'nullable|date',
            'planned_end_date' => 'nullable|date|after_or_equal:planned_start_date',
            'frequency_cap_type' => 'required|in:no_limit,limit',
            'frequency_cap_value' => 'nullable|integer|min:1|required_if:frequency_cap_type,limit',
        ];

        $validation = Validator::make($request->all(), $validationRules);

        if (!$validation->fails()) {
            $campaign = new Campaign();
            $campaign->advertiser_id = $advertiserId;
            $campaign->campaign_name = $request->campaign_name;
            $campaign->status = $request->status;
            $campaign->overall_campaign_goal_id = $request->overall_campaign_goal_id;
            $campaign->kpi_id = $request->kpi_id;
            $campaign->creative_type_id = $request->creative_type_id;
            $campaign->planned_spend = $request->planned_spend;
            $campaign->planned_start_date = $request->planned_start_date;
            $campaign->planned_end_date = $request->planned_end_date;
            $campaign->frequency_cap_type = $request->frequency_cap_type;
            $campaign->frequency_cap_value = $request->frequency_cap_type == 'limit' ? $request->frequency_cap_value : null;

            // Handle inventory sources
            if ($request->has('inventory_sources')) {
                $inventorySources = is_array($request->inventory_sources) ? $request->inventory_sources : [];
                $campaign->inventory_sources = $inventorySources;
            }

            // Handle demographics
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
            $campaign->demographics = !empty($demographics) ? $demographics : null;

            // Handle geography
            if ($request->has('geography')) {
                $geography = is_array($request->geography) ? array_filter($request->geography) : [];
                $campaign->geography = !empty($geography) ? $geography : null;
            }

            // Handle languages
            if ($request->has('languages')) {
                $languages = is_array($request->languages) ? array_filter($request->languages) : [];
                $campaign->languages = !empty($languages) ? $languages : null;
            }

            // Handle brand safety
            if ($request->has('brand_safety')) {
                $brandSafety = is_array($request->brand_safety) ? $request->brand_safety : [];
                $campaign->brand_safety = !empty($brandSafety) ? $brandSafety : null;
            }

            $campaign->save();

            $this->response['status'] = 1;
            $this->response['msg'] = 'Campaign created successfully';
            $this->response['redirect_url'] = url('admin/advertisers/' . $advertiserId . '/campaigns');
        } else {
            $this->response['error_array'] = formatErrors($validation->errors()->toArray());
        }

        echo json_encode($this->response);
    }

    function edit($advertiserId, $campaignId)
    {
        $advertiser = Advertiser::find($advertiserId);
        if (!$advertiser) {
            return redirect('admin/advertisers')->with('error', 'Advertiser not found');
        }

        $campaign = Campaign::where('advertiser_id', $advertiserId)->find($campaignId);
        if (!$campaign) {
            return redirect('admin/advertisers/' . $advertiserId . '/campaigns')->with('error', 'Campaign not found');
        }

        $data = [];
        $data['title'] = 'Edit Campaign';
        $data['active_tab'] = 'advertisers';
        $data['advertiser'] = $advertiser;
        $data['campaign'] = $campaign;
        $data['campaign_goals'] = CampaignGoal::orderBy('name')->get();
        $data['kpis'] = KPI::orderBy('name')->get();
        $data['creative_types'] = CreativeType::orderBy('name')->get();
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

        return view('admin.campaigns.edit', $data);
    }

    function update(Request $request, $advertiserId, $campaignId)
    {
        $advertiser = Advertiser::find($advertiserId);
        if (!$advertiser) {
            $this->response['error'] = 'Advertiser not found';
            echo json_encode($this->response);
            return;
        }

        $campaign = Campaign::where('advertiser_id', $advertiserId)->find($campaignId);
        if (!$campaign) {
            $this->response['error'] = 'Campaign not found';
            echo json_encode($this->response);
            return;
        }

        $validationRules = [
            'campaign_name' => 'required',
            'status' => 'required|in:draft,active,paused',
            'overall_campaign_goal_id' => 'nullable|exists:campaign_goals,id',
            'kpi_id' => 'nullable|exists:kpis,id',
            'creative_type_id' => 'nullable|exists:creative_types,id',
            'planned_spend' => 'nullable|numeric|min:0',
            'planned_start_date' => 'nullable|date',
            'planned_end_date' => 'nullable|date|after_or_equal:planned_start_date',
            'frequency_cap_type' => 'required|in:no_limit,limit',
            'frequency_cap_value' => 'nullable|integer|min:1|required_if:frequency_cap_type,limit',
        ];

        $validation = Validator::make($request->all(), $validationRules);

        if (!$validation->fails()) {
            $campaign->campaign_name = $request->campaign_name;
            $campaign->status = $request->status;
            $campaign->overall_campaign_goal_id = $request->overall_campaign_goal_id;
            $campaign->kpi_id = $request->kpi_id;
            $campaign->creative_type_id = $request->creative_type_id;
            $campaign->planned_spend = $request->planned_spend;
            $campaign->planned_start_date = $request->planned_start_date;
            $campaign->planned_end_date = $request->planned_end_date;
            $campaign->frequency_cap_type = $request->frequency_cap_type;
            $campaign->frequency_cap_value = $request->frequency_cap_type == 'limit' ? $request->frequency_cap_value : null;

            // Handle inventory sources
            if ($request->has('inventory_sources')) {
                $inventorySources = is_array($request->inventory_sources) ? $request->inventory_sources : [];
                $campaign->inventory_sources = $inventorySources;
            } else {
                $campaign->inventory_sources = null;
            }

            // Handle demographics
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
            $campaign->demographics = !empty($demographics) ? $demographics : null;

            // Handle geography
            if ($request->has('geography')) {
                $geography = is_array($request->geography) ? array_filter($request->geography) : [];
                $campaign->geography = !empty($geography) ? $geography : null;
            } else {
                $campaign->geography = null;
            }

            // Handle languages
            if ($request->has('languages')) {
                $languages = is_array($request->languages) ? array_filter($request->languages) : [];
                $campaign->languages = !empty($languages) ? $languages : null;
            } else {
                $campaign->languages = null;
            }

            // Handle brand safety
            if ($request->has('brand_safety')) {
                $brandSafety = is_array($request->brand_safety) ? $request->brand_safety : [];
                $campaign->brand_safety = !empty($brandSafety) ? $brandSafety : null;
            } else {
                $campaign->brand_safety = null;
            }

            $campaign->save();

            $this->response['status'] = 1;
            $this->response['msg'] = 'Campaign updated successfully';
            $this->response['redirect_url'] = url('admin/advertisers/' . $advertiserId . '/campaigns');
        } else {
            $this->response['error_array'] = formatErrors($validation->errors()->toArray());
        }

        echo json_encode($this->response);
    }

    function destroy($advertiserId, $campaignId)
    {
        $campaign = Campaign::where('advertiser_id', $advertiserId)->find($campaignId);
        if ($campaign) {
            $campaign->delete();
            $this->response['status'] = 1;
            $this->response['msg'] = 'Campaign deleted successfully';
        } else {
            $this->response['error'] = 'Campaign not found';
        }

        echo json_encode($this->response);
    }
}


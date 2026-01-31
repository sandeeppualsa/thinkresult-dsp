<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    function index(Request $request)
    {
        $advertiser = session('advertiser');
        
        if (!$advertiser) {
            return redirect('advertiser/login');
        }

        $per_page = $request->get('per_page', 10);
        $page = $request->get('page', 1);
        $per_page = max(1, min(100, (int)$per_page));
        $page = max(1, (int)$page);

        $num_rows = Campaign::where('advertiser_id', $advertiser->id)->count();
        $campaigns = Campaign::where('advertiser_id', $advertiser->id)
            ->with(['campaignGoal', 'kpi', 'creativeType'])
            ->orderBy('id', 'desc')
            ->skip(($page - 1) * $per_page)
            ->take($per_page)
            ->get();

        $url = url('advertiser/dashboard') . '?';

        $data = [];
        $data['title'] = 'My Campaigns';
        $data['campaigns'] = $campaigns;
        $data['advertiser'] = $advertiser;
        $data['per_page'] = $per_page;
        $data['page'] = $page;
        $data['num_rows'] = $num_rows;
        $data['url'] = $url;

        return view('advertiser.campaigns.index', $data);
    }
}


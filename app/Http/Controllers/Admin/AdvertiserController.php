<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdvertiserController extends Controller
{
    function index(Request $request)
    {
        $per_page = $request->get('per_page', 10);
        $page = $request->get('page', 1);
        $per_page = max(1, min(100, (int)$per_page)); // Limit between 1 and 100
        $page = max(1, (int)$page); // Minimum page is 1

        $num_rows = Advertiser::count();
        $advertisers = Advertiser::orderBy('id', 'desc')
            ->skip(($page - 1) * $per_page)
            ->take($per_page)
            ->get();

        $url = url('admin/advertisers') . '?';

        $data = [];
        $data['title'] = 'Advertisers';
        $data['active_tab'] = 'advertisers';
        $data['advertisers'] = $advertisers;
        $data['per_page'] = $per_page;
        $data['page'] = $page;
        $data['num_rows'] = $num_rows;
        $data['url'] = $url;
        
        return view('admin.advertisers.index', $data);
    }

    function create()
    {
        $data = [];
        $data['title'] = 'Add Advertiser';
        $data['active_tab'] = 'advertisers';
        return view('admin.advertisers.create', $data);
    }

    function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:advertisers,email',
            'password' => 'required|min:6',
            'mobile' => 'nullable',
            'initial_budget' => 'nullable|numeric|min:0',
        ]);

        if (!$validation->fails()) {
            $advertiser = new Advertiser();
            $advertiser->firstname = $request->firstname;
            $advertiser->lastname = $request->lastname;
            $advertiser->email = $request->email;
            $advertiser->password = Hash::make($request->password);
            $advertiser->mobile = $request->mobile;
            $advertiser->initial_budget = $request->initial_budget;
            $advertiser->save();

            $this->response['status'] = 1;
            $this->response['msg'] = 'Advertiser created successfully';
            $this->response['redirect_url'] = url('admin/advertisers');
        } else {
            $this->response['error_array'] = formatErrors($validation->errors()->toArray());
        }

        echo json_encode($this->response);
    }

    function edit($id)
    {
        $advertiser = Advertiser::find($id);
        if (!$advertiser) {
            return redirect('admin/advertisers')->with('error', 'Advertiser not found');
        }

        $data = [];
        $data['title'] = 'Edit Advertiser';
        $data['active_tab'] = 'advertisers';
        $data['advertiser'] = $advertiser;
        return view('admin.advertisers.edit', $data);
    }

    function update(Request $request, $id)
    {
        $advertiser = Advertiser::find($id);
        if (!$advertiser) {
            $this->response['error'] = 'Advertiser not found';
            echo json_encode($this->response);
            return;
        }

        $validationRules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:advertisers,email,' . $id,
            'mobile' => 'nullable',
            'initial_budget' => 'nullable|numeric|min:0',
        ];

        // Password is optional on update
        if ($request->password) {
            $validationRules['password'] = 'min:6';
        }

        $validation = Validator::make($request->all(), $validationRules);

        if (!$validation->fails()) {
            $advertiser->firstname = $request->firstname;
            $advertiser->lastname = $request->lastname;
            $advertiser->email = $request->email;
            $advertiser->mobile = $request->mobile;
            $advertiser->initial_budget = $request->initial_budget;
            $advertiser->status = $request->status;
            if ($request->password) {
                $advertiser->password = Hash::make($request->password);
            }

            $advertiser->save();

            $this->response['status'] = 1;
            $this->response['msg'] = 'Advertiser updated successfully';
            $this->response['redirect_url'] = url('admin/advertisers');
        } else {
            $this->response['error_array'] = formatErrors($validation->errors()->toArray());
        }

        echo json_encode($this->response);
    }

    function destroy($id)
    {
        $advertiser = Advertiser::find($id);
        if ($advertiser) {
            $advertiser->delete();
            $this->response['status'] = 1;
            $this->response['msg'] = 'Advertiser deleted successfully';
        } else {
            $this->response['error'] = 'Advertiser not found';
        }

        echo json_encode($this->response);
    }
}

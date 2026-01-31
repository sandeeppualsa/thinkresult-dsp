<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function index(Request $request)
    {
        $per_page = $request->get('per_page', 10);
        $page = $request->get('page', 1);
        $per_page = max(1, min(100, (int)$per_page)); // Limit between 1 and 100
        $page = max(1, (int)$page); // Minimum page is 1

        $num_rows = User::count();
        $users = User::orderBy('id', 'desc')
            ->skip(($page - 1) * $per_page)
            ->take($per_page)
            ->get();

        $url = url('admin/users') . '?';

        $data = [];
        $data['title'] = 'Users';
        $data['active_tab'] = 'users';
        $data['users'] = $users;
        $data['per_page'] = $per_page;
        $data['page'] = $page;
        $data['num_rows'] = $num_rows;
        $data['url'] = $url;
        
        return view('admin.users.index', $data);
    }

    function create()
    {
        $data = [];
        $data['title'] = 'Add User';
        $data['active_tab'] = 'users';
        return view('admin.users.create', $data);
    }

    function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable',
            'password' => 'required|min:6',
            'user_level' => 'required|in:1,2',
        ]);

        if (!$validation->fails()) {
            // Only super admin can set user_level to 1
            $admin = session('admin');
            if ($request->user_level == 1 && $admin['user_level'] != 1) {
                $this->response['error'] = 'Only super admin can create super admin users.';
            } else {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->password = Hash::make($request->password);
                $user->p = $request->password; // Store plain password as per existing pattern
                $user->user_level = $request->user_level;
                $user->save();

                $this->response['status'] = 1;
                $this->response['msg'] = 'User created successfully';
                $this->response['redirect_url'] = url('admin/users');
            }
        } else {
            $this->response['error_array'] = formatErrors($validation->errors()->toArray());
        }

        echo json_encode($this->response);
    }

    function edit($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect('admin/users')->with('error', 'User not found');
        }

        $data = [];
        $data['title'] = 'Edit User';
        $data['active_tab'] = 'users';
        $data['user'] = $user;
        return view('admin.users.edit', $data);
    }

    function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            $this->response['error'] = 'User not found';
            echo json_encode($this->response);
            return;
        }

        $validationRules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable',
        ];

        // Password is optional on update
        if ($request->password) {
            $validationRules['password'] = 'min:6';
        }

        // Only super admin can change user_level
        $admin = session('admin');
        if ($admin['user_level'] == 1) {
            $validationRules['user_level'] = 'required|in:1,2';
        }

        $validation = Validator::make($request->all(), $validationRules);

        if (!$validation->fails()) {
            // Prevent users from deleting themselves
            if ($id == $admin['id']) {
                $this->response['error'] = 'You cannot modify your own account from here.';
            } else {
                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = $request->phone;

                if ($request->password) {
                    $user->password = Hash::make($request->password);
                    $user->p = $request->password;
                }

                // Only super admin can change user_level
                if ($admin['user_level'] == 1) {
                    $user->user_level = $request->user_level;
                }

                $user->save();

                $this->response['status'] = 1;
                $this->response['msg'] = 'User updated successfully';
                $this->response['redirect_url'] = url('admin/users');
            }
        } else {
            $this->response['error_array'] = formatErrors($validation->errors()->toArray());
        }

        echo json_encode($this->response);
    }

    function destroy($id)
    {
        $admin = session('admin');
        
        // Prevent users from deleting themselves
        if ($id == $admin['id']) {
            $this->response['error'] = 'You cannot delete your own account.';
        } else {
            $user = User::find($id);
            if ($user) {
                $user->delete();
                $this->response['status'] = 1;
                $this->response['msg'] = 'User deleted successfully';
            } else {
                $this->response['error'] = 'User not found';
            }
        }

        echo json_encode($this->response);
    }

    function getUsers(Request $request)
    {
        $users = User::select('id', 'name', 'email', 'phone', 'user_level', 'created_at')
            ->orderBy('id', 'desc')
            ->get();

        $data = [];
        foreach ($users as $user) {
            $userLevel = $user->user_level == 1 ? 'Super Admin' : 'Admin';
            $data[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '-',
                'user_level' => $userLevel,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'actions' => '<a href="' . url('admin/users/' . $user->id . '/edit') . '" class="btn btn-sm btn-icon item-edit"><i class="icon-base ti tabler-edit"></i></a> ' .
                    '<button type="button" class="btn btn-sm btn-icon item-delete text-danger" data-id="' . $user->id . '"><i class="icon-base ti tabler-trash"></i></button>'
            ];
        }

        return response()->json(['data' => $data]);
    }
}


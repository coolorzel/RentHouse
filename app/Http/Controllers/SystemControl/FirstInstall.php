<?php

namespace App\Http\Controllers\SystemControl;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class FirstInstall extends Controller
{
    protected array $roles = ['Owner',
        'admin',
        'user'];
    protected array $permissions = ['ACP-system-control',
        'ACP-view',
        'ACP-user-list-view',
        'ACP-user-edit',
        'ACP-user-update',
        'ACP-user-edit-avatar',
        'ACP-user-edit-password',
        'ACP-user-delete',
        'ACP-user-view',
        'ACP-role-list-view',
        'ACP-role-edit',
        'ACP-role-create',
        'ACP-role-update',
        'ACP-role-delete',
        'ACP-permission-list-view',
        'ACP-permission-edit',
        'ACP-permission-create',
        'ACP-permission-delete',
        'ACP-permission-update'];


    public function index ()
    {
        if(Role::exists() == null) {
            return view('admin.install.firstSys.index');
        }
        return redirect()->route('login')->with('warning', __('System was installed.'));
    }

    public function store (Request $request)
    {
        if(Role::exists() == null) {

            foreach ($this->roles as $role){
                Role::create(['name' => $role]);
            }

            foreach ($this->permissions as $permission) {
                Permission::create(['name' => $permission]);
            }
            return redirect()->route('register')->with('success', __('System properly installed. Now register.'));
        }
        return redirect()->route('login')->with('warning', __('System was installed.'));
    }
}

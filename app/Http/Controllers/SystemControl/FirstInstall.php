<?php

namespace App\Http\Controllers\SystemControl;

use App\Http\Controllers\Controller;
use App\Http\Requests\FirstInstallValidationRequest;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Descriptions\SettingsDescription;

class FirstInstall extends Controller
{
    public function index ()
    {
        if ((User::exists() == null) || (Role::exists() == null)) {
            $forms = SettingsDescription::$DESCRIPTION['additional'];
            $step = 0;
            $quantityDefaultInputs = 3;

            return view('admin.install.firstSys.index', compact('forms', 'step', 'quantityDefaultInputs'));
        }
        return redirect()->route('login')->with('warning', __('System was installed.'));
    }

    public function store (FirstInstallValidationRequest $request)
    {
        $request->validated();
        $step = $request->input('_step');
        $forms = SettingsDescription::$DESCRIPTION['additional'];
        $quantitySteps = count($forms);
        $quantityDefaultInputs = 3;
        $roles = SettingsDescription::$ROLES;
        $permissions = SettingsDescription::$PERMISSIONS;

        if ((User::exists() == null) || (Role::exists() == null)){
            //dd($forms[$step-1]['action']);
            if ((is_numeric($step)) && ($step < $quantitySteps) && ($forms[$step-1]['action'] == 'settings'))
            {
                $quantityRequest = count($forms[$step-1])-$quantityDefaultInputs;
                for ($i = 0; $i < $quantityRequest; $i++)
                {
                    Settings::updateOrCreate(
                        [
                            'name' => $request->name_settings[$i],
                        ],
                        [
                            'value' => $request->response[$i],
                        ]
                    );
                }
                return view('admin.install.firstSys.index', compact('forms', 'step', 'quantityDefaultInputs'));
            }
            elseif ((is_numeric($step)) && ($step < $quantitySteps) && ($forms[$step-1]['action'] == 'user'))
            {
                foreach ($permissions as $permission) {
                    Permission::updateOrCreate(['name' => $permission]);
                }
                $permissionslist = Config::get('roleandpermission.permission');
                foreach ($roles as $role_name){
                    $role = Role::updateOrCreate(['name' => $role_name]);

                    if ($role_name == 'Owner')
                    {
                        $permissionslist2 = $permissionslist;
                    }
                    if ($role_name == 'admin')
                    {
                        $permissionslist2 = preg_grep('/(^user|^acp)/i', $permissionslist);
                    }
                    if ($role_name == 'user')
                    {
                        $permissionslist2 = preg_grep('/(^user)/i', $permissionslist);
                    }
                    $role->syncPermissions($permissionslist2);
                }

                User::create([
                    'name' => $request->response[0],
                    'lname' => $request->response[1],
                    'email' => $request->response[2],
                    'password' => Hash::make($request->response[3]),
                    'email_verified_at' => date("Y-m-d h:i:sa"),
                ]);
            }
            elseif ($step == "end")
            {
                foreach ($permissions as $permission) {
                    Permission::updateOrCreate(['name' => $permission]);
                }
                $permissionslist = Config::get('roleandpermission.permission');
                foreach ($roles as $role_name){
                    $role = Role::updateOrCreate(['name' => $role_name]);

                    if ($role_name == 'Owner')
                    {
                        $permissionslist2 = $permissionslist;
                    }
                    if ($role_name == 'admin')
                    {
                        $permissionslist2 = preg_grep('/(^user|^acp)/i', $permissionslist);
                    }
                    if ($role_name == 'moderator')
                    {
                        $permissionslist2 = preg_grep('/(^mod|^user)/i', $permissionslist);
                    }
                    if ($role_name == 'user')
                    {
                        $permissionslist2 = preg_grep('/(^user)/i', $permissionslist);
                    }
                    $role->syncPermissions($permissionslist2);
                }
                $user = User::create([
                    'name' => $request->response[0],
                    'lname' => $request->response[1],
                    'email' => $request->response[2],
                    'password' => Hash::make($request->response[3]),
                ]);
                $user->email_verified_at = date("Y-m-d h:i:sa");
                $user->save();

                return redirect()->route('login')->with('success', 'System success installed!');
            }
            else
            {
                return redirect()->route('firstInstallIndex')->with('toast_error', 'Installation error. Restart!');
            }
        }
        return redirect()->route('login')->with('warning', __('System was installed.'));
    }
}

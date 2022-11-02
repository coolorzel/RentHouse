<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use function view;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $roles = Role::orderBy('id', 'ASC')->get();
        $permissions = Permission::get();
        $otherPermission = [];
        foreach ($permissions as $val) {
            $permissionsList[] = $val['name'];
        }
        $adminPermission = preg_grep('/(^acp)/i', $permissionsList);
        $userPermission = preg_grep('/(^user)/i', $permissionsList);
        foreach ($permissions as $val)
        {
            if (!in_array($val['name'], $adminPermission))
                if (!in_array($val['name'], $userPermission))
                    $otherPermission[] = $val['name'];
        }
        return view('site.admin.rolesview',compact('roles', 'permissions', 'adminPermission', 'userPermission', 'otherPermission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        if ($role = Role::create(['name' => $request->get('name')]))
            if ($role->syncPermissions($request->get('permission')))
                return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Create completed', 'type' => 'success']);
            else
                return response()->json(['status'=>1,'title'=>'Error','msg'=>'ERROR Create','type'=>'error']);
        else
            return response()->json(['status'=>1,'title'=>'Error','msg'=>'ERROR Create','type'=>'error']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role)
    {
        return response()->json([
            'Name' => $role->name,
            'Delete' => route('adminRoleDelete', $role->id),
            'Edit' => route('adminRoleEdit', $role->id),
            'Active' => $role->permissions->pluck('name')->toArray()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Role $role)
    {
            $this->validate($request, [
                'name' => 'required',
                'permission' => 'required',
            ]);
        if ($role->id == '1')
            return response()->json(['status'=>1,'title'=>'Error','msg'=>'ERROR Edit global role!','type'=>'error']);
        else
            if ($role->update($request->only('name')))
                if ($role->syncPermissions($request->get('permission')))
                    return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Update completed', 'type' => 'success']);
                else
                    return response()->json(['status'=>1,'title'=>'Error','msg'=>'ERROR Update','type'=>'error']);
            else
                return response()->json(['status'=>1,'title'=>'Error','msg'=>'ERROR Update','type'=>'error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        if ($role->id == '1')
            return response()->json(['status'=>1,'title'=>'Error','msg'=>'ERROR Delete global role!','type'=>'error']);
        else
            if ($role->delete())
                return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Deleted completed', 'type' => 'success']);
            else
                return response()->json(['status'=>1,'title'=>'Error','msg'=>'ERROR Delete','type'=>'error']);
    }
}

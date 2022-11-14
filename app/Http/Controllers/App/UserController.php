<?php

namespace App\Http\Controllers\App;

use App\Descriptions\UserLinksDescriptions;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileValidationRequest;
use App\Models\BillingAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        $links = UserLinksDescriptions::$LINKS['links'];
        $issetLink = [];
        $userRole = $user->roles->pluck('name')->toArray();
        $roles = Role::latest()->get();
        $billings = BillingAccount::where('u_id', $user->id)->get();
        foreach ($links as $key => $l)
        {
            if (empty($user[$key]))
                $issetLink[] = $key;
        }
        return view('site.user.viewuserprofile', compact('user', 'issetLink', 'links', 'userRole', 'roles', 'billings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserProfileValidationRequest $request, User $user)
    {
        if (isset($_POST['name']) || isset($_POST['lname'])) {
            if (!Auth::user()->can('ACP-user-edit-name-lname')) {
                return response()->json(['status' => 0, 'title' => 'Error', 'msg' => 'ERROR Update', 'type' => 'error']);
            }
        }
        if (isset($_POST['email'])) {
            if (!Auth::user()->can('ACP-user-edit-email')) {
                return response()->json(['status' => 0, 'title' => 'Error', 'msg' => 'ERROR Update', 'type' => 'error']);
            }
        }
        if (isset($_POST['username'])) {
            if (!Auth::user()->can('ACP-user-edit-username')) {
                return response()->json(['status' => 0, 'title' => 'Error', 'msg' => 'ERROR Update', 'type' => 'error']);
            }
        }
        if (isset($_POST['phone_number'])) {
            if (!Auth::user()->can('ACP-user-edit-phone')) {
                return response()->json(['status' => 0, 'title' => 'Error', 'msg' => 'ERROR Update', 'type' => 'error']);
            }
        }
        if (isset($_POST['zipcode']) || isset($_POST['city']) || isset($_POST['street']) || isset($_POST['number'])) {
            if (!Auth::user()->can('ACP-user-edit-address')) {
                return response()->json(['status' => 0, 'title' => 'Error', 'msg' => 'ERROR Update', 'type' => 'error']);
            }
        }

        if (!$user->update($request->all()))
        {
            return response()->json(['status'=>0,'title'=>'Error','msg'=>'ERROR Update','type'=>'error']);
        }else{
            return response()->json(['status'=>1,'title'=>'Success','msg'=>'Update completed','type'=>'success']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}

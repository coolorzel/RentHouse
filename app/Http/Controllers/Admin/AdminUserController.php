<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function profile ()
    {
        $users = User::all();
        return view('site.admin.adminuserview', compact('users'));
    }

    public function userInfo(Request $request)
    {
        //return $request->data;
        $userId = $request->data;
        $user = User::where('id', $userId)->first();
        $userProfilLink = route('viewUserProfile', $userId);
        $role = strtoupper($user->roles->pluck('name')->first());
        if(isset($user))
        {
            return response()->json([
                'Status' => 1,
                'Name' => $user->name,
                'Lname' => $user->lname,
                'Link' => $userProfilLink,
                'Role' => $role,
                'Avatar' => asset('assets/uploads/users/'.$user->id.'/avatar/'.$user->avatar)
            ]);
        }
        else
        {
            return 'ISTNIEJE JUŻ';
        }
    }

    public function activateAccount(User $user)
    {
        if(Auth::user()->can('ACP-user-activate-account')){
            $user->email_verified_at = date("Y-m-d h:i:sa");
            $user->save();
            toast(__('The user\'s email has been activated.'),'success');
            return back();
        }
        toast(__('You don\'t permissions.'),'error');
        return back();
    }

    public function changeRoleUser(User $user, Request $request)
    {
        $user->syncRoles($request->get('role'));
        return response()->json(['status'=>1,'title'=>'Success','msg'=>__('User role updated completed'),'type'=>'success']);

    }
}

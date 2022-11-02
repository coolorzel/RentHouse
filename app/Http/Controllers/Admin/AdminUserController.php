<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
}

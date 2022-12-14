<?php

namespace App\Http\Controllers\User;

use App\Descriptions\UserLinksDescriptions;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileValidationRequest;
use App\Http\Requests\UserUpdatePassword;
use App\Models\BillingAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class MyUserProfile extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        //
        $links = UserLinksDescriptions::$LINKS['links'];
        $user = User::find(Auth::id());
        $billings = BillingAccount::where('u_id', $user->id)->get();
        $issetLink = [];

        foreach ($links as $key => $l)
        {
            if (empty($user[$key]))
            $issetLink[] = $key;
        }
        return view('site.user.myprofile', compact('user', 'issetLink', 'links', 'billings'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        //dd(request()->route()->named('viewUserProfile')) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit()
    {
        //

        return view('site.user.editprofile');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserProfileValidationRequest $request)
    {
        $request->validated();
        //dd($request);
        //User::find(Auth::user()->id)->update($request->validated());
        $user = User::find(Auth::id())->update([
            'name' => $request->name,
            'lname' => $request->lname,
            'username' => $request->username,
            'city' => $request->city,
            'province' => $request->province,
            'zipcode' => $request->zipcode,
            'street' => $request->street,
            'number' => $request->number,
            'country' => $request->country,
            'phone_number' => $request->phone_number
        ]);
        if (!$user)
        {
            return response()->json(['status'=>0,'title'=>'Error','msg'=>'ERROR Update','type'=>'error']);
        }else{
            //return $request;
            return response()->json(['status'=>1,'title'=>'Success','msg'=>'Update completed','type'=>'success']);
        }
    }

    public function update_password(UserUpdatePassword $request)
    {
        $request->validated();
        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;
        $repPassword = $request->repPassword;
        $user = User::find(Auth::id());
        if(Hash::check($oldPassword, $user->password))
        {
            if ($newPassword == $repPassword)
            {
                $user->update([
                    'password' => Hash::make($newPassword),
                ]);
                return response()->json(['status'=>1,'title'=>'Success','msg'=>'Change password completed','type'=>'success']);
            }
            return response()->json(['status'=>0,'title'=>'Error','msg'=>'Password repeat is not same to new password.','type'=>'error']);
        }
        else
        {
            return response()->json(['status'=>0,'error'=> ['oldPassword' => ['Old Password is valid!']]]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

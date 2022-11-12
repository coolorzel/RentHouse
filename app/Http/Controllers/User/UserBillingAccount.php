<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\BillingAccountRequest;
use App\Models\BillingAccount;
use App\Models\BillingApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBillingAccount extends Controller
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $user = User::find(Auth::id())->first();
        return view('site.user.billing-account.billing-account-create', compact('user'));
    }


    public function statusMessageBillingApplication(BillingAccount $billing)
    {

        foreach($billing->messages as $k =>$v) {
            $table[$k] = [
                'displayed' => $v->displayed
            ];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BillingAccountRequest $request)
    {
        $user = User::find(Auth::id());
        $routeMyProfile = route('myProfile');
        if ($request->company == true) {
            $billing = BillingAccount::create([
                'u_id' => $user->id,
                'company' => $request->company,
                'name' => $request->name,
                'lname' => $request->lname,
                'pesel' => $request->pesel,
                'phone_number' => $request->phone_number,
                'country' => $request->country,
                'province' => $request->province,
                'city' => $request->city,
                'zipcode' => $request->zipcode,
                'street' => $request->street,
                'building_number' => $request->building_number,
                'company_name' => $request->company_name,
                'company_nip' => $request->company_nip,
                'company_regon' => $request->company_regon,
                'company_website' => $request->company_website,
            ]);
        }else{
            $billing = BillingAccount::create([
                'u_id' => $user->id,
                'company' => $request->company,
                'name' => $request->name,
                'lname' => $request->lname,
                'pesel' => $request->pesel,
                'phone_number' => $request->phone_number,
                'country' => $request->country,
                'province' => $request->province,
                'city' => $request->city,
                'zipcode' => $request->zipcode,
                'street' => $request->street,
                'building_number' => $request->building_number,
            ]);
        }

        $message = BillingApplication::create([
            'billing_id' => $billing->id,
            'sender' => $user->id,
            'message' => $request->message
        ]);

        return response()->json(['status'=>1,'route' => $routeMyProfile,'title'=>'Success','msg'=>__('The billing account request has been delivered. Wait for a response or a change in status.'),'type'=>'success']);
    }

    public function sendMessage(Request $request)
    {
        if(isset($request->message)) {
            $message = BillingApplication::create(['billing_id' => $request->data, 'message' => $request->message, 'sender' => Auth::id()]);
            if(!$message){
                return response()->json(['status' => 0, 'msg' => __('Message error send')]);
            }else {
                $created = Date('Y-m-d');
                $user_avatar = asset('assets/uploads/users/'.Auth::id().'/avatar/'.Auth::user()->avatar);
                return response()->json(['status' => 1, 'message' => $request->message, 'create' => $created, 'user_avatar' => $user_avatar]);
            }
        }else{
            return response()->json(['status' => 0, 'msg' => __('Message can not empty.')]);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BillingAccount  $billingAccount
     * @return \Illuminate\Http\Response
     */
    public function show(UserBillingAccount $billingAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BillingAccount  $billingAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(UserBillingAccount $billingAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BillingAccount  $billingAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserBillingAccount $billingAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BillingAccount  $billingAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserBillingAccount $billingAccount)
    {
        //
    }
}

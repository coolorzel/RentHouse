<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BillingAccount;
use App\Models\BillingApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBillingAccount extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $billings = BillingAccount::get();
        return view('site.admin.adminbillingaccount', compact('billings'));
    }

    public function sendRestore(Request $request)
    {
        if(isset($request->message)) {
            $message = BillingApplication::create(['billing_id' => $request->data, 'message' => $request->message, 'sender' => '0']);
            if(!$message){
                return response()->json(['status' => 0, 'msg' => __('Message error send')]);
            }else {
                $created = Date('Y-m-d');
                $admin_avatar = asset('project/img/admin_avatar.png');
                return response()->json(['status' => 1, 'message' => $request->message, 'create' => $created, 'admin_avatar' => $admin_avatar]);
            }
        }else{
            return response()->json(['status' => 0, 'msg' => __('Message can not empty.')]);
        }
    }

    public function moreInfo(BillingAccount $billing)
    {
        $message = $billing->messages;
        $user = User::find($billing->u_id);
        if($billing->company == true){
            $company = __('Company');
        }else{
            $company = __('Private');
        }
        if($billing->verified == true){
            $btn_accept = __('Cancel accept');
        }else{
            $btn_accept = __('Accept');
        }
        if($billing->rejected == true){
            $btn_reject = __('Cancel reject');
        }else{
            $btn_reject = __('Reject');
        }
        if($billing->destroy == true){
            $btn_delete = __('Cancel delete');
        }else{
            $btn_delete = __('Delete');
        }
        if($billing->message->displayed == false && $billing->message->sender > 0){
            $message = BillingApplication::find($billing->message->id);
            $message->displayed = true;
            $message->save();
        }
        $phone_number[$billing->phone_number] = $billing->phone_number;
        return response()->json([
            'Status' => 1,
            'messages' => $billing->messages,
            'user_id' => $billing->u_id,
            'id' => $billing->id,
            'verified' => $billing->verified,
            'type_company' => $billing->company,
            'company' => $company,
            'destroy' => $billing->destroy,
            'name' => $billing->name,
            'lname' => $billing->lname,
            'pesel' => $billing->pesel,
            'phone_number' => $phone_number,
            'country' => $billing->contry,
            'province' => $billing->province,
            'city' => $billing->city,
            'street' => $billing->street,
            'building_number' => $billing->building_number,
            'company_name' => $billing->company_name,
            'company_nip' => $billing->company_nip,
            'company_regon' => $billing->company_regon,
            'company_website' => $billing->company_website,
            'created_at' => $billing->created_at,
            'user_avatar' => asset('assets/uploads/users/'.$user->id.'/avatar/'.$user->avatar),
            'admin_avatar' => asset('project/img/admin_avatar.png'),
            'user_email' => $user->email,
            'user_route' => route('viewUserProfile', $user->id),
            'btn_accept' => $btn_accept,
            'btn_reject' => $btn_reject,
            'btn_delete' => $btn_delete,
            'action_route' => route('adminStatusChangedBillingAccount', $billing->id),

            'year' => __('year'),
            'month' => __('month'),
            'day' => __('day'),
            'hour' => __('hour'),
            'minute' => __('minute'),
            'second' => __('second'),
        ]);
    }

    public function status_changed(BillingAccount $billing, Request $request)
    {
        $button = '';
        if($request->data == 'accept' && $billing->destroy == false){
            if(Auth::user()->can('MOD-billing-account-status-accept')) {
                if($billing->verified == true){
                    $billing->verified = false;
                    $button = __('Accept');
                }else{
                    $billing->verified = true;
                    $button = __('Cancel accept');
                }
            }else{
                return response()->json(['status'=>0,'title'=>'Error','msg'=>__('You do not have permission'),'type'=>'error']);
            }
        }elseif($request->data == 'reject' && $billing->destroy == false){
            if(Auth::user()->can('MOD-billing-account-status-reject')) {
                if($billing->rejected == true){
                    $billing->rejected = false;
                    $button = __('Reject');
                }else{
                    $billing->rejected = true;
                    $button = __('Cancel reject');
                }
            }else{
                return response()->json(['status'=>0,'title'=>'Error','msg'=>__('You do not have permission'),'type'=>'error']);
            }
        }elseif($request->data == 'delete'){
            if(Auth::user()->can('MOD-billing-account-status-delete')) {
                if($billing->destroy == true){
                    $billing->destroy = false;
                    $button = __('Delete');
                }else{
                    $billing->destroy = true;
                    $billing->rejected = false;
                    $billing->verified = false;
                    $button = __('Cancel delete');
                }
            }else{
                return response()->json([
                    'status'=>0,
                    'title'=>'Error',
                    'msg'=>__('You do not have permission'),
                    'type'=>'error'
                ]);
            }
        }else{
            return response()->json([
                'status'=>0,
                'title'=>'Error',
                'msg'=>__('This billing account be deleted...'),
                'type'=>'error'
            ]);
        }
        if ($billing->save())
            return response()->json([
                'status' => 1,
                'title' => 'Success',
                'msg' => 'Read status changed success',
                'type' => 'success',
                'button' => $button,
            ]);
        else
            return response()->json(['status'=>0,'title'=>'Error','msg'=>'ERROR change status displayed','type'=>'error']);
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
     * @param  \App\Models\BillingAccount  $billingAccount
     * @return \Illuminate\Http\Response
     */
    public function show(AdminBillingAccount $billingAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BillingAccount  $billingAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminBillingAccount $billingAccount)
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
    public function update(Request $request, AdminBillingAccount $billingAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BillingAccount  $billingAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminBillingAccount $billingAccount)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BillingAccount;
use Illuminate\Http\Request;

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
        return view('site.user.billing-account.billing-account-create');
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

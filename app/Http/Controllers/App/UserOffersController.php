<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ElementFormOffer;
use App\Models\Offers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Element;

class UserOffersController extends Controller
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
    public function create(Category $category)
    {
        $forms = [];
        if(!$offer = Offers::where([
            ['u_id', Auth::id()],
            ['cat_id', $category->id],
            ['isCreated', true]])->first()){
        $offer = Offers::create([
            'cat_id' => $category->id,
            'u_id' => Auth::id()]);
        }
        $billingAccounts = Auth::user()->billingAccount;
        foreach ($category->forms as $key => $val){
            $items = ElementFormOffer::find($val->id)->items;
            $active = [];
            $forms[$val->name] = ['title' => $val->title, 'items' => $items, 'active' => $active];
        }
        return view('site.app.create-new-offer', compact('category', 'forms', 'offer', 'billingAccounts'));
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
     * @param  \App\Models\Offers  $offers
     * @return \Illuminate\Http\Response
     */
    public function show(Offers $offers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offers  $offers
     * @return \Illuminate\Http\Response
     */
    public function edit(Offers $offers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offers  $offers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offers $offers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offers  $offers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offers $offers)
    {
        //
    }
}

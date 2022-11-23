<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserOfferCreateRequest;
use App\Models\Category;
use App\Models\ElementFormHasOffer;
use App\Models\ElementFormOffer;
use App\Models\OfferImages;
use App\Models\Offers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
        $elementFormHasOffer = $offer->activeElement;
        foreach($elementFormHasOffer as $key => $val){
            $active[$key] = $val->element_form_names_id;
        }
        $active['s'] = $offer->payment;
        $billingAccounts = Auth::user()->billingAccount;
        foreach ($category->forms as $key => $val){
            $items = ElementFormOffer::find($val->id)->items;
            $forms[$val->name] = ['title' => $val->title, 'items' => $items, 'active' => $active];
        }
        return view('site.app.create-new-offer', compact('category', 'forms', 'offer', 'billingAccounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserOfferCreateRequest $request, Category $category, Offers $offer)
    {
        $slug = Str::slug($request->name);

        if ($request->btn == 'save') {
            ElementFormHasOffer::where('offer_id', $offer->id)->delete();
            foreach($category->forms as $key => $val)
            {
                $item = ElementFormOffer::find($val->id);
                if($item->type == 'checkbox'){
                    self::checkBoxCheck($request->input($item->name), $offer->id);
                }
            }
            $offer->update(array_merge($request->all(), [ 'slug' => $slug, 'isCreated' => true, 'isAcceptMod' => false]));
            return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Offer save success', 'type' => 'success']);
        } else if ($request->btn == 'add') {
            ElementFormHasOffer::where('offer_id', $offer->id)->delete();
            foreach($category->forms as $key => $val)
            {
                $item = ElementFormOffer::find($val->id);
                if($item->type == 'checkbox'){
                    self::checkBoxCheck($request->input($item->name), $offer->id);
                }
            }
            $offer->update(array_merge($request->all(), [ 'slug' => $slug, 'isCreated' => false, 'isActive' => true,'isAcceptMod' => false]));
            $route = route('myProfile');
            return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Offer add to check success', 'type' => 'success', 'route' => $route]);
        } else {
            //no button pressed
            return response()->json(['status' => 1, 'title' => 'Error', 'msg' => 'ERROR CREATE OFFER', 'type' => 'error']);
        }
    }

    static function checkBoxCheck ($input, $offer_id)
    {
        if(!empty($input)){
            foreach ($input as $key => $val){
                ElementFormHasOffer::create(['offer_id' => $offer_id, 'element_form_names_id' => $val]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offers  $offers
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Category $category, Offers $offer, $slug)
    {
        if($offer->slug == $slug) {
            return view('site.app.offer.view-offer', compact('category', 'offer'));
        }else{
            return redirect()->route('index');
        }
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
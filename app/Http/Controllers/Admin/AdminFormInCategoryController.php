<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ElementFormOffer;
use Illuminate\Http\Request;

class AdminFormInCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $elements = ElementFormOffer::all();
        return view('site.admin.admin-offer-form-in-category', compact('elements'));
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
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'title' => 'required',
            'have_options' => '',
        ]);
        if (ElementFormOffer::create(['name' => $request->name, 'type' => $request->type, 'title' => $request->title, 'have_options' => $request->have_options]))
            return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Category created complete', 'type' => 'success']);
        else
            return response()->json(['status'=>0,'title'=>'Error','msg'=>'ERROR Create','type'=>'error']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ElementFormOffer  $elementFormOffer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ElementFormOffer $elementFormOffer)
    {
        return response()->json([
            'Name' => $elementFormOffer->name,
            'Type' => $elementFormOffer->type,
            'Title' => $elementFormOffer->title,
            'HaveOptions' => $elementFormOffer->have_options,
            'Delete' => route('adminOffersFormInCategoryDelete', $elementFormOffer->id),
            'Edit' => route('adminOffersFormInCategoryEdit', $elementFormOffer->id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ElementFormOffer  $elementFormOffer
     * @return \Illuminate\Http\Response
     */
    public function edit(ElementFormOffer $elementFormOffer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ElementFormOffer  $elementFormOffer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ElementFormOffer $elementFormOffer)
    {
        if ($elementFormOffer->update(['name' => $request->name, 'type' => $request->type, 'title' => $request->title, 'have_options' => $request->have_options]))
            return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Form in category updated complete', 'type' => 'success']);
        else
            return response()->json(['status'=>0,'title'=>'Error','msg'=>'ERROR update','type'=>'error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ElementFormOffer  $elementFormOffer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ElementFormOffer $elementFormOffer)
    {
        if ($elementFormOffer->delete())
            return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Form in category delete complete', 'type' => 'success']);
        else
            return response()->json(['status'=>0,'title'=>'Error','msg'=>'ERROR delete','type'=>'error']);
    }
}

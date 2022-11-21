<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ElementFormOffer;
use App\Models\FormElementNames;
use Illuminate\Http\Request;

class AdminElementFormController extends Controller
{
    public function index(ElementFormOffer $form)
    {
        $options = $form->options()->get();
        return view('site.admin.offers.template-element-form', compact('form', 'options'));
    }

    public function store (ElementFormOffer $form, Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        if (FormElementNames::create(['name' => $request->name, 'e_id' => $form->id]))
            return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Option created complete', 'type' => 'success']);
        else
            return response()->json(['status'=>0,'title'=>'Error','msg'=>'ERROR Create','type'=>'error']);
    }

    public function show (ElementFormOffer $form, FormElementNames $option)
    {
        return response()->json([
            'Name' => $option->name,
            'Delete' => route('adminElementFormDestroy', [$form->id, $option->id]),
            'Edit' => route('adminElementFormEdit', [$form->id, $option->id])
        ]);
    }

    public function update (ElementFormOffer $form, FormElementNames $option, Request $request)
    {
        if ($option->update(['name' => $request->name]))
            return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Option updated complete', 'type' => 'success']);
        else
            return response()->json(['status'=>0,'title'=>'Error','msg'=>'ERROR update','type'=>'error']);
    }

    public function destroy (ElementFormOffer $form, FormElementNames $option)
    {
        if ($option->delete())
            return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Option delete complete', 'type' => 'success']);
        else
            return response()->json(['status'=>0,'title'=>'Error','msg'=>'ERROR delete','type'=>'error']);
    }
}

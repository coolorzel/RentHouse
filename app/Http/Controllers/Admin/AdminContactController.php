<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Contact_Title;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function titleIndex()
    {
        $titles = Contact_Title::all();
        return view ('site.admin.contact-title', compact('titles'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function messageIndex()
    {
        $messages = Contact::all();
        return view ('site.admin.contact-messages', compact('messages'));
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
    public function titleStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        if (Contact_Title::create($request->all()))
            return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Created completed', 'type' => 'success']);
        else
            return response()->json(['status'=>0,'title'=>'Error','msg'=>'ERROR Create','type'=>'error']);
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
     * @param  \App\Models\Contact_Title $title
     * @return \Illuminate\Http\JsonResponse
     */
    public function titleShow(Contact_Title $title)
    {
        return response()->json([
            'Name' => $title->name,
            'Description' => $title->description,
            'Delete' => route('adminContactTitleDelete', $title->id),
            'Edit' => route('adminContactTitleEdit', $title->id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $message
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function messageShow(Contact $message)
    {
        return view('site.admin.messages.show-message', compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact_Title $title
     * @return \Illuminate\Http\JsonResponse
     */
    public function titleUpdate(Request $request, Contact_Title $title)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        if ($title->update($request->all()))
            return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Update completed', 'type' => 'success']);
        else
            return response()->json(['status'=>0,'title'=>'Error','msg'=>'ERROR Update','type'=>'error']);
    }

    public function update(Request $request, Contact $contact)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact_Title $title
     * @return \Illuminate\Http\JsonResponse
     */
    public function titleDestroy(Contact_Title $title)
    {
        if ($title->delete())
            return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Deleted completed', 'type' => 'success']);
        else
            return response()->json(['status'=>0,'title'=>'Error','msg'=>'ERROR Delete','type'=>'error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Contact_Title $title)
    {
        if ($title->delete())
            return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Deleted completed', 'type' => 'success']);
        else
            return response()->json(['status'=>0,'title'=>'Error','msg'=>'ERROR Delete','type'=>'error']);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Contact_Title;
use App\Models\User;
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

    public function operations (Contact $message, Request $request)
    {
        if($request->operation == 'read'){
            if($message->displayed == false)
                $this->statusReadUnRead($message);
                $route = route('adminContactMessageView', $message->id);
                return response()->json(['route' => $route]);
        }
        if($request->operation == 'history') {
            $history = [];
            if (isset($message->email)) {
                $email = $message->email;
            } else {
                $email = $message->user->email;
            }
            foreach($message->history as $key => $val) {
                if(isset($val->viewer_u_id)) {
                    $user = User::find($val->viewer_u_id)->first();
                    $history[$key] = [
                        'information' => $val->information,
                        'message' => $val->message,
                        'user' => $user->email,
                        'created_at' => date('Y-m-d H:i', strtotime($val->created_at))
                    ];
                }
                else{
                    $history[$key] = [
                        'information' => $val->information,
                        'message' => $val->message,
                        'created_at' => date('Y-m-d H:i', strtotime($val->created_at))
                    ];
                }

            }
            return response()->json(['email' => $email, 'history' => $history]);
        }
    }

    public function statusReadUnRead (Contact $message)
    {
        if ($message->displayed == true) {
            $message->displayed = false;
            $responseValue = __('Has not been read');
            $btn = __('Mark as read');
        }
        else
        {
            $message->displayed = true;
            $responseValue = __('Has been read');
            $btn = __('Mark as unread');
        }
        if ($message->save())
            return response()->json(['status' => 1,'typepost'=> 'readunread','btn' => $btn, 'title' => 'Success', 'msg' => 'Read status changed success', 'type' => 'success', 'description' => $responseValue]);
        else
            return response()->json(['status'=>0,'title'=>'Error','msg'=>'ERROR change status displayed','type'=>'error']);
    }

    public function statusClose (Contact $message)
    {
        if ($message->closed == true) {
            if($message->displayed == true) {
                $responseValue = __('Has been read');
            }
            else{
                $responseValue = __('Has not been read');
            }

            $message->closed = false;
            $btn = __('Close');
        }
        else
        {
            $message->closed = true;
            $responseValue = __('Has been CLOSE');
            $btn = __('Open');
        }
        if ($message->save()) {
                return response()->json(['status' => 1, 'typepost' => 'close', 'btn' => $btn, 'title' => 'Success', 'msg' => 'Read status changed success', 'type' => 'success', 'description' => $responseValue]);
        }
        else {
            return response()->json(['status' => 0, 'title' => 'Error', 'msg' => 'ERROR change status closed', 'type' => 'error']);
        }
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

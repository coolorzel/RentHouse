<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Contact_Title;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $methods = Contact_Title::all();
        return view('site.app.contact', compact('methods'));
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
        $message = Contact::where(['u_id' => Auth::id()])->orderBy('id', 'desc')->first();
        $ts = strtotime($message->created_at);
        $today = date('Y-m-d H:i:s');
        $timeMessage = date('Y-m-d H:i:s', strtotime('+20 second', $ts));
        if($timeMessage >= $today){
            $nextMessageToTime = strtotime($timeMessage) - strtotime($today);
            return response()->json(['title'=>__('Error time send'),'msg' => __('You must wait to next send message').'</br>'.__('Next message:').' '.date('s', $nextMessageToTime).'second', 'type' => 'error']);
        }
        $request->validate([
            'name' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'title' => 'required|int',
            'message' => 'required|min:60'
        ]);
        if (Auth::user()){
            $user = User::find(Auth::id())->first();
            Contact::create([
                'message' => $request->message,
                'u_id' => $user->id,
                'title_id' => $request->title
            ]);
        }
        else{
            Contact::create([
                'message' => $request->message,
                'email' => $request->email,
                'name' => $request->name,
                'lname' => $request->lname,
                'title_id' => $request->title
            ]);
        }
        return response()->json(['title'=>__('Success'),'msg' => __('Message was sent'), 'type' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
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
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //
    }
}

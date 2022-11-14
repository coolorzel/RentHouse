<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserNotifications extends Controller
{
    public function change(Request $request)
    {
        $data = '';
        $count = '';
        if ($notification = Notification::find($request->data)){
            if($notification->u_id == Auth::id()){
                if($notification->displayed == false){
                    $notification->displayed = true;
                    $notification->save();
                    $status = 1;
                    $message = 'Notification marked as read.';
                    $type = 'success';
                    $data = $notification->displayed;
                    $count = count(Notification::where(['u_id' => Auth::id(), 'displayed' => false])->get());
                }else{
                    $notification->displayed = false;
                    $notification->save();
                    $status = 1;
                    $message = 'Notification marked as unread.';
                    $type = 'success';
                    $data = $notification->displayed;
                    $count = count(Notification::where(['u_id' => Auth::id(), 'displayed' => false])->get());
                }
            }else{
                $status = 0;
                $message = 'You do not have permission.';
                $type = 'error';
            }
        }else{
            $status = 0;
            $message = 'You do not have permission.';
            $type = 'error';
        }
        return response()->json(['status' => $status, 'message' => $message, 'type' => $type, 'data' => $data, 'countNotification' => $count]);
    }
}

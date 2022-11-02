<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AvatarController extends Controller
{

    /**
     * Update avatar the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */


    public function update(Request $request, User $user)
    {
        //return $request;
        if($request->hasFile('file')) {
            if (!request()->route()->named('updateUserAvatar'))
            {
                $user = User::find(Auth::id());
            }
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();
            $fileName = time().'.'.$ext;
            $oldAvatar = $user->avatar;
            $path = 'assets/uploads/users/'.$user->id.'/avatar/';
            if (File::exists($path.$oldAvatar))
            {
                File::delete($path.$oldAvatar);
            }
            $file->move($path,$fileName);
            $user->avatar = $fileName;
            $user->update();
            if(!$user)
            {
                return response()->json(['status'=>1,'title'=>'Error','msg'=>'ERROR Update avatar','type'=>'error']);
            }else{
                //return $request;
                return response()->json(['status'=>1,'title'=>'Success','msg'=>'Update avatar completed','type'=>'success']);
            }
        }
        else
        {
            return response()->json(['error'=>'TEST']);
        }
    }

    public function delete (Request $request, User $user)
    {
        if ($request->delete == true)
        {
            if (!request()->route()->named('deleteUserAvatar'))
            {
                $user = User::find(Auth::id());
            }
            $path = 'assets/uploads/users/'.$user->id.'/avatar/';
            $oldAvatar = $user->avatar;
            if(File::exists($path.$oldAvatar))
            {
                File::delete($path.$oldAvatar);
            }
            $user->avatar = '';
            $user->update();

            if(!$user)
            {
                return response()->json(['status'=>1,'title'=>'Error','msg'=>'ERROR Delete avatar','type'=>'error']);
            }else{
                //return $request;
                return response()->json(['status'=>1,'title'=>'Success','msg'=>'Delete avatar completed','type'=>'success']);
            }
        }
        else
        {

            return response()->json(['status'=>1,'title'=>'Error','msg'=>'ERROR Delete avatar -- METHOD','type'=>'error']);
        }
    }
}

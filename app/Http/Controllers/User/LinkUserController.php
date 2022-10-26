<?php

namespace App\Http\Controllers\User;

use App\Descriptions\UserLinksDescriptions;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LinkUserController extends Controller
{
    public function edit ($nameLink)
    {
        $links = UserLinksDescriptions::$LINKS['links'];
        $user = User::find(Auth::id())->first();

        if (isset($links[$nameLink]))
        {
            if (isset($user[$nameLink]))
            {
                $symbol = $links[$nameLink]['symbol'];
                $nameModal = $links[$nameLink]['nameModal'];
                $commentInput = $links[$nameLink]['commentInput'];
                $link = route('myLinksUpdate').'/'.$nameLink;
                $delete = route('myLinksDelete').'/'.$nameLink;
                return response()->json(['Link' => $link,
                    'Delete' => $delete,
                    'Value' => $user[$nameLink],
                    'Symbol' => $symbol,
                    'Name' => $nameModal,
                    'Comment' => $commentInput,
                    'Data' => $nameLink]);
            }
            else
            {
                return response()->json(['status'=>1,'title'=>'Error','msg'=>'You don\'t have isset this links...','type'=>'error']);
            }
        }
        else
        {
            return response()->json(['status'=>1,'title'=>'Error','msg'=>'ERRROR... Please contact to administration.','type'=>'error']);
        }
    }

    public function create (Request $request)
    {
        $req = $request->data;
        $links = UserLinksDescriptions::$LINKS['links'];
        $user = User::find(Auth::id())->first();
        if (isset($links[$req]))
        {
            if(empty($user[$req]))
            {
                $symbol = $links[$req]['symbol'];
                $nameModal = $links[$req]['nameModal'];
                $commentInput = $links[$req]['commentInput'];
                return response()->json([
                    'Status' => 1,
                    'Name' => $nameModal,
                    'Symbol' => $symbol,
                    'Comment' => $commentInput
                ]);
            }
            else
            {
                return 'ISTNIEJE JUŻ';
            }
        }
        else
        {
            return 'ERROR';
        }
        /*return response()->json(['Link' => $link,
            'Delete' => $delete,
            'Value' => $user[$nameLink],
            'Symbol' => $symbol,
            'Name' => $nameModal,
            'Comment' => $commentInput,
            'Data' => $nameLink]);*/
    }

    public function store (Request $request)
    {
        $links = UserLinksDescriptions::$LINKS['links'];
        $type = $request->nameLink;
        if (isset($links[$request->nameLink]))
        {
            $user = User::find(Auth::id())->first();
            $user->$type = $request->valueLink; // $user->website = 'KUPA';
            $user->update();
            if(!$user)
            {
                return response()->json(['status'=>1,'title'=>'Error','msg'=>'ERROR Create link','type'=>'error']);
            }else{
                return response()->json(['status'=>1,'title'=>'Success','msg'=>'Create link completed','type'=>'success']);
            }
        }
        else
        {
            return response()->json(['status'=>1,'title'=>'Error','msg'=>'ERROR -> Contact to administration','type'=>'error']);
        }
    }

    public function update (Request $request, $nameLink)
    {
        $links = UserLinksDescriptions::$LINKS['links'];
        if (isset($links[$nameLink]))
        {
            $user = User::find(Auth::id())->first();
            $user->$nameLink = $request->valueLink;
            $user->update();
            if(!$user)
            {
                return response()->json(['status'=>1,'title'=>'Error','msg'=>'ERROR Update link','type'=>'error']);
            }else{
                //return $request;
                return response()->json(['status'=>1,'title'=>'Success','msg'=>'Update link completed','type'=>'success']);
            }
        }
        else
        {
            return response()->json(['status'=>1,'title'=>'Error','msg'=>'ERROR -> Contact to administration','type'=>'error']);
        }
    }

    public function delete ($nameLink)
    {
        $links = UserLinksDescriptions::$LINKS['links'];
        if (isset($links[$nameLink]))
        {
            $user = User::find(Auth::id())->first();
            $user->$nameLink = '';
            $user->update();
            if(!$user)
            {
                return response()->json(['status'=>1,'title'=>'Error','msg'=>'ERROR Delete link','type'=>'error']);
            }else{
                //return $request;
                return response()->json(['status'=>1,'title'=>'Success','msg'=>'Delete link completed','type'=>'success']);
            }
        }
        else
        {
            return response()->json(['status'=>1,'title'=>'Error','msg'=>'ERROR -> Contact to administration','type'=>'error']);
        }
    }
}

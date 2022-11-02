<?php

namespace App\Http\Controllers\Admin;

use App\Descriptions\SettingsDescription;
use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class AdminPageSettings extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $forms = SettingsDescription::$DESCRIPTION['additional'];
        $valueSettings = [];
        $settings = Settings::all();
        foreach($settings as $setting)
        {
            $valueSettings[$setting->name] = $setting->value;
        }
        //dd($valueSettings);
        return view('site.admin.adminsettings', compact('valueSettings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd(Request::path());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        foreach ($data as $key => $value)
        {
            if ($key == '_token'){}
            else
            {
                if (!Settings::where('name', $key)->update(['value' => $value])) {
                    return response()->json(['status'=>0,'title'=>'Error','msg'=>'ERROR Update','type'=>'error']);}
            }
        }
        return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Update completed', 'type' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function availableSite()
    {
        $tableName = 'page_available';
        $setting = Settings::get()->where('name', $tableName)->first();
        if ($setting->value == true)
        {
            $setting->value = false;
            $button = __('Enable');
            $status = __('Disabled');
        }
        else
        {
            $setting->value = true;
            $button = __('Disable');
            $status = __('Enabled');
        }
        $setting->update();
        return response()->json(['Value'=>$setting->value,'Button'=>$button,'Status'=>$status]);
    }
}

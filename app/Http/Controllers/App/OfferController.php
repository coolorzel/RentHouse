<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;

class OfferController extends Controller
{
    public function select()
    {
        $categories[0] = ['name' => 'Posiadłość', 'photo' => 'fa-home'];
        $categories[1] = ['name' => 'Teren rolny', 'photo' => 'fa-bed'];
        //dd($categories);
        return view ('site.app.select-type-offer', compact('categories'));
    }
    public function create($test)
    {
        return 'test';
    }
}

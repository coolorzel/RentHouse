<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Category;

class OfferControllerController extends Controller
{
    public function select()
    {
        $categories = Category::all();
        //dd($categories);
        return view ('site.app.select-type-offer', compact('categories'));
    }
    public function create($test)
    {
        return 'test';
    }
}

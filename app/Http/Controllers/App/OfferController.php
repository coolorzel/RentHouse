<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Category;

class OfferController extends Controller
{
    public function select()
    {
        $categories = Category::where('enable', true)->get();
        //dd($categories);
        return view ('site.app.select-type-offer', compact('categories'));
    }
    public function create($test)
    {
        return 'test';
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offers;
use Illuminate\Http\Request;

class AdminOfferController extends Controller
{
    public function index()
    {
        $offers = Offers::where('isCreated', false)->get();
        return view('site.admin.offers.offer-list', compact('offers'));
    }
}

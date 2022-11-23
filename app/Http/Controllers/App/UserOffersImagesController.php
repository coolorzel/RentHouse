<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OfferImages;
use App\Models\Offers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserOffersImagesController extends Controller
{
    public function store(Request $request, $category, $offer)
    {
        $image = $request->file('file');
        //dd($image);
        $imageName = mt_rand() . time() . '.' . $image->extension();

        $folder = $offer. '/' .$category;

        $image->move(public_path('images/' .$offer. '/' .$category), $imageName);

        OfferImages::create([
            'name' => $imageName,
            'alt' => $request->file('file')->getClientOriginalName(),
            'o_id' => $offer,
        ]);

        return response()->json(['success' => $imageName, 'message' => $category.' --- '. $offer]);
    }
    public function fetch($category, $offer)
    {
        $img = [];
            if(\File::exists(public_path('images/' .$offer. '/' .$category)))
            {
                $offe = Offers::where('id', $offer)->first();
                $images = \File::allFiles(public_path('images/' .$offer. '/' .$category));
                $output = '<div class="row">';
                foreach($images as $image)
                {
                    $checked = '';
                    $img_id = OfferImages::where('name', $image->getFilename())->first();
                    if($offe->images_id == $img_id->id)
                    {
                        $checked = 'checked';
                    }
                    $img_src = asset('images/' .$offer. '/' .$category. '/' . $image->getFilename());
                    $name = $image->getFilename();
                    $img[$img_id->id] = ['isChecked' => $checked, 'src' => $img_src, 'name' => $name];
                }
            }
        return response()->json(['images' => $img]);
    }

    public function destroy(Request $request, $category, $offer)
    {
        if($request->input('name'))
        {
            \File::delete(public_path('images/' .$offer. '/' .$category . '/' . $request->input('name')));
            OfferImages::where('name', $request->input('name'))->delete();
        }
    }
}

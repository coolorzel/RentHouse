<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAdminOfferCategory;
use App\Http\Service\AdminOfferCategoryService;
use App\Models\Category;
use App\Models\ElementFormInCategory;
use App\Models\ElementFormOffer;
use Illuminate\Http\Request;

class AdminOfferCategory extends Controller
{
    private AdminOfferCategoryService $service;

    public function __construct(AdminOfferCategoryService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $categories = Category::get();
        $forms = ElementFormOffer::get();
        return view('site.admin.admin-offer-categories', compact('categories', 'forms'));
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
    public function store(CreateAdminOfferCategory $request)
    {
        return $this->service->create($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        $formInCategory = $category->formInCategory();
        //return $formInCategory;
        $allForms = ElementFormOffer::get();
        return response()->json([
            'Name' => $category->name,
            'Slug' => $category->slug,
            'Description' => $category->description,
            'Icon' => $category->icon,
            'Enable' => $category->enable,
            'Destroy' => $category->destroy,
            'AllForms' => $allForms,
            'Forms' => $formInCategory,
            'Delete' => route('adminOffersCategoryDelete', $category->slug),
            'Edit' => route('adminOffersCategoryEdit', $category->slug)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category)
    {
        self::updateFormInCategory($request->form, $category->id);
        if ($category->update(['name' => $request->name, 'slug' => $request->slug, 'description' => $request->description, 'enable' => $request->enable, 'icon' => $request->icon]))
            return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Category updated complete', 'type' => 'success']);
        else
            return response()->json(['status'=>0,'title'=>'Error','msg'=>'ERROR update','type'=>'error']);
    }

    static function updateFormInCategory ($form, $id)
    {
        $oldFormsInCategory = ElementFormInCategory::where('cat_id', $id)->get();
        foreach ($oldFormsInCategory as $item)
        {
            $element = ElementFormInCategory::find($item->id);
            $element->delete();
        }
        if(!empty($form))
        {
            foreach ($form as $item => $value)
            {
                ElementFormInCategory::create(['cat_id' => $id, 'form_id' => $value]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        if($category->destroy == true){
            $category->destroy = false;
        }else{
            $category->enable = false;
            $category->destroy = true;
        }
        if ($category->save())
            return response()->json(['status' => 1, 'title' => 'Success', 'msg' => 'Category delete successfull change', 'type' => 'success']);
        else
            return response()->json(['status'=>0,'title'=>'Error','msg'=>'ERROR delete','type'=>'error']);
    }
}

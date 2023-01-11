<?php

namespace App\Http\Service;

use App\Http\Repositories\CategoryRepositoryInterface;
use App\Http\Requests\CreateAdminOfferCategory;
use App\Http\Response\BasicErrorResponse;
use App\Http\Response\BasicSuccessResponse;
use App\Models\ElementFormInCategory;

class AdminOfferCategoryService
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(CreateAdminOfferCategory $request)
    {
        $request->validated();
        $category = $this->categoryRepository->create($request->all());

        if ($category) {
            self::updateFormInCategory($request->form, $category->id);
            $response = new BasicSuccessResponse('Category created complete');
            return response()->json($response->asArray());
        } else {
            $response = new BasicErrorResponse('ERROR Create');
            return response()->json($response->asArray());
        }
    }

    static function updateFormInCategory($form, $id)
    {
        $oldFormsInCategory = ElementFormInCategory::where('cat_id', $id)->get();
        foreach ($oldFormsInCategory as $item) {
            $element = ElementFormInCategory::find($item->id);
            $element->delete();
        }
        if (!empty($form)) {
            foreach ($form as $item => $value) {
                ElementFormInCategory::create(['cat_id' => $id, 'form_id' => $value]);
            }

        }
    }
}

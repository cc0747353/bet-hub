<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class CategoryController extends AppBaseController
{
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(): View|Factory|Application
    {
        return view('categories.index');
    }


    public function store(CreateCategoryRequest $request): JsonResponse
    {
        $this->categoryRepository->store($request->all());

        return $this->sendSuccess(__('messages.flash.category_create'));
    }


    public function edit(Category $category): JsonResponse
    {
        return $this->sendResponse($category, __('messages.flash.category_retrieve'));
    }


    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $input = $request->all();
        $service = $this->categoryRepository->update($input, $category->id);

        return $this->sendResponse($service, __('messages.flash.category_update'));

    }

    public function destroy(Category $category): JsonResponse
    {
        if ($category->league_count > 0) {
            return $this->sendError(__('messages.flash.category_cannot_deleted'));

        }

        $category->delete();

        return $this->sendSuccess(__('messages.flash.category_deleted'));
    }

    public function changeStatus(Category $category): JsonResponse
    {
        $category->update(['status' => $category->status == 0 ? 1 : 0]);

        return $this->sendResponse($category, __('messages.flash.category_status'));
    }
}

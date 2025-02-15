<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use LaravelIdea\Helper\App\Models\_IH_Category_C;


/**
 * Class CategoryRepository
 */
class CategoryRepository extends BaseRepository
{
    public $fieldSearchable = [
        'name',
    ];

    public function getFieldsSearchable(): mixed
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Category::class;
    }

    public function store($input): Category
    {
        try {
            DB::beginTransaction();

            $input['status'] = isset($input['status']) ? 1 : 0;
            $category = Category::create($input);

            DB::commit();

            return $category;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function update($input, $id): _IH_Category_C|array|Category
    {
        try {
            DB::beginTransaction();
            $input['status'] = isset($input['status']) ? 1 : 0;
            $category = Category::findOrFail($id);
            $category->update($input);


            DB::commit();

            return $category;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}

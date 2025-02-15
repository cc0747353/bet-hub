<?php

namespace App\Repositories;

use App\Models\Blog;
use Exception;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class LeagueRepository
 */
class BlogRepository extends BaseRepository
{
    public $fieldSearchable = [
        'title',
    ];

    public function getFieldsSearchable(): mixed
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Blog::class;
    }

    public function store($input): bool
    {
        try {
            $blog = Blog::create($input);

            if (!empty($input['image'])) {
                $blog->addMedia($input['image'])->toMediaCollection(Blog::IMAGE,
                    config('app.media_disc'));
            }

            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function update($input, $blog): void
    {
        try {

            $blog->update($input);
            if (isset($input['image']) && !empty($input['image'])) {
                $blog->clearMediaCollection(Blog::IMAGE);
                $blog->addMedia($input['image'])->toMediaCollection(Blog::IMAGE,
                    config('app.media_disc'));
            }

        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}

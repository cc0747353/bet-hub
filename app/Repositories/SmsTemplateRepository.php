<?php

namespace App\Repositories;

use App\Models\SmsTemplate;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class EmailTemplateRepository
 */
class SmsTemplateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'message',
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return SmsTemplate::class;
    }

    public function store($input): void
    {
        try {
            $inputArr = Arr::except($input, ['_token']);
            $inputArr['status'] = isset($inputArr['status']) ?: 0;

            SmsTemplate::create($inputArr);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function update($input, $id): void
    {
        try {
            $inputArr = Arr::except($input, ['_token']);
            $inputArr['status'] = isset($inputArr['status']) ?: 0;
            $template = SmsTemplate::findOrFail($id);
            $template->update($inputArr);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Models\Currency;
use App\Repositories\CurrencyRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class CurrencyController extends AppBaseController
{

    /**
     * @var CurrencyRepository
     */
    private CurrencyRepository $currencyRepository;

    /**
     * @param CurrencyRepository $currencyRepository
     */
    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function index(): Application|Factory|View
    {
        return view('currencies.index');
    }

    public function store(CreateCurrencyRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['currency_code'] = strtoupper($input['currency_code']);
        $currencyForment = checkCurrency($input['currency_code']);

        if (!$currencyForment) {
            return $this->sendError(__('messages.flash.currency_code_invalid'));
        }
        $this->currencyRepository->store($input);

        return $this->sendSuccess(__('messages.flash.currency_create'));

    }

    public function edit(Currency $currency): JsonResponse
    {
        return $this->sendResponse($currency, __('messages.flash.currency_retrieved'));
    }

    public function update(UpdateCurrencyRequest $request, $id): JsonResponse
    {
        $input = $request->all();
        $input['currency_code'] = strtoupper($input['currency_code']);
        $currencyForment = checkCurrency($input['currency_code']);
        if (!$currencyForment) {
            return $this->sendError(__('messages.flash.currency_code_invalid'));
        }
        $this->currencyRepository->update($input, $id);

        return $this->sendSuccess(__('messages.flash.currency_updated'));
    }

    public function destroy(Currency $currency): JsonResponse
    {
        $currency->delete();

        return $this->sendSuccess(__('messages.flash.currency_deleted'));
    }
}

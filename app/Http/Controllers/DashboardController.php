<?php

namespace App\Http\Controllers;

use App\Repositories\DashboardRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class DashboardController extends AppBaseController
{

    /**
     * @param DashboardRepository $dashboardRepository
     */
    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepo = $dashboardRepository;
    }

    public function index(): Factory|View|Application
    {
        $data = $this->dashboardRepo->getData();

        return view('dashboard.dashboard', compact('data'));
    }

    public function dashboardChartData(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $data = $this->dashboardRepo->dashboardChartData($input);

            return $this->sendResponse($data, 'Data fetch successfully.');

        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function dashboardWithdrawChartData(Request $request): JsonResponse
    {
        $input = $request->all();
        $data = $this->dashboardRepo->dashboardWithdrawChartData($input);

        return $this->sendResponse($data, 'Withdraw Data fetch successfully.');
    }

    public function browserChartData(): JsonResponse
    {
        $data = $this->dashboardRepo->dashboardBrowserChartData();

        return $this->sendResponse($data, 'Browser chart data fetch successfully.');
    }

    public function countryChartData(): JsonResponse
    {
        $data = $this->dashboardRepo->dashboardCountryChartData();

        return $this->sendResponse($data, 'Browser chart data fetch successfully.');
    }

    public function deviceChartData(): JsonResponse
    {
        $data = $this->dashboardRepo->dashboardDeviceChartData();

        return $this->sendResponse($data, 'Browser chart data fetch successfully.');
    }
}

<?php

namespace App\Repositories;

use App\Models\AllMatch;
use App\Models\Analytic;
use App\Models\Bet;
use App\Models\DepositTransaction;
use App\Models\User;
use App\Models\WithdrawRequests;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardRepository
{

    public function getData(): array
    {
        $data['user'] = User::whereStatus(1)->count() - 1;
        $data['deposit'] = DepositTransaction::whereStatus(1)->sum('deposit_amount');
        $data['match'] = AllMatch::count();
        $data['bet'] = Bet::count();

        return $data;
    }


    public function dashboardChartData($input): array
    {
        $startDate = isset($input['start_date']) ? Carbon::parse($input['start_date']) : '';
        $endDate = isset($input['end_date']) ? Carbon::parse($input['end_date']) : '';
        $transactions = DepositTransaction::whereStatus(1)
            ->where('created_at', '>', Carbon::now()->subDays(30))->get()
            ->groupBy(function ($q) {
                return Carbon::parse($q->created_at)->isoFormat('MMM DD');
            });
        $labels = [];
        $dataset = [];
        $period = CarbonPeriod::create($startDate, $endDate);
        foreach ($period as $key => $period) {
            $month = $period->isoFormat('MMM DD');
            $labels[] = $month;
            $amounts = isset($transactions[$month])
                ? $transactions[$month]->sum('deposit_amount') : 0;

            $dataset[] = removeCommaFromNumbers(number_format($amounts, 2));

        }
        $data['labels'] = $labels;
        $data['breakDown'][] = [
            'label'           => 'Total Amount',
            'data'            => $dataset,
            'backgroundColor' => getBGColors(1),
            'borderColor'     => getBGColors(2),
            'lineTension'     => 0.5,
            'radius'          => 4,
        ];

        return $data;
    }
    
    public function dashboardWithdrawChartData($input): array
    {
        $startDate = isset($input['start_date']) ? Carbon::parse($input['start_date']) : '';
        $endDate = isset($input['end_date']) ? Carbon::parse($input['end_date']) : '';
        $withdrawTransactions = WithdrawRequests::whereStatus(1)
            ->where('created_at', '>', Carbon::now()->subDays(30))->get()
            ->groupBy(function ($q) {
                return Carbon::parse($q->created_at)->isoFormat('MMM DD');
            });
        $labels = [];
        $dataset = [];
        $period = CarbonPeriod::create($startDate, $endDate);
        foreach ($period as $key => $period) {
            $month = $period->isoFormat('MMM DD');
            $labels[] = $month;
            $amounts = isset($withdrawTransactions[$month])
                ? $withdrawTransactions[$month]->sum('amount') : 0;

            $dataset[] = removeCommaFromNumbers(number_format($amounts, 2));

        }
        $data['labels'] = $labels;
        $data['breakDown'][] = [
            'label'           => 'Total Amount',
            'data'            => $dataset,
            'backgroundColor' => getBGColors(5),
            'borderColor'     => getBGColors(6),
            'lineTension'     => 0.8,
            'radius'          => 5,
        ];

        return $data;
    }


    public function dashboardBrowserChartData(): array
    {
        $Browsers = Analytic::all()->groupBy('browser');
        $Data = [];
        foreach ($Browsers as $Name => $Browser) {
            $Data['labels'][] = $Name;
            $Data['browserCount'][] = $Browser->count();
        }

        return $Data;
    }
    
    public function dashboardCountryChartData(): array
    {
        $Countries = Analytic::all()->groupBy('country');
        $Data = [];
        foreach ($Countries as $Name => $Country) {
            $Data['labels'][] = $Name;
            $Data['countryCount'][] = $Country->count();
        }

        return $Data;
    }
    
    public function dashboardDeviceChartData(): array
    {
        $Devices = Analytic::all()->groupBy('device');
        $Data = [];
        foreach ($Devices as $Name => $Device) {
            $Data['labels'][] = $Name;
            $Data['deviceCount'][] = $Device->count();
        }

        return $Data;
    }
}

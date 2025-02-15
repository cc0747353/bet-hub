@extends('layouts.app')
@section('title')
    {{ __('messages.dashboard.dashboard') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @php
                $textCss = 'style'
            @endphp
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="row">
                        <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                            <div
                                    class="bg-primary shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                                <div
                                        class="bg-cyan-300 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-user fs-1-xl text-white"></i>
                                </div>
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-bolder text-white">{{ $data['user'] }}</h2>
                                    <h3 class="mb-0 fs-4 fw-light">{{ __('messages.dashboard.active_user') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                            <div
                                    class="bg-success shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                                <div
                                        class="bg-green-300 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fas fa-money-bill fs-1-xl text-white"></i>
                                </div>
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-bolder text-white">{{ numberFormatShort($data['deposit']) }}</h2>
                                    <h3 class="mb-0 fs-4 fw-light">{{ __('messages.dashboard.total_deposit') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                            <div
                                    class="bg-info shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                                <div
                                        class="bg-blue-300 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-bowling-ball fs-1-xl text-white"></i>
                                </div>
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-bolder text-white">{{ $data['match'] }}</h2>
                                    <h3 class="mb-0 fs-4 fw-light">{{ __('messages.dashboard.total_match') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                            <div
                                    class="bg-warning shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                                <div
                                        class="bg-yellow-300 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-money-bill fs-1-xl text-white"></i>
                                </div>
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-bolder text-white">{{ $data['bet'] }}</h2>
                                    <h3 class="mb-0 fs-4 fw-light">{{ __('messages.dashboard.total_bet') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-5">
                    <div class="card">
                        <div class="card-header pb-0 px-10">
                            <h3 class="mb-0 mb-3">{{ __('messages.dashboard.deposit_analytic') }}</h3>
                            <div class="ms-auto">
                                <button type="button" class="btn btn-icon btn-outline-primary me-5 mb-3" title="Switch Chart">
                                    <span class="svg-icon svg-icon-1 m-0 text-center" id="dashboardChangeChart">
                                    <i class="fa-solid fa-chart-line chart"></i>
                                </span>
                                </button>
                                <div id="dashboardTimeRange" class="time_range
                                    btn btn-outline-primary align-items-center mb-3">
                                    <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                    &nbsp;&nbsp<span></span> <b class="caret"></b>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <div id="dashboardWeeklyAdminBarChartContainer">
                                    <canvas id="dashboardWeeklyAdminBarChart" height="200" width="905"
                                            {{$textCss}}="display: block; width: 905px; height: 200px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-5">
                    <div class="card">
                        <div class="card-header pb-0 px-10">
                            <h3 class="mb-0 mb-3">{{ __('messages.dashboard.withdraw_analytic') }}</h3>
                            <div class="ms-auto">
                                <button type="button" class="btn btn-icon btn-outline-primary me-5 mb-3" title="Switch Chart">
                                    <span class="svg-icon svg-icon-1 m-0 text-center" id="dashboardChangeWithdrawChart">
                                    <i class="fa-solid fa-chart-line withdraw_chart"></i>
                                </span>
                                </button>
                                <div id="dashboardWithdrawTimeRange" class="withdraw_time_range
                                    btn btn-outline-primary align-items-center mb-3">
                                    <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                    &nbsp;&nbsp<span></span> <b class="caret"></b>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <div id="dashboardWithdrawWeeklyAdminBarChartContainer">
                                    <canvas id="dashboardWithdrawWeeklyAdminBarChart" height="200" width="905"
                                        {{$textCss}}="display: block; width: 905px; height: 200px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-12 mb-5 mb-xxl-0">
                    <div class="card">
                        <div class="card-header pb-0 px-10">
                            <h3 class="mb-0">{{ __('messages.dashboard.login_by_browser') }}</h3>
                        </div>
                        <div class="card-body p-5">
                            <canvas id="dashboardBrowserChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-12 mb-5 mb-xxl-0">
                    <div class="card">
                        <div class="card-header pb-0 px-10">
                            <h3 class="mb-0">{{ __('messages.dashboard.login_by_country') }}</h3>
                        </div>
                        <div class="card-body p-5">
                            <canvas id="dashboardCountryChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-12 mb-5 mb-xxl-0">
                    <div class="card">
                        <div class="card-header pb-0 px-10">
                            <h3 class="mb-0">{{ __('messages.dashboard.login_by_device') }}</h3>
                        </div>
                        <div class="card-body p-5">
                            <canvas id="dashboardDeviceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

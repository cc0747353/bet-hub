document.addEventListener('turbo:load', loadDashboardData)

function loadDashboardData () {
    datePickerInitialise()
    loadAdminDashboardData()
}

let dashboardChartType = 'line'
let dashboardWithdrawChartType = 'line'
let dashboardStacked = false
let dashboardWithdrawStacked = false
let dashboardWeeklyBarChartResult = ''
let dashboardWeeklyWithdrawBarChartResult = ''

let start = ''
let end = ''
const datePickerInitialise = () => {
    if (!$('#dashboardTimeRange').length) {
        return
    }
    if (!$('#dashboardWithdrawTimeRange').length) {
        return
    }
    let timeRange = $('#dashboardTimeRange')
    let withdrawTimeRange = $('#dashboardWithdrawTimeRange')
    let isPickerApply = true
    const today = moment()
    start = moment().subtract('30', 'days')
    end = today.clone().endOf('days')
    timeRange.on('apply.daterangepicker', function (ev, picker) {
        isPickerApply = true
        start = picker.startDate
        end = picker.endDate
        loadDashboardAdminChart(start.format('YYYY-MM-D  H:mm:ss'),
            end.format('YYYY-MM-D  H:mm:ss'))
    })

    window.cb = function (start, end) {
        timeRange.find('span').
            html(start.format('MMM D, YYYY') + ' - ' +
                end.format('MMM D, YYYY'))
    }

    timeRange.daterangepicker({
        startDate: start,
        endDate: end,
        opens: 'left',
        showDropdowns: true,
        autoUpdateInput: false,
        locale: {
            customRangeLabel: Lang.get('messages.common.custom'),
            applyLabel: Lang.get('messages.common.apply'),
            cancelLabel: Lang.get('messages.common.cancel'),
            fromLabel: Lang.get('messages.common.from'),
            toLabel: Lang.get('messages.common.to'),
            monthNames: [
                Lang.get('messages.months.jan'),
                Lang.get('messages.months.feb'),
                Lang.get('messages.months.mar'),
                Lang.get('messages.months.apr'),
                Lang.get('messages.months.may'),
                Lang.get('messages.months.jun'),
                Lang.get('messages.months.jul'),
                Lang.get('messages.months.aug'),
                Lang.get('messages.months.sep'),
                Lang.get('messages.months.oct'),
                Lang.get('messages.months.nov'),
                Lang.get('messages.months.dec'),
            ],

            daysOfWeek: [
                Lang.get('messages.weekdays.sun'),
                Lang.get('messages.weekdays.mon'),
                Lang.get('messages.weekdays.tue'),
                Lang.get('messages.weekdays.wed'),
                Lang.get('messages.weekdays.thu'),
                Lang.get('messages.weekdays.fri'),
                Lang.get('messages.weekdays.sat')],
        },
        ranges: {
            [Lang.get('messages.placeholder.this_week')]: [
                moment().
                    startOf('week'), moment().endOf('week')],
            [Lang.get('messages.placeholder.last_week')]: [
                moment().startOf('week').subtract(7, 'days'),
                moment().startOf('week').subtract(1, 'days')],
        },
    }, cb)
    cb(start, end)

    loadDashboardAdminChart(start.format('YYYY-MM-D H:mm:ss'),
        end.format('YYYY-MM-D H:mm:ss'))

    withdrawTimeRange.on('apply.daterangepicker', function (ev, picker) {
        isPickerApply = true
        start = picker.startDate
        end = picker.endDate
        loadDashboardAdminWithdrawChart(start.format('YYYY-MM-D  H:mm:ss'),
            end.format('YYYY-MM-D  H:mm:ss'))
    })

    window.cb = function (start, end) {
        withdrawTimeRange.find('span').
            html(start.format('MMM D, YYYY') + ' - ' +
                end.format('MMM D, YYYY'))
    }
    
    withdrawTimeRange.daterangepicker({
        startDate: start,
        endDate: end,
        opens: 'left',
        showDropdowns: true,
        autoUpdateInput: false,
        locale: {
            customRangeLabel: Lang.get('messages.common.custom'),
            applyLabel: Lang.get('messages.common.apply'),
            cancelLabel: Lang.get('messages.common.cancel'),
            fromLabel: Lang.get('messages.common.from'),
            toLabel: Lang.get('messages.common.to'),
            monthNames: [
                Lang.get('messages.months.jan'),
                Lang.get('messages.months.feb'),
                Lang.get('messages.months.mar'),
                Lang.get('messages.months.apr'),
                Lang.get('messages.months.may'),
                Lang.get('messages.months.jun'),
                Lang.get('messages.months.jul'),
                Lang.get('messages.months.aug'),
                Lang.get('messages.months.sep'),
                Lang.get('messages.months.oct'),
                Lang.get('messages.months.nov'),
                Lang.get('messages.months.dec'),
            ],

            daysOfWeek: [
                Lang.get('messages.weekdays.sun'),
                Lang.get('messages.weekdays.mon'),
                Lang.get('messages.weekdays.tue'),
                Lang.get('messages.weekdays.wed'),
                Lang.get('messages.weekdays.thu'),
                Lang.get('messages.weekdays.fri'),
                Lang.get('messages.weekdays.sat')],
        },
        ranges: {
            [Lang.get('messages.placeholder.this_week')]: [
                moment().
                    startOf('week'), moment().endOf('week')],
            [Lang.get('messages.placeholder.last_week')]: [
                moment().startOf('week').subtract(7, 'days'),
                moment().startOf('week').subtract(1, 'days')],
        },
    }, cb)
    cb(start, end)

    loadDashboardAdminWithdrawChart(start.format('YYYY-MM-D H:mm:ss'),
        end.format('YYYY-MM-D H:mm:ss'))

}

const loadDashboardAdminChart = (startDate, endDate) => {
    $.ajax({
        type: 'GET',
        url: route('dashboard.admin.chart'),
        dataType: 'json',
        data: {
            start_date: startDate,
            end_date: endDate,
        },
        success: function (result) {
            dashboardWeeklyBarChartResult = result
            dashboardWeeklyBarChart(result)
        },
        cache: false,
    })
}

const dashboardWeeklyBarChart = (result) => {
    const dashboardWeeklyAdminBarChartContainer = $(
        '#dashboardWeeklyAdminBarChartContainer')
    if (!dashboardWeeklyAdminBarChartContainer.length) {
        return
    }

    dashboardWeeklyAdminBarChartContainer.html('')
    $('canvas#dashboardWeeklyAdminBarChart').remove()
    dashboardWeeklyAdminBarChartContainer.append(
        '<canvas id="dashboardWeeklyAdminBarChart" height="275" width="905" style="display: block; width: 905px; height: 500px;"></canvas>')

    let data = result.data
    let barChartData = {
        labels: data.labels,
        datasets: data.breakDown,
    }
    let ctx = $('#dashboardWeeklyAdminBarChart')
    let config = new Chart(ctx, {
        type: dashboardChartType,
        data: barChartData,
        options: {
            plugins: {
                legend: {
                    display: false,
                },
            },
            scales: {
                y: {
                    stacked: dashboardStacked,
                    ticks: {
                        min: 0,
                        precision: 0,
                    },
                    min: 0,
                },
                x: {
                    stacked: dashboardStacked,
                },
            },
        },
    })
}

listenClick('#dashboardChangeChart', function () {
    if (dashboardChartType === 'bar') {
        dashboardChartType = 'line'
        dashboardStacked = false
        $('.chart').removeClass('fa-chart-line')
        $('.chart').addClass('fa-chart-column')
        dashboardWeeklyBarChart(dashboardWeeklyBarChartResult)
    } else {
        dashboardChartType = 'bar'
        dashboardStacked = true
        $('.chart').addClass('fa-chart-line')
        $('.chart').removeClass('fa-chart-column')
        dashboardWeeklyBarChart(dashboardWeeklyBarChartResult)
    }
})

const loadDashboardAdminWithdrawChart = (startDate, endDate) => {
    $.ajax({
        type: 'GET',
        url: route('dashboard.admin.withdraw.chart'),
        dataType: 'json',
        data: {
            start_date: startDate,
            end_date: endDate,
        },
        success: function (result) {
            dashboardWeeklyWithdrawBarChartResult = result
            dashboardWeeklyWithdrawBarChart(result)
        },
        cache: false,
    })
}

const dashboardWeeklyWithdrawBarChart = (result) => {
    const dashboardWithdrawWeeklyAdminBarChartContainer = $(
        '#dashboardWithdrawWeeklyAdminBarChartContainer')
    if (!dashboardWithdrawWeeklyAdminBarChartContainer.length) {
        return
    }

    dashboardWithdrawWeeklyAdminBarChartContainer.html('')
    $('canvas#dashboardWithdrawWeeklyAdminBarChart').remove()
    dashboardWithdrawWeeklyAdminBarChartContainer.append(
        '<canvas id="dashboardWithdrawWeeklyAdminBarChart" height="275" width="905" style="display: block; width: 905px; height: 500px;"></canvas>')

    let data = result.data
    let barChartData = {
        labels: data.labels,
        datasets: data.breakDown,
    }
    let ctx = $('#dashboardWithdrawWeeklyAdminBarChart')
    let config = new Chart(ctx, {
        type: dashboardWithdrawChartType,
        data: barChartData,
        options: {
            plugins: {
                legend: {
                    display: false,
                },
            },
            scales: {
                y: {
                    stacked: dashboardWithdrawStacked,
                    ticks: {
                        min: 0,
                        precision: 0,
                    },
                    min: 0,
                },
                x: {
                    stacked: dashboardWithdrawStacked,
                },
            },
        },
    })
}

listenClick('#dashboardChangeWithdrawChart', function () {
    if (dashboardWithdrawChartType === 'bar') {
        dashboardWithdrawChartType = 'line'
        dashboardWithdrawStacked = false
        $('.withdraw_chart').removeClass('fa-chart-line')
        $('.withdraw_chart').addClass('fa-chart-column')
        dashboardWeeklyWithdrawBarChart(dashboardWeeklyWithdrawBarChartResult)
    } else {
        dashboardWithdrawChartType = 'bar'
        dashboardWithdrawStacked = true
        $('.withdraw_chart').addClass('fa-chart-line')
        $('.withdraw_chart').removeClass('fa-chart-column')
        dashboardWeeklyWithdrawBarChart(dashboardWeeklyWithdrawBarChartResult)
    }
})

window.randomColorsForBrowser = [
    'rgb(245, 158, 11)',
    'rgb(77, 124, 15)',
    'rgb(254, 199, 2)',
    'rgb(80, 205, 137)',
    'rgb(16, 158, 247)',
    'rgb(241, 65, 108)',
    'rgb(80, 205, 137)',
    'rgb(245, 152, 280)',
    'rgb(13, 148, 136)',
    'rgb(59, 130, 246)',
]

function loadAdminDashboardData () {
    dashboardBrowserChartData()
    dashboardCountryChartData()
    dashboardDeviceChartData()
}

const dashboardBrowserChartData = () => {
    if (!$('#dashboardBrowserChart').length) {
        return
    }
    $.ajax({
        type: 'post',
        url: route('dashboard.browser-chart'),
        dataType: 'json',
        success: function (result) {
            dashboardBrowserChart(result.data.browserCount, result.data.labels)
        },
        cache: false,
    })
}

const dashboardBrowserChart = (browserCount, labels) => {
    if (!$('#dashboardBrowserChart').length) {
        return
    }
    let ctx = document.getElementById('dashboardBrowserChart').
        getContext('2d')
    new Chart(ctx, {
        type: 'doughnut',
        options: {
            responsive: true,
            responsiveAnimationDuration: 500,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return labels[context.dataIndex] + ': ' + context.formattedValue + ' '
                        },
                    },
                },
            },
        },
        data: {
            datasets: [
                {
                    data: browserCount,
                    backgroundColor: randomColorsForBrowser,
                    hoverOffset: 5,
                }],
        },
    })
}

window.randomColorsForCountry = [
    'rgb(232, 158, 129)',
    'rgb(87, 161, 186)',
    'rgb(157, 145, 170)',
    'rgb(219, 168, 184)',
    'rgb(63, 204, 96)',
    'rgb(163, 117, 206)',
    'rgb(126, 175, 204)',
    'rgb(209, 233, 249)',
    'rgb(252, 122, 35)',
    'rgb(95, 148, 136)',
]

const dashboardCountryChartData = () => {
     if (!$('#dashboardCountryChart').length) {
         return
     }
    $.ajax({
        type: 'post',
        url: route('dashboard.country-chart'),
        dataType: 'json',
        success: function (result) {
            dashboardCountryChart(result.data.countryCount, result.data.labels)
        },
        cache: false,
    })
}

const dashboardCountryChart = (countryCount, labels) => {
    if (!$('#dashboardCountryChart').length) {
        return
    }
    let ctx = document.getElementById('dashboardCountryChart').
        getContext('2d')
    new Chart(ctx, {
        type: 'doughnut',
        options: {
            responsive: true,
            responsiveAnimationDuration: 500,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return labels[context.dataIndex] + ': ' + context.formattedValue + ' '
                        },
                    },
                },
            },
        },
        data: {
            datasets: [
                {
                    data: countryCount,
                    backgroundColor: randomColorsForCountry,
                    hoverOffset: 5,
                }],
        },
    })
}

window.randomColorsForDevice = [
    'rgb(145, 47, 153)',
    'rgb(153, 125, 117)',
    'rgb(45, 79, 51)',
    'rgb(173, 124, 135)',
    'rgb(105, 142, 111)',
    'rgb(147, 125, 144)',
    'rgb(168, 114, 162)',
    'rgb(159, 63, 191)',
    'rgb(48, 40, 45)',
    'rgb(48, 21, 40)',
]

const dashboardDeviceChartData = () => {
    if (!$('#dashboardDeviceChart').length) {
        return
    }
    $.ajax({
        type: 'post',
        url: route('dashboard.device-chart'),
        dataType: 'json',
        success: function (result) {
            dashboardDeviceChart(result.data.deviceCount, result.data.labels)
        },
        cache: false,
    })
}

const dashboardDeviceChart = (deviceCount, labels) => {
    if (!$('#dashboardDeviceChart').length) {
        return
    }
    let ctx = document.getElementById('dashboardDeviceChart').
        getContext('2d')
    new Chart(ctx, {
        type: 'doughnut',
        options: {
            responsive: true,
            responsiveAnimationDuration: 500,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return labels[context.dataIndex] + ': ' + context.formattedValue + ' '
                        },
                    },
                },
            },
        },
        data: {
            datasets: [
                {
                    data: deviceCount,
                    backgroundColor: randomColorsForDevice,
                    hoverOffset: 5,
                }],
        },
    })
}

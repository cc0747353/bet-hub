<div class="d-flex justify-content-between align-items-end mb-5">
    <h1>@yield('title')</h1>
    <a class="btn btn-outline-primary float-end"
       href="{{ url()->previous() }}">{{ __('messages.common.back') }}</a>
</div>

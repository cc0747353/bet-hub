@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset(getAppLogo()) }}" class="logo" alt="{{ getAppName() }}">
        @endcomponent
    @endslot
    @php
        $color = 'primary';
                    $search = array('#currency#','#amount#','#method_name#');
                    $replace = array($currency,$amount,$method_name);
                    $emails = str_replace($search,$replace,$email['message'])
    @endphp
    {{-- Body --}}
    <div>
        <h2>{{ __('messages.hello') }}{{','.$name}}</h2>
        <p>{!! $emails !!}</p>
        <br><br>
        <p> {!! __('messages.email_template.thanks_regard') !!} </p>
        <p>{!! getAppName() !!}</p>
    </div>

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>© {{ date('Y') }} {{ getAppName() }}.</h6>
        @endcomponent
    @endslot
@endcomponent

@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset(getAppLogo()) }}" class="logo" alt="{{ getAppName() }}">
        @endcomponent
    @endslot
    @php
        $color = 'primary';
                $google_map  = '<a target="_blank" class="button button-primary" style="margin-bottom: 15px"  href="'.route('user.bets-details').'">View</a>';
                    $search = array('#match#','#question#','#option#','#currency#','#refund_amount#','#link#');
                    $replace = array($match,$question,$option,$currency,$refund_amount,$google_map);
                   $emails = str_replace($search,$replace,$email->message);
    @endphp
    {{-- Body --}}
    <div>
        <h2>{{ __('messages.hello') }}{{','.$name}}</h2>
        <p>{!! $emails !!}</p>
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

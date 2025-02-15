@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset(getAppLogo()) }}" class="logo" alt="{{ getAppName() }}">
        @endcomponent
    @endslot
    @php
        $color = 'primary';
                $googel_map  = '<div style="display: flex; justify-content: center;"><a target="_blank" class="button button-primary" style="margin-bottom: 15px"  href="'.$url.'">Reset Password</a></div>';
                    $search = array('#link#');
                    $replace = array($googel_map);
                   $emails = str_replace($search,$replace,$emails['message'])
    @endphp
    {{-- Body --}}
    <div>
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

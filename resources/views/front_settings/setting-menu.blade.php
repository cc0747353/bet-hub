<ul class="nav nav-tabs mb-5 pb-1 overflow-auto flex-nowrap text-nowrap" id="home" role="tablist">
    <li class="nav-item position-relative me-7 mb-3" role="presentation">
        <a class="nav-link {{(isset($sectionName) && $sectionName ==='home') ?  'active' : ''}}" href="{{ route('front.settings.index', ['section' => 'home']) }}" tabindex="-1">{{ __('messages.front_settings.home') }}</a>    
    </li>
    <li class="nav-item position-relative me-7 mb-3" role="presentation">
        <a class="nav-link {{(isset($sectionName) && $sectionName === 'about-us') ? 'active' : ''}}" href="{{ route('front.settings.index',                     ['section' => 'about-us']) }}" tabindex="-1">{{ __('messages.front_settings.about_us') }}</a>
    </li>
    <li class="nav-item position-relative me-7 mb-3" role="presentation">
        <a class="nav-link {{(isset($sectionName) && $sectionName === 'affiliate') ? 'active' : ''}}" href="{{ route('front.settings.index',                     ['section' => 'affiliate']) }}" tabindex="-1">{{ __('messages.front_settings.affiliate') }}</a>
    </li>
    <li class="nav-item position-relative me-7 mb-3" role="">
        <a class="nav-link {{(isset($sectionName) && $sectionName === 'contact-us') ? 'active' : ''}}" href="{{ route('front.settings.index',                     ['section' => 'contact-us']) }}" tabindex="-1">{{ __('messages.front_settings.contact_us') }}</a>
    </li>
</ul>

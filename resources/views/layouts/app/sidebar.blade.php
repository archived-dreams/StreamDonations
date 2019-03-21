<aside class="sidebar">
    <div class="sidebar-container">
        {{-- Logo --}}
        <div class="sidebar-header">
            <a href="{{ route('home') }}" style="text-decoration:none">
                <div class="brand">
                    {{ config('app.title') }}
                </div>
            </a>
        </div>
        {{-- Menu --}}
        <nav class="menu">
            <ul class="nav metismenu" id="sidebar-menu">
                {{-- Dashboard --}}
                <li class="active">
                    <a href="#">@lang('sidebar.account.title')</a>
                    <ul class="nav nav-second-level in">
                        <li><a href="{{ route('home') }}"><i class="fa fa-dashboard fa-fw"></i> @lang('sidebar.account.dashboard')</a></li>
                        <li><a href="{{ route('donations') }}"><i class="fa fa-comment-o fa-fw"></i> @lang('sidebar.account.donations')</a></li>
                    </ul>
                </li>
                {{-- Settings --}}
                <li class="active">
                    <a href="#">@lang('sidebar.settings.title')</a>
                    <ul class="nav nav-second-level in">
                        <li><a href="{{ route('settings.account') }}"><i class="fa fa-ils fa-fw" aria-hidden="true"></i> @lang('sidebar.settings.account')</a></li>
                        <li><a href="{{ route('settings.donation') }}"><i class="fa fa-map-o fa-fw"></i> @lang('sidebar.settings.donation')</a></li>
                    </ul>
                </li>
                {{-- Widgets --}}
                <li class="active">
                    <a href="#">@lang('sidebar.widgets.title')</a>
                    <ul class="nav nav-second-level in">
                        <li><a href="{{ route('widgets.eventlist') }}"><i class="fa fa-newspaper-o fa-fw" aria-hidden="true"></i> @lang('sidebar.widgets.eventlist')</a></li>
                        <li><a href="{{ route('widgets.alertbox') }}"><i class="fa fa-bell-o fa-fw" aria-hidden="true"></i> @lang('sidebar.widgets.alertbox')</a></li>
                        <li><a href="{{ route('widgets.donationgoal') }}"><i class="fa fa-calendar fa-fw" aria-hidden="true"></i> @lang('sidebar.widgets.donationgoal')</a></li>
                    </ul>
                </li>
                {{-- Apanel --}}
                @if (Auth::user()->level == 'admin')
                    <li class="active">
                        <a href="#">@lang('sidebar.apanel.title')</a>
                        <ul class="nav nav-second-level in">
                            <li><a href="{{ route('apanel.statistics') }}"><i class="fa fa-bar-chart-o fa-fw" aria-hidden="true"></i> @lang('sidebar.apanel.statistics')</a></li>
                            <li><a href="{{ route('apanel.configurations') }}"><i class="fa fa-sliders fa-fw" aria-hidden="true"></i> @lang('sidebar.apanel.configurations')</a></li>
                            <li><a href="{{ route('apanel.donations') }}"><i class="fa fa-comment-o fa-fw" aria-hidden="true"></i> @lang('sidebar.apanel.donations')</a></li>
                            <li><a href="{{ route('apanel.users') }}"><i class="fa fa-user fa-fw" aria-hidden="true"></i> @lang('sidebar.apanel.users')</a></li>
                        </ul>
                    </li>
                @endif
                {{-- Pages --}}
                <li class="active">
                    <a href="#">@lang('sidebar.pages.title')</a>
                    <ul class="nav nav-second-level in">
                        <li><a href="{{ route('pages.static', ['slug' => 'about']) }}"><i class="fa fa-book fa-fw" aria-hidden="true"></i> @lang('sidebar.pages.about')</a></li>
                        <li><a href="{{ route('pages.contact') }}"><i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i> @lang('sidebar.pages.contact')</a></li>
                        <li><a href="{{ route('pages.static', ['slug' => 'faq']) }}"><i class="fa fa-question-circle fa-fw" aria-hidden="true"></i> @lang('sidebar.pages.faq')</a></li>
                        <li><a href="{{ route('pages.static', ['slug' => 'terms-and-conditions']) }}"><i class="fa fa-handshake-o fa-fw" aria-hidden="true"></i> @lang('sidebar.pages.terms_and_conditions')</a></li>
                        <li><a href="{{ route('pages.static', ['slug' => 'privacy-policy']) }}"><i class="fa fa-hand-paper-o fa-fw" aria-hidden="true"></i> @lang('sidebar.pages.privacy_policy')</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    <footer class="sidebar-footer">
        <ul class="nav metismenu" id="sidebar-footer">
            <li>
                <a href="{{ route('home') }}">
                    <i class="fa fa-copyright" aria-hidden="true"></i> {{ date('Y') }} {{ config('app.title') }}
                </a>
            </li>
        </ul>
    </footer>
</aside>
<div class="sidebar-overlay" id="sidebar-overlay"></div>
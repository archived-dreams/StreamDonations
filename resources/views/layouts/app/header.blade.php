<header class="header">
    <div class="header-block header-block-collapse hidden-lg-up">
        <button class="collapse-btn" id="sidebar-collapse-btn">
            <i class="fa fa-bars"></i>
    	</button> 
    </div>
    {{-- Title --}}
    <div class="header-block pull-right page-header-title">
        <h5>
            @yield('title', $title)
        </h5>
    </div>
    {{-- Buy IT --}}
    <div class="header-block header-block-buttons" style="display: none;">
        <a href="https://codecanyon.net/item/stream-tips/20146141?ref=IvanDanilov" class="btn btn-sm header-btn" target="_blank">
            <i class="fa fa-cloud-download"></i>
            <span>Buy it</span>
        </a>
    </div>
    {{-- Right --}}
    <div class="header-block header-block-nav">
        <ul class="nav-profile">
            {{-- Balance --}}
            {{--<li class="notifications new"> 
                <a href="{{ route('payouts') }}">
                    {!! Auth::user()->format_balance() !!}
                </a>
            </li>--}}
            {{-- User --}}
            <li class="profile dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="img" style="background-image: url('{{ Auth::user()->avatar }}')"> </div>
                    <span class="name"> {{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu profile-dropdown-menu" aria-labelledby="dropdownMenu1">
                    {{-- Settings --}}
                    <a href="{{ route('settings.account') }}" class="dropdown-item">
                        <i class="fa fa-sliders icon"></i> @lang('header.settings')
                    </a>
                    {{-- Logout --}}
                    <a href="{{ route('auth.logout') }}" class="dropdown-item">
                        <i class="fa fa-power-off icon"></i> @lang('header.logout')
                    </a>
                </div>
            </li>
        </ul>
    </div>
</header>
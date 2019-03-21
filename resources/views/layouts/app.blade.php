<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    {{-- Head --}}
    @include('layouts.app.head')
</head>
<body>
    <div class="main-wrapper">
        <div class="app" id="app">
            {{-- Header --}}
            @include('layouts.app.header')
            {{-- Sidebar --}}
            @include('layouts.app.sidebar')
            {{-- Content --}}
            <article class="content dashboard-page">
                <section class="section">
                    <div class="row sameheight-container">
                        <div class="col-md-12 stats-col">
                            @include('layouts.app.messages')
                            @yield('content')
                        </div>
                    </div>
                </section>
            </article>
        </div>
    </div>
    {{-- Foot --}}
    @include('layouts.app.foot')
</body>
</html>
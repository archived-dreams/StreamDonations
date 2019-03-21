@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/vendor/morrisjs/morris.css') }}" rel="stylesheet">
@endsection

@section('content')


<section class="section">
    <div class="row sameheight-container">
        {{-- Stats --}}
        <div class="col col-xs-12 col-sm-12 col-md-6 col-xl-5 stats-col">
            <div class="card sameheight-item stats" data-exclude="xs" style="height: 328px;">
                <div class="card-block">
                    <div class="title-block">
                        <h4 class="title"> @lang("apanel.statistics.title") </h4>
                    </div>
                    {{-- Counters --}}
                    <div class="row row-sm stats-container">
                        {{-- Messages --}}
                        <div class="col-xs-12 col-sm-6 stat-col">
                            <div class="stat-icon"> <i class="fa fa-bell-o"></i> </div>
                            <div class="stat">
                                <div class="value">{{ $counters['messages'] }}</div>
                                <div class="name">@lang("apanel.statistics.counters.messages")</div>
                            </div>
                            <progress class="progress stat-progress" value="{{ $counters['messages'] }}" max="{{ $counters['messages'] }}">
            					<div class="progress">
            						<span class="progress-bar" style="width: 100%;"></span>
            					</div>
            				</progress>
                        </div>
                        {{-- Messages (Paid) --}}
                        <div class="col-xs-12 col-sm-6 stat-col">
                            <div class="stat-icon"> <i class="fa fa-bell"></i> </div>
                            <div class="stat">
                                <div class="value">{{ $counters['paid_messages'] }}</div>
                                <div class="name">@lang("apanel.statistics.counters.paid_messages")</div>
                            </div>
                            <progress class="progress stat-progress" value="{{ $counters['paid_messages'] }}" max="{{ $counters['messages'] }}">
            					<div class="progress">
            						<span class="progress-bar" style="width: 100%;"></span>
            					</div>
            				</progress>
                        </div>
                        
                        {{-- Amount --}}
                        <div class="col-xs-12 col-sm-6 stat-col">
                            <div class="stat-icon"> <i class="fa fa-credit-card"></i> </div>
                            <div class="stat">
                                <div class="value">{{ number_format($counters['amount'], 2, '.', ' ') }} {!! config('app.currency_icon') !!}</div>
                                <div class="name">@lang("apanel.statistics.counters.amount")</div>
                            </div>
                            <progress class="progress stat-progress" value="{{ round($counters['amount']) }}" max="{{ round($counters['amount'] + $counters['commission']) }}">
            					<div class="progress">
            						<span class="progress-bar" style="width: 100%;"></span>
            					</div>
            				</progress>
                        </div>
                        {{-- Commission --}}
                        <div class="col-xs-12 col-sm-6 stat-col">
                            <div class="stat-icon"> <i class="fa fa-plus"></i> </div>
                            <div class="stat">
                                <div class="value">{{ number_format($counters['commission'], 2, '.', ' ') }} {!! config('app.currency_icon') !!}</div>
                                <div class="name">@lang("apanel.statistics.counters.commission")</div>
                            </div>
                            <progress class="progress stat-progress" value="{{ round($counters['commission']) }}" max="{{ round($counters['amount']) }}">
            					<div class="progress">
            						<span class="progress-bar" style="width: 100%;"></span>
            					</div>
            				</progress>
                        </div>
						
						{{-- Refunds --}}
                        <div class="col-xs-12 col-sm-6 stat-col">
                            <div class="stat-icon"> <i class="fa fa-meh-o"></i> </div>
                            <div class="stat">
                                <div class="value">{{ $counters['refunds'] }}</div>
                                <div class="name">@lang("apanel.statistics.counters.refunds")</div>
                            </div>
                            <progress class="progress stat-progress" value="{{ round($counters['refunds']) }}" max="{{ $counters['messages'] }}">
            					<div class="progress">
            						<span class="progress-bar" style="width: 100%;"></span>
            					</div>
            				</progress>
                        </div>
						{{-- Refund amount --}}
                        <div class="col-xs-12 col-sm-6 stat-col">
                            <div class="stat-icon"> <i class="fa fa-minus"></i> </div>
                            <div class="stat">
                                <div class="value">{{ number_format($counters['amount_refunds'], 2, '.', ' ') }} {!! config('app.currency_icon') !!}</div>
                                <div class="name">@lang("apanel.statistics.counters.amount_refunds")</div>
                            </div>
                            <progress class="progress stat-progress" value="{{ round($counters['amount_refunds']) }}" max="{{ $counters['messages'] }}">
            					<div class="progress">
            						<span class="progress-bar" style="width: 100%;"></span>
            					</div>
            				</progress>
                        </div>
						
                        
                        {{-- Users --}}
                        <div class="col-xs-12 col-sm-6 stat-col">
                            <div class="stat-icon"> <i class="fa fa-user-o"></i> </div>
                            <div class="stat">
                                <div class="value">{{ $counters['users'] }}</div>
                                <div class="name">@lang("apanel.statistics.counters.users")</div>
                            </div>
                            <progress class="progress stat-progress" value="{{ $counters['users'] }}" max="{{ $counters['users'] }}">
            					<div class="progress">
            						<span class="progress-bar" style="width: 100%;"></span>
            					</div>
            				</progress>
                        </div>
                        
                        {{-- Users (Today) --}}
                        <div class="col-xs-12 col-sm-6 stat-col">
                            <div class="stat-icon"> <i class="fa fa-user-plus"></i> </div>
                            <div class="stat">
                                <div class="value">{{ $counters['today_users'] }}</div>
                                <div class="name">@lang("apanel.statistics.counters.today_users")</div>
                            </div>
                            <progress class="progress stat-progress" value="{{ $counters['today_users'] }}" max="{{ $counters['users'] }}">
            					<div class="progress">
            						<span class="progress-bar" style="width: 100%;"></span>
            					</div>
            				</progress>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Message Charts --}}
        <div class="col col-xs-12 col-sm-12 col-md-6 col-xl-7 history-col">
            <div class="card sameheight-item" data-exclude="xs" style="height: 328px;">
                <div class="card-header card-header-sm bordered">
                    <div class="header-block">
                        <h3 class="title">@lang("apanel.statistics.message_statistics")</h3>
                    </div>
                    <ul class="nav nav-tabs pull-right" role="tablist">
                        <li class="nav-item"> <a class="nav-link active" href="#amount-statistics" role="tab" data-toggle="tab">@lang("apanel.statistics.amount")</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#commission-statistics" role="tab" data-toggle="tab">@lang("apanel.statistics.commission")</a> </li>
                    </ul>
                </div>
                <div class="card-block">
                    <div class="tab-content">
                        {{-- Amount --}}
                        <div role="tabpanel" class="tab-pane active fade in" id="amount-statistics">
                            <p class="title-description"> @lang("apanel.statistics.amount_info") </p>
                            <canvas id="amountChart" style="width: 100%; height: 300px;"></canvas>
                        </div>
                        {{-- Comission --}}
                        <div role="tabpanel" class="tab-pane fade" id="commission-statistics">
                            <p class="title-description"> @lang("apanel.statistics.commission_info") </p>
                            <canvas id="commissionChart" style="width: 100%; height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.1.1/Chart.min.js"></script>
    <script>
        $(function() {
            var options = {
                scaleShowGridLines : true,
                scaleGridLineColor : "rgba(75, 54, 124, 0.05)",
                scaleGridLineWidth : 1,
                scaleShowHorizontalLines: true,
                scaleShowVerticalLines: true,
                bezierCurve : true,
                bezierCurveTension : 0.4,
                pointDot : true,
                pointDotRadius : 4,
                pointDotStrokeWidth : 1,
                pointHitDetectionRadius : 20,
                datasetStroke : true,
                responsive: true,
                datasetStrokeWidth : 2,
                datasetFill : true,
                legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
                scaleLabel : "<%= number_format(value, 2, '.', '') %>",
                tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= number_format(value, 2, '.', '') %> {{ strtoupper(config('app.currency')) }}",
                multiTooltipTemplate: "<%= number_format(value, 2, '.', '') %>{{ strtoupper(config('app.currency')) }}",
            };

	        var data = {
	            labels: {!! json_encode($messageDates) !!},
                datasets: [{
                    label: "@lang('apanel.statistics.message_statistics')'",
                    fillColor: "rgba(75, 54, 124, 0.2)",
                    strokeColor: "rgba(75, 54, 124, 1)",
                    pointColor: "rgba(75, 54, 124, 1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(75, 54, 124, 1)"
                }]
            };
            
            // Amount
            data.datasets[0].data = {!! json_encode($messageStatistics['amount']) !!}; 
            var ctx = $("#amountChart")[0].getContext("2d");
            var amountChart = new Chart(ctx).Line(data, options);  
            // Comission 
            $('[href="#commission-statistics"]').click(function() {
                if ($(this).is('[data-chart]')) return;
                    $(this).attr('data-chart', true);
                setTimeout(function() {
                    data.datasets[0].data = {!! json_encode($messageStatistics['commission']) !!};
                    var ctx = $("#commissionChart")[0].getContext("2d");
                    var commissionChart = new Chart(ctx).Line(data, options);
                }, 250);
            });
        });
    </script>
@endsection
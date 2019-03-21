@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/vendor/morrisjs/morris.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h5>
                @lang("dashboard.message_statistics")
            </h5>
        </div>
        <div class="panel-body">
            <canvas id="donationChart" style="width: 100%; height: 300px;"></canvas>
        </div>
    </div>

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
                    label: "@lang('dashboard.message_statistics')",
                    fillColor: "rgba(75, 54, 124, 0.2)",
                    strokeColor: "rgba(75, 54, 124, 1)",
                    pointColor: "rgba(75, 54, 124, 1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(75, 54, 124, 1)",
                    data: {!! json_encode($messageStatistics) !!}
                }]
            };
           
            var ctx = $("#donationChart").get(0).getContext("2d");
            var donationChart = new Chart(ctx).Line(data, options);
        });
    </script>
@endsection

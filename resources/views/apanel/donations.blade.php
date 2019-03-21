@extends('layouts.app')

@section('css')
    <style>
        @media screen and (max-width: 480px) { 
            #donationTable {
                margin-left: -30px !important;
            }
        }
    </style>
@endsection

@section('content')

    {{-- Messages --}}
    <table id="donationTable" class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>@lang('donations.home.updated_at')</th>
            <th>@lang('donations.home.status')</th>
            <th>@lang('donations.home.billing_system')</th>
            <th>@lang('apanel.donations.user_id')</th>
            <th>@lang('donations.home.name')</th>
            <th>@lang('donations.home.amount')</th>
            <th>@lang('donations.home.message')</th>
            <th>#</th>
        </tr>
        </thead>
    </table>
    
@endsection

@section('scripts')
    <script>
        var donationTable;
        $(function() {
                
            donationTable = $('#donationTable').DataTable({
                serverSide: true,
                processing: true,
                iDisplayLength: -1,
                bAutoWidth: false,
                bScrollAutoCss: true,
                ajax: `{{ route('apanel.donations.data') }}`,
                columns: [
                    { data: "updated_at" },
                    {
                        data: "status",
                        sortable: true,
                        render: function(data) {
                            var statuses = JSON.parse(`{!! json_encode(trans('donations.home.statuses')) !!}`);
                            var color = 'muted';
                            if (data == 'success')
                                color = 'success';
                            else if (data == 'refund')
                                color = 'danger';
                            return `<span class="text-${color}">${statuses[data]}</span>`;
                        }
                    },
                    { data: "billing_system" },
                    {
                        data: "user_id",
                        render: function(data) {
                            return htmlspecialchars_decode(data);
                        }
                    },
                    { 
                        data: "name",
                        sortable: false,
                        render: function(data) {
                            return `<a href="#" onclick="donationTable.search($(this).text().trim()).draw();">${data}</a>`;
                        }
                        
                    },
                    { 
                        data: "amount", 
                        render: function (data, type, full, meta) {
                            var html = `<span class="text-success">${data} {!! config('app.currency_icon') !!}</span> 
                                        <sup class="text-muted">-${data} {!! config('app.currency_icon') !!}</sup>`;
                            return html;
                        }
                    },
                    { 
                        data: "message", 
                        render: function (data, type, full, meta) {
                            return htmlspecialchars_decode(data);
                        }
                    },
                    { 
                        data: "id", 
                        render: function ( data, type, full, meta ) {
                            return data;
                        }
                    }
                ]
            });

        });
    </script>
@endsection
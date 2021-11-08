@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="col-md-2 pull-right">
        <div class="form-group">
            <label>Periode</label>
            <input id="periode" class="form-control datepicker text-center" type="text">
        </div>

    </div>
    <div class="col-md-4">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Pendapatan</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="chart-revenue" height="210px"></canvas>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        var periode = $('#periode');
        $(function () {
            periode.datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'mm-yy',
                onClose: function(dateText, inst) {
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                    generateGraph();
                }
            });
            periode.datepicker('setDate', new Date());
            generateGraph();
        });
        var chartRevenue = new Chart($('#chart-revenue'), {
            type: 'doughnut',
            data: {},
            options: {
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            let label = data.labels[tooltipItem.index];
                            return label + " : " + numberFormat(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]);
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        fontSize: 10,
                    }
                }
            }
        });
        function generateGraph() {
            alert('generate');
            var formData = new FormData();
            formData.append('_token', '{{csrf_token()}}');
            formData.append('periode', periode.val());
            $.ajax({
                type: 'POST',
                url: '{{route('dashboard.data')}}',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    chartRevenue.data = data.service_revenue;
                    alert(data.service_revenue);
                },
                error: function (request, status, error) {
                    // console.log(request.responseText);
                }
            })
        }
        periode.change(function () {
            generateGraph()
        });
    </script>
@endpush

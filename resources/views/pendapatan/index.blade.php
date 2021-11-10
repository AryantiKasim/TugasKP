<?php
/**
 * Created by PhpStorm.
 * User: AryantiKasim
 * Date: 27-Oct-21
 * Time: 20:59
 */
?>

@extends('adminlte::page')

@section('title', 'Pendapatan')

@section('content_header')
    <h1 class="m-0 text-dark">Pendapatan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('pendapatan.create')}}" class="btn btn-success mb-2">
                        Tambah
                    </a>
                    <div class="col-md-3 form-group">
                        <label>Date:</label>
                        <input class="form-control" size="4" type="text" value="{{$periode}}" maxlength="7"
                               name="periode"
                               id="periode" onchange="refresh()">
                    </div>

                    <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="table">
                        <thead>
                        <tr>
                            <th data-priority="0" width="10px">No.</th>
                            <th data-priority="1">Unit</th>
                            <th data-priority="2">Lokasi</th>
                            <th data-priority="3">Pelayaran</th>
                            <th data-priority="4">Call Kapal</th>
                            <th data-priority="5">GT Kapal</th>
                            <th data-priority="6">Pendapatan Pandu</th>
                            <th data-priority="7">Pendapatan Pandu Standby</th>
                            <th data-priority="8">Pendapatan Tunda</th>
                            <th data-priority="9">Pendapatan Tunda Kawal</th>
                            <th data-priority="10">Pendapatan Kepil</th>
                            <th data-priority="11">Pendapatan Kapal Patrol</th>
                            <th data-priority="12">Pendapatan Tunda Standby</th>
                            <th data-priority="13">Action</th>
                        </tr>
                        </thead>
                        {{--<tbody>--}}
                        {{--@foreach($pendapatans as $key => $pendapatan)--}}
                            {{--<tr>--}}
                                {{--<td>{{$key+1}}</td>--}}
                                {{--<td>{{$pendapatan->id_unit}}</td>--}}
                                {{--<td>{{$pendapatan->id_lokasi}}</td>--}}
                                {{--<td>{{$pendapatan->id_pelayaran}}</td>--}}
                                {{--<td>{{$pendapatan->call_kapal}}</td>--}}
                                {{--<td>{{$pendapatan->gt_kapal}}</td>--}}
                                {{--<td>{{$pendapatan->pnd_pandu}}</td>--}}
                                {{--<td>{{$pendapatan->pnd_pandu_standby}}</td>--}}
                                {{--<td>{{$pendapatan->pnd_tunda}}</td>--}}
                                {{--<td>{{$pendapatan->pnd_tunda_kawal}}</td>--}}
                                {{--<td>{{$pendapatan->pnd_kepil}}</td>--}}
                                {{--<td>{{$pendapatan->pnd_kpl_patrol}}</td>--}}
                                {{--<td>{{$pendapatan->pnd_tunda_standby}}</td>--}}
                                {{--<td>--}}
                                    {{--<a href="{{route('pendapatan.edit', $pendapatan)}}" class="btn btn-primary btn-xs">--}}
                                        {{--Edit--}}
                                    {{--</a>--}}
                                    {{--<a href="{{route('pendapatan.destroy', $pendapatan)}}"--}}
                                       {{--onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">--}}
                                        {{--Delete--}}
                                    {{--</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                        {{--</tbody>--}}
                    </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <form action="" id="delete-form" method="post">
        @method('delete')
        @csrf
    </form>
    <script>
        var periode = $("#periode").datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'mm-yy',
            onClose: function(dateText, inst) {
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                refresh()
            }
            // autoclose: true,
            // format: "mm-yyyy",
            // startView: "months",
            // minViewMode: "months"
        });

        var nowD = '{{ date('Y-m-d H:i:s') }}';
        var table = $('#table').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            colReorder: true,
            ajax: '{{url('/pendapatan/data')}}/' + periode.val(),
            columns: [
                {data: 'number', orderable: false, searchable: false},
                {data: 'unit'},
                {data: 'lokasi'},
                {data: 'pelayaran'},
                {data: 'call_kapal'},
                {data: 'gt_kapal'},
                {data: 'pnd_pandu'},
                {data: 'pnd_pandu_standby'},
                {data: 'pnd_tunda'},
                {data: 'pnd_tunda_kawal'},
                {data: 'pnd_kepil'},
                {data: 'pnd_kpl_patrol'},
                {data: 'pnd_tunda_standby'},
                {data: 'action', orderable: false, searchable: false}
            ],
            lengthMenu: [[10, 25, 50,100, 200, - 1], [10, 25, 50, 100, 200, "All"]],
            dom: "<'row'<'col-sm-3'B><'col-sm-2'l><'col-sm-7'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            colvis: { text:'Set Columns'},
            buttons: [
                {
                    extend : 'print',
                    title : document.title,
                    messageBottom : 'Printed on ' + nowD,
                    exportOptions: {
                        columns: 'th:not(.no-print)'
                    }
                },
                {
                    extend : 'excelHtml5',
                    filename : document.title +' '+nowD,
                    title : document.title,
                    messageBottom : 'Export on ' + nowD,
                    exportOptions: {
                        columns: 'th:not(.no-print)'
                    }
                },
                {
                    extend : 'pdfHtml5',
                    filename : document.title +' '+nowD,
                    title : document.title,
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    messageBottom : 'Printed on ' + nowD,
                    exportOptions: {
                        columns: 'th:not(.no-print)'
                    }
                },
                {
                    extend: 'colvis',
                    text:'Set Columns',
                }
            ]
        });

        function notificationBeforeDelete(event, el) {
            event.preventDefault();
            if (confirm('Apakah anda yakin akan menghapus data ? ')) {
                $("#delete-form").attr('action', $(el).attr('href'));
                $("#delete-form").submit();
            }
        }

        function refresh() {
            table.ajax.url('{{url('/pendapatan/data')}}/' + periode.val()).load();
        }
    </script>
@endpush

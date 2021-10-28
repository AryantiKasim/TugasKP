<?php
/**
 * Created by PhpStorm.
 * User: AryantiKasim
 * Date: 27-Oct-21
 * Time: 20:59
 */
?>

@extends('adminlte::page')

@section('title', 'List User')

@section('content_header')
    <h1 class="m-0 text-dark">Pendapatan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <a href="{{route('pendapatan.create')}}" class="btn btn-primary mb-2">
                        Tambah
                    </a>

                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Unit</th>
                            <th>Lokasi</th>
                            <th>Pelayaran</th>
                            <th>Call Kapal</th>
                            <th>GT Kapal</th>
                            <th>Pendapatan Pandu</th>
                            <th>Pendapatan Pandu Standby</th>
                            <th>Pendapatan Tunda</th>
                            <th>Pendapatan Tunda Kawal</th>
                            <th>Pendapatan Kepil</th>
                            <th>Pendapatan Kapal Patrol</th>
                            <th>Pendapatan Tunda Standby</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pendapatans as $key => $pendapatan)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$pendapatan->id_unit}}</td>
                                <td>{{$pendapatan->id_lokasi}}</td>
                                <td>{{$pendapatan->id_pelayaran}}</td>
                                <td>{{$pendapatan->call_kapal}}</td>
                                <td>{{$pendapatan->gt_kapal}}</td>
                                <td>{{$pendapatan->pnd_pandu}}</td>
                                <td>{{$pendapatan->pnd_pandu_standby}}</td>
                                <td>{{$pendapatan->pnd_tunda}}</td>
                                <td>{{$pendapatan->pnd_tunda_kawal}}</td>
                                <td>{{$pendapatan->pnd_kepil}}</td>
                                <td>{{$pendapatan->pnd_kpl_patrol}}</td>
                                <td>{{$pendapatan->pnd_tunda_standby}}</td>
                                <td>
                                    <a href="{{route('pendapatan.edit', $pendapatan)}}" class="btn btn-primary btn-xs">
                                        Edit
                                    </a>
                                    <a href="{{route('pendapatan.destroy', $pendapatan)}}" onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

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
        $('#example2').DataTable({
            "responsive": true,
        });

        function notificationBeforeDelete(event, el) {
            event.preventDefault();
            if (confirm('Apakah anda yakin akan menghapus data ? ')) {
                $("#delete-form").attr('action', $(el).attr('href'));
                $("#delete-form").submit();
            }
        }

    </script>
@endpush
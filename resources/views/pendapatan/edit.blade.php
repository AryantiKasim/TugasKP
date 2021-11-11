<?php
/**
 * Created by PhpStorm.
 * User: AryantiKasim
 * Date: 27-Oct-21
 * Time: 20:59
 */
?>
@extends('adminlte::page')

@section('title', 'Edit Data Pendapatan')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Data Pendapatan</h1>
@stop

@section('content')
    <form action="{{route('pendapatan.update', $pendapatan)}}" method="post">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="id_unit">Unit</label>
                            <select class="form-control col-md-4" name="id_unit">
                                <option id="">Pilih Unit</option>
                                @foreach($units as $unit)
                                @if(old('id_unit', $pendapatan->id_unit) == $unit->id)
                                    <option value="{{$unit->id}}" selected>{{$unit->nama}}</option>
                                @else
                                    <option value="{{$unit->id}}">{{$unit->nama}}</option>
                                @endif
                                @endforeach
                            </select>

                            <label for="id_lokasi">Lokasi</label>
                            <select class="form-control col-md-4" name="id_lokasi">
                                <option id="">Pilih Lokasi</option>
                                @foreach($lokasis as $lokasi)
                                @if(old('id_lokasi', $pendapatan->id_lokasi) == $lokasi->id)
                                    <option value="{{$lokasi->id}}" selected>{{$lokasi->nama}}</option>
                                @else
                                    <option value="{{$lokasi->id}}">{{$lokasi->nama}}</option>
                                @endif
                                @endforeach
                            </select>

                            <label for="id_pelayaran">Pelayaran</label>
                            <select class="form-control col-md-4" name="id_pelayaran">
                                <option id="">Pilih Jenis Pelayaran</option>
                                @foreach($pelayarans as $pelayaran)
                                @if(old('id_pelayaran', $pendapatan->id_pelayaran) == $pelayaran->id)
                                    <option value="{{$pelayaran->id}}" selected>{{$pelayaran->jenis_pelayaran}}</option>
                                @else
                                    <option value="{{$pelayaran->id}}">{{$pelayaran->jenis_pelayaran}}</option>
                                @endif
                                @endforeach
                            </select>

                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <input type="text" class="form-control col-md-4"
                                name="bulan" value="{{$pendapatan->bulan ?? old('bulan')}}">
                            </div>

                            <label for="call_kapal">Call Kapal</label>
                            <input type="number" class="form-control col-md-4"
                            name="call_kapal" value="{{$pendapatan->call_kapal ?? old('call_kapal')}}">

                            <label for="gt_kapal">GT Kapal</label>
                            <input type="number" class="form-control col-md-4"
                            name="gt_kapal" value="{{$pendapatan->gt_kapal ?? old('gt_kapal')}}">

                            <label for="pnd_pandu">Pendapatan Pandu</label>
                            <input type="number" class="form-control col-md-4"
                            name="pnd_pandu" value="{{$pendapatan->pnd_pandu ?? old('pnd_pandu')}}">

                            <label for="pnd_pandu_standby">Pendapatan Pandu Standby</label>
                            <input type="number" class="form-control col-md-4"
                            name="pnd_pandu_standby" value="{{$pendapatan->pnd_pandu_standby ?? old('pnd_pandu_standby')}}">

                            <label for="pnd_tunda">Pendapatan Tunda</label>
                            <input type="number" class="form-control col-md-4"
                            name="pnd_tunda" value="{{$pendapatan->pnd_tunda ?? old('pnd_tunda')}}">

                            <label for="pnd_tunda_kawal">Pendapatan Tunda Kawal</label>
                            <input type="number" class="form-control col-md-4"
                            name="pnd_tunda_kawal" value="{{$pendapatan->pnd_tunda_kawal ?? old('pnd_tunda_kawal')}}">

                            <label for="pnd_kepil">Pendapatan Kepil</label>
                            <input type="number" class="form-control col-md-4"
                            name="pnd_kepil" value="{{$pendapatan->pnd_kepil ?? old('pnd_kepil')}}">

                            <label for="pnd_kpl_patrol">Pendapatan Kapal Patrol</label>
                            <input type="number" class="form-control col-md-4"
                            name="pnd_kpl_patrol" value="{{$pendapatan->pnd_kpl_patrol ?? old('pnd_kpl_patrol')}}">

                            <label for="pnd_tunda_standby">Pendapatan Tunda Standby</label>
                            <input type="number" class="form-control col-md-4"
                            name="pnd_tunda_standby" value="{{$pendapatan->pnd_tunda_standby ?? old('pnd_tunda_standby')}}">
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{route('pendapatan.index')}}" class="btn btn-default">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

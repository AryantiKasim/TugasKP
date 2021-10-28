<?php

namespace App\Http\Controllers;

use App\Lokasi;
use App\Pelayaran;
use App\Pendapatan;
use App\Unit;
use Illuminate\Http\Request;

class PendapatanController extends Controller
{
    public function index ()
    {
        $pendapatans = Pendapatan::all();
        return view('pendapatan.index', [
            'pendapatans' => $pendapatans
        ]);
    }

    public function create ()
    {
        $units = Unit::all();
        $pelayarans = Pelayaran::all();
        $lokasis = Lokasi::all();
        return view('pendapatan.create', [
            'units' => $units,
            'pelayarans' => $pelayarans,
            'lokasis' => $lokasis
        ]);

    }

    public function store (Request $request)
    {
        $request->validate([
            'id_unit' => 'required',
            'id_lokasi' => 'required',
            'id_pelayaran' => 'required',
            'bulan' => 'required',
            'call_kapal' => 'required',
            'gt_kapal' => 'required',
            'pnd_pandu' => 'required',
            'pnd_pandu_standby' => 'required',
            'pnd_tunda' => 'required',
            'pnd_tunda_kawal' => 'required',
            'pnd_kepil' => 'required',
            'pnd_kpl_patrol' => 'required',
            'pnd_tunda_standby' => 'required',

        ]);
//        $array = $request->only([
//            'id_unit', 'id_pelayaran', 'id_lokasi', 'bulan', 'call_kapal', 'gt_kapal', 'pnd_pandu', 'pnd_pandu_standby', 'pnd_tunda', 'pnd_tunda_kawal', 'pnd_kepil', 'pnd_kpl_patrol', 'pnd_tunda_standby'
//        ]);
//        $pendapatan = Pendapatan::create($array);
        $pendapatan = new Pendapatan();

        $pendapatan->id_unit = $request->id_unit;
        $pendapatan->id_lokasi = $request->id_lokasi;
        $pendapatan->id_pelayaran = $request->id_pelayaran;
        $pendapatan->bulan = $request->bulan;
        $pendapatan->call_kapal = $request->call_kapal;
        $pendapatan->gt_kapal = $request->gt_kapal;
        $pendapatan->pnd_pandu = $request->pnd_pandu;
        $pendapatan->pnd_pandu_standby = $request->pnd_pandu_standby;
        $pendapatan->pnd_tunda = $request->pnd_tunda;
        $pendapatan->pnd_tunda_kawal = $request->pnd_tunda_kawal;
        $pendapatan->pnd_kepil = $request->pnd_kepil;
        $pendapatan->pnd_kpl_patrol = $request->pnd_kpl_patrol;
        $pendapatan->pnd_tunda_standby = $request->pnd_tunda_standby;



        $pendapatan->save();

        return redirect()->route('pendapatan.index')
            ->with('success_message', 'Berhasil menambah data');
    }

    public function show ($id)
    {

    }

    public function edit ($id)
    {

    }

    public function update (Request $request, $id)
    {

    }

    public function destroy (Request $request, $id)
    {

    }
}

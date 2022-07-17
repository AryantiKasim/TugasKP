<?php

namespace App\Http\Controllers;

use App\Lokasi;
use App\Pelayaran;
use App\Pendapatan;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;

class PendapatanController extends Controller
{
    public function index()
    {
        $periode = date("m-Y");
        $pendapatans = Pendapatan::all();
        return view('pendapatan.index', [
            'pendapatans' => $pendapatans,
            'periode' => $periode
        ]);
    }

    public function data(DataTables $dataTables, $periode)
    {
        $datas = DB::table('pendapatans')
            ->join('lokasis', 'lokasis.id', '=', 'pendapatans.id_lokasi')
            ->join('pelayarans', 'pelayarans.id', '=', 'pendapatans.id_pelayaran')
            ->join('units', 'units.id', '=', 'pendapatans.id_unit')
            ->select([
                'pendapatans.id',
                'bulan',
                'lokasis.nama as lokasi',
                'pelayarans.jenis_pelayaran as pelayaran',
                'units.nama as unit',
                'call_kapal',
                'gt_kapal',
                'pnd_pandu',
                'pnd_pandu_standby',
                'pnd_tunda',
                'pnd_tunda_kawal',
                'pnd_kepil',
                'pnd_kpl_patrol',
                'pnd_tunda_standby',
                'laba'
            ])
            ->where('bulan', $periode)
            ->get();

        $number = 1;
        foreach ($datas as $data) {
            $data->number = $number;
            $number = $number + 1;
        }

        return $dataTables->collection($datas)
            ->addColumn('number', function ($data) {
                return $data->number;
            })
            ->addColumn('action', function ($data) {
                $btn = '';
                $btn .= '<a href="' . route('pendapatan.edit', $data->id) . '" class="btn btn-primary btn-xs">Edit</a>';
                $btn .= '<a href="' . route('pendapatan.destroy', $data->id) . '" onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">Delete</a>';
                return $btn;
            })
            ->make(true);
    }

    public function create()
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

    public function store(Request $request)
    {
        Log::debug("test");
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
            'laba' => 'required',
        ]);
//        $array = $request->only([
//            'id_unit', 'id_pelayaran', 'id_lokasi', 'bulan', 'call_kapal', 'gt_kapal', 'pnd_pandu', 'pnd_pandu_standby', 'pnd_tunda', 'pnd_tunda_kawal', 'pnd_kepil', 'pnd_kpl_patrol', 'pnd_tunda_standby'
//        ]);
//        $pendapatan = Pendapatan::create($array);

        try {
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
            $pendapatan->laba = $request->laba;


            $pendapatan->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return redirect()->route('pendapatan.index')
            ->with('success_message', 'Berhasil menambah data');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $pendapatan = Pendapatan::find($id);
        $units = Unit::all();
        $pelayarans = Pelayaran::all();
        $lokasis = Lokasi::all();
        if(!$pendapatan) return redirect()->route('pendapatan.index')
        ->with('error.message', 'Data dengan id'.$id.'tidak ditemukan');
        return view('pendapatan.edit', [
            'pendapatan' => $pendapatan,
            'units' => $units,
            'pelayarans' => $pelayarans,
            'lokasis' => $lokasis
        ]);

        // $pendapatan = Pendapatan::find($id);
        // if ($pendapatan) $pendapatan->edit();
        // return redirect()->route('pendapatan.edit')
        //     ->with('success_message', 'Berhasil mengedit data pendapatan');
    }

    public function update(Request $request, $id)
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
            'laba' => 'required',

        ]);

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
        $pendapatan->laba = $request->laba;


        $pendapatan->save();

        return redirect()->route('pendapatan.index')
            ->with('success_message', 'Berhasil mengubah data');
    }

    public function destroy(Request $request, $id)
    {
        $pend = Pendapatan::find($id);
        if ($pend) $pend->delete();
        return redirect()->route('pendapatan.index')
            ->with('success_message', 'Berhasil menghapus pendapatan');
    }
}

<?php

namespace App\Http\Controllers;

use App\Pendapatan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function data(Request $request)
    {
        $data_revenue = new \stdClass();
        $periode = $request->periode;

        $pandu = Pendapatan::where('periode', $periode)->sum('pnd_pandu');
        $pandu_stand_by = Pendapatan::where('periode', $periode)->sum('pnd_pandu_standby');
        $tunda = Pendapatan::where('periode', $periode)->sum('pnd_tunda');
        $tunda_kawal = Pendapatan::where('periode', $periode)->sum('pnd_tunda_kawal');
        $kepil = Pendapatan::where('periode', $periode)->sum('pnd_kepil');
        $kapal_patrol = Pendapatan::where('periode', $periode)->sum('pnd_kpl_patrol');
        $tunda_stand_by = Pendapatan::where('periode', $periode)->sum('pnd_tunda_standby');

        $category = collect([
            (object)['id' => '1', 'number' => '1', 'name' => 'Pandu', 'borderColor' => '#3c8dbc', 'backgroundColor' => 'rgb(60, 141, 188, 0.6)', 'unit' => 'Call', 'value' => $pandu, 'revenue' => $pandu],
            (object)['id' => '2', 'number' => '2', 'name' => 'Pandu Stand By', 'borderColor' => '#00a65a', 'backgroundColor' => 'rgb(0, 166, 90, 0.6)', 'unit' => 'Call', 'value' => $pandu_stand_by, 'revenue' => $pandu_stand_by],
            (object)['id' => '3', 'number' => '3','name' => 'Tunda', 'borderColor' => '#f39c12', 'backgroundColor' => 'rgb(243, 156, 18, 0.6)', 'unit' => 'Call', 'value' => $tunda, 'revenue' => $tunda],
            (object)['id' => '4', 'number' => '4','name' => 'Tunda Kawal', 'borderColor' => '#f56954', 'backgroundColor' => 'rgb(245, 105, 84, 0.6)', 'unit' => 'Call', 'value' => $tunda_kawal, 'revenue' => $tunda_kawal],
            (object)['id' => '5', 'number' => '5','name' => 'Kepil', 'borderColor' => '#00c0ef', 'backgroundColor' => 'rgb(0, 192, 239, 0.6)', 'unit' => 'Ton', 'value' => $kepil, 'revenue' => $kepil],
            (object)['id' => '6', 'number' => '5','name' => 'Kapal Patrol', 'borderColor' => '#00c0ef', 'backgroundColor' => 'rgb(123, 45, 239, 0.6)', 'unit' => 'Ton', 'value' => $kapal_patrol, 'revenue' => $kapal_patrol],
            (object)['id' => '7', 'number' => '5','name' => 'Tunda Stand By', 'borderColor' => '#00c0ef', 'backgroundColor' => 'rgb(18, 72, 239, 0.6)', 'unit' => 'Ton', 'value' => $tunda_stand_by, 'revenue' => $tunda_stand_by]
        ]);

        $data_revenue->labels = $category->pluck('name')->all();
        $data_revenue->datasets = [
            [
                'label' => 'Revenue : ',
                'data' => $category->pluck('revenue')->all(),
                'backgroundColor'=> $category->pluck('backgroundColor')->all(),
                'borderWidth' => 0,
                'hoverOffset'=> 10
            ]
        ];

        return response()->json([
            'service_revenue' => $data_revenue
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Pendapatan;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function data($periode)
    {
        $data_revenue = new \stdClass();
//        $periode = $request->periode;

        $pandu = Pendapatan::where('bulan', $periode)->sum('pnd_pandu');
        $pandu_stand_by = Pendapatan::where('bulan', $periode)->sum('pnd_pandu_standby');
        $tunda = Pendapatan::where('bulan', $periode)->sum('pnd_tunda');
        $tunda_kawal = Pendapatan::where('bulan', $periode)->sum('pnd_tunda_kawal');
        $kepil = Pendapatan::where('bulan', $periode)->sum('pnd_kepil');
        $kapal_patrol = Pendapatan::where('bulan', $periode)->sum('pnd_kpl_patrol');
        $tunda_stand_by = Pendapatan::where('bulan', $periode)->sum('pnd_tunda_standby');

        $category = collect([
            (object)['id' => '1', 'number' => '1', 'name' => 'Pandu', 'borderColor' => '#3c8dbc', 'backgroundColor' => 'rgb(60, 141, 188, 0.6)', 'unit' => 'Call', 'value' => $pandu, 'revenue' => $pandu],
            (object)['id' => '2', 'number' => '2', 'name' => 'Pandu Stand By', 'borderColor' => '#00a65a', 'backgroundColor' => 'rgb(0, 166, 90, 0.6)', 'unit' => 'Call', 'value' => $pandu_stand_by, 'revenue' => $pandu_stand_by],
            (object)['id' => '3', 'number' => '3', 'name' => 'Tunda', 'borderColor' => '#f39c12', 'backgroundColor' => 'rgb(243, 156, 18, 0.6)', 'unit' => 'Call', 'value' => $tunda, 'revenue' => $tunda],
            (object)['id' => '4', 'number' => '4', 'name' => 'Tunda Kawal', 'borderColor' => '#f56954', 'backgroundColor' => 'rgb(245, 105, 84, 0.6)', 'unit' => 'Call', 'value' => $tunda_kawal, 'revenue' => $tunda_kawal],
            (object)['id' => '5', 'number' => '5', 'name' => 'Kepil', 'borderColor' => '#00c0ef', 'backgroundColor' => 'rgb(0, 192, 239, 0.6)', 'unit' => 'Ton', 'value' => $kepil, 'revenue' => $kepil],
            (object)['id' => '6', 'number' => '5', 'name' => 'Kapal Patrol', 'borderColor' => '#00c0ef', 'backgroundColor' => 'rgb(123, 45, 239, 0.6)', 'unit' => 'Ton', 'value' => $kapal_patrol, 'revenue' => $kapal_patrol],
            (object)['id' => '7', 'number' => '5', 'name' => 'Tunda Stand By', 'borderColor' => '#00c0ef', 'backgroundColor' => 'rgb(18, 72, 239, 0.6)', 'unit' => 'Ton', 'value' => $tunda_stand_by, 'revenue' => $tunda_stand_by]
        ]);

        $data_revenue->labels = $category->pluck('name')->all();
        $data_revenue->datasets = [
            [
                'label' => 'Revenue : ',
                'data' => $category->pluck('revenue')->all(),
                'backgroundColor' => $category->pluck('backgroundColor')->all(),
                'borderWidth' => 0,
                'hoverOffset' => 10
            ]
        ];

        $data_unit = new \stdClass();

        $unit = Unit::get();

        $unit->map(function ($data) use ($periode) {
            $pend = Pendapatan::where('bulan', $periode)
                ->where('id_unit', $data->id)
                ->select([
                    DB::raw('nvl(sum(pnd_pandu), 0) AS pnd_pandu'),
                    DB::raw('nvl(sum(pnd_pandu_standby), 0) AS pnd_pandu_standby'),
                    DB::raw('nvl(sum(pnd_tunda), 0) AS pnd_tunda'),
                    DB::raw('nvl(sum(pnd_tunda_kawal), 0) AS pnd_tunda_kawal'),
                    DB::raw('nvl(sum(pnd_kepil), 0) AS pnd_kepil'),
                    DB::raw('nvl(sum(pnd_kpl_patrol), 0) AS pnd_kpl_patrol'),
                    DB::raw('nvl(sum(pnd_tunda_standby), 0) AS pnd_tunda_standby'),
                ])->first();

            if ($pend != null) {
                $data->pendapatan = $pend->pnd_pandu + $pend->pnd_pandu_standby + $pend->pnd_tunda + $pend->pnd_tunda_kawal + $pend->pnd_kepil + $pend->pnd_kpl_patrol + $pend->pnd_tunda_standby;
                $color = $this->getRandomColor();
                $data->borderColor = $color->hex;
                $data->backgroundColor = 'rgb(' . $color->r . ', ' . $color->g . ', ' . $color->b . ', 0.7)';
            }

            return $data;
        });

        $data_unit->labels = $unit->pluck('nama')->all();
        $data_unit->datasets = [
            [
                'label' => 'Revenue : ',
                'data' => $unit->pluck('pendapatan')->all(),
                'backgroundColor' => $unit->pluck('backgroundColor')->all(),
                'borderWidth' => 0,
                'hoverOffset' => 10
            ],
        ];

        $monthly_revenue = new \stdClass();
        $monthly_profit = new \stdClass();
        $tahun = substr($periode, -4);
        $bulan = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $revenueBulanan = [];
        $profitBulanan = [];
        $monthly_revenue->labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $monthly_profit->labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        foreach ($bulan as $b) {
            $pend = Pendapatan::where('bulan', $b . '-' . $tahun)
                ->select([
                    DB::raw('nvl(sum(pnd_pandu), 0) AS pnd_pandu'),
                    DB::raw('nvl(sum(pnd_pandu_standby), 0) AS pnd_pandu_standby'),
                    DB::raw('nvl(sum(pnd_tunda), 0) AS pnd_tunda'),
                    DB::raw('nvl(sum(pnd_tunda_kawal), 0) AS pnd_tunda_kawal'),
                    DB::raw('nvl(sum(pnd_kepil), 0) AS pnd_kepil'),
                    DB::raw('nvl(sum(pnd_kpl_patrol), 0) AS pnd_kpl_patrol'),
                    DB::raw('nvl(sum(pnd_tunda_standby), 0) AS pnd_tunda_standby'),
                    DB::raw('nvl(sum(laba), 0) AS laba'),
                ])->first();
            $pendapatan = $pend->pnd_pandu + $pend->pnd_pandu_standby + $pend->pnd_tunda + $pend->pnd_tunda_kawal + $pend->pnd_kepil + $pend->pnd_kpl_patrol + $pend->pnd_tunda_standby;
            array_push($revenueBulanan, $pendapatan);
            array_push($profitBulanan, $pend->laba);
        }

        $monthly_revenue->datasets = [
            [
                'data' => $revenueBulanan,
                'label' => 'Pendapatan',
                'backgroundColor' => 'rgba(60,141,188,0.9)',
                'borderColor' => 'rgba(60,141,188,0.8)',
                'pointRadius' => false,
                'pointColor' => '#3b8bba',
                'pointStrokeColor' => 'rgba(60,141,188,1)',
                'pointHighlightFill' => '#fff',
                'pointHighlightStroke' => 'rgba(60,141,188,1)',
            ]
        ];
        $monthly_profit->datasets = [
            [
                'data' => $profitBulanan,
                'label' => 'Laba',
                'backgroundColor' => 'rgba(60,141,188,0.9)',
                'borderColor' => 'rgba(60,141,188,0.8)',
                'pointRadius' => false,
                'pointColor' => '#3b8bba',
                'pointStrokeColor' => 'rgba(60,141,188,1)',
                'pointHighlightFill' => '#fff',
                'pointHighlightStroke' => 'rgba(60,141,188,1)',
            ]
        ];

        return response()->json([
            'service_revenue' => $data_revenue,
            'data_unit' => $data_unit,
            'monthly_revenue' => $monthly_revenue,
            'monthly_profit' => $monthly_profit
        ]);
    }

    public function getRandomColor()
    {
        $letters = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F');
        $cHex = '#';
        for ($i = 0; $i < 6; $i++) {
            $index = rand(0, 15);
            $cHex .= $letters[$index];
        }
        $color = new \stdClass();
        $color->hex = $cHex;
        $color->r = hexdec(substr($cHex, 1, 2));
        $color->g = hexdec(substr($cHex, 3, 2));
        $color->b = hexdec(substr($cHex, 5, 2));
        return $color;
    }
}

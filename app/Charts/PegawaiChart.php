<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class PegawaiChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\AreaChart
    {
        $data = DB::table('pegawais')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%M %Y") as month'),
                DB::raw('SUM(CASE WHEN status = "Aktif" THEN 1 ELSE 0 END) as aktif'),
                DB::raw('SUM(CASE WHEN status = "Non-Aktif" THEN 1 ELSE 0 END) as nonaktif')
            )
            ->groupBy('month')
            ->orderBy('created_at')
            ->get();

        return $this->chart->areaChart()
            ->addData('Aktif', $data->pluck('aktif')->toArray())
            ->addData('Non-Aktif', $data->pluck('nonaktif')->toArray())
            ->setXAxis($data->pluck('month')->toArray());
    }
}
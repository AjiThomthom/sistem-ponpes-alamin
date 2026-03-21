<?php

namespace App\Filament\Widgets;

use App\Models\TrxBukuKas;
use App\Models\TrxTagihanSpp;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class PemasukanSppChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Arus Kas (6 Bulan Terakhir)';
    protected static ?int $sort = 2; 

    protected function getData(): array
    {
        $pemasukanData = [];
        $pengeluaranData = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulanTarget = Carbon::now()->subMonths($i);
            $labels[] = $bulanTarget->translatedFormat('M Y');

            $sppBulanIni = TrxTagihanSpp::where('status_bayar', 'LUNAS')
                ->whereYear('CreatedDate', $bulanTarget->year)
                ->whereMonth('CreatedDate', $bulanTarget->month)
                ->sum('nominal');

            $kasMasukBulanIni = TrxBukuKas::where('jenis', 'PEMASUKAN')
                ->whereYear('tanggal', $bulanTarget->year)
                ->whereMonth('tanggal', $bulanTarget->month)
                ->sum('nominal');

            $pemasukanData[] = $sppBulanIni + $kasMasukBulanIni;

            $pengeluaranData[] = TrxBukuKas::where('jenis', 'PENGELUARAN')
                ->whereYear('tanggal', $bulanTarget->year)
                ->whereMonth('tanggal', $bulanTarget->month)
                ->sum('nominal');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pemasukan (+)',
                    'data' => $pemasukanData,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Pengeluaran (-)',
                    'data' => $pengeluaranData,
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.2)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
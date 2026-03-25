<?php

namespace App\Filament\Widgets;

use App\Models\TrxBukuKas;
use App\Models\TrxTagihanSpp;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Gunakan strtoupper agar aman dengan Case Sensitive di Ubuntu
        $totalSpp = TrxTagihanSpp::where('status_bayar', 'LUNAS')->sum('nominal');
        $pemasukanKas = TrxBukuKas::where('jenis', 'PEMASUKAN')->sum('nominal');
        $pengeluaranKas = TrxBukuKas::where('jenis', 'PENGELUARAN')->sum('nominal');
        $saldoAkhir = ($totalSpp + $pemasukanKas) - $pengeluaranKas;

        return [
            Stat::make('Total Saldo Kas', 'Rp ' . number_format($saldoAkhir, 0, ',', '.'))
                ->description('Saldo tersedia (SPP + Kas Masuk)')
                ->descriptionIcon('heroicon-m-banknotes')
                ->chart([7, 3, 10, 5, 15, 8, 20]) // Grafik mini
                ->color('success'),

            Stat::make('Pemasukan SPP', 'Rp ' . number_format($totalSpp, 0, ',', '.'))
                ->description('Total SPP Santri Lunas')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([10, 15, 8, 12, 18, 10, 15])
                ->color('info'),

            Stat::make('Total Pengeluaran', 'Rp ' . number_format($pengeluaranKas, 0, ',', '.'))
                ->description('Uang keluar dari buku kas')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([15, 10, 18, 12, 10, 15, 8])
                ->color('danger'),
        ];
    }
}
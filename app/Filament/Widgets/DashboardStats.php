<?php

namespace App\Filament\Widgets;

use App\Models\TrxBukuKas;
use App\Models\TrxTagihanSpp;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    // Gunakan static untuk semua properti standar
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalSpp = TrxTagihanSpp::where('status_bayar', 'LUNAS')->sum('nominal');
        $pemasukanKas = TrxBukuKas::where('jenis', 'PEMASUKAN')->sum('nominal');
        $pengeluaranKas = TrxBukuKas::where('jenis', 'PENGELUARAN')->sum('nominal');
        $saldoAkhir = ($totalSpp + $pemasukanKas) - $pengeluaranKas;

        return [
            Stat::make('Total Saldo Kas', 'Rp ' . number_format($saldoAkhir, 0, ',', '.'))
                ->description('Total uang tersedia saat ini')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Pemasukan SPP', 'Rp ' . number_format($totalSpp, 0, ',', '.'))
                ->description('Total SPP Santri yang sudah Lunas')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),

            Stat::make('Total Pengeluaran', 'Rp ' . number_format($pengeluaranKas, 0, ',', '.'))
                ->description('Total uang keluar dari buku kas')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
        ];
    }
}
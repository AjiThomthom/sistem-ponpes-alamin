@php
    function imageToBase64($path) {
        if (empty(trim($path))) return null;
        $fullPath = public_path($path);
        if (file_exists($fullPath) && !is_dir($fullPath)) {
            $type = pathinfo($fullPath, PATHINFO_EXTENSION);
            $data = file_get_contents($fullPath);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return null;
    }

    $logoPonpes = imageToBase64('images/logo-ponpes.png');
    $logoYayasan = imageToBase64('images/logo-yayasan.png');
    $ttdBase64 = imageToBase64('images/ttd-bendahara.png');
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Tagihan SPP</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #333; line-height: 1.4; }
        .header-table { width: 100%; border-bottom: 3px double #065f46; padding-bottom: 10px; margin-bottom: 20px; }
        .logo-cell { width: 15%; text-align: center; vertical-align: middle; }
        .text-cell { width: 70%; text-align: center; vertical-align: middle; }
        
        .header-title { font-size: 18px; font-weight: bold; color: #065f46; text-transform: uppercase; margin: 0; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data-table th { background-color: #065f46; color: white; padding: 10px; border: 1px solid #ddd; text-transform: uppercase; font-size: 10px; }
        table.data-table td { padding: 8px; border: 1px solid #ddd; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .lunas { color: #059669; font-weight: bold; }
        .belum-lunas { color: #dc2626; font-weight: bold; }
        .total-row { background-color: #f0fdf4; font-weight: bold; }

        .footer-container { margin-top: 40px; width: 100%; page-break-inside: avoid; }
        .ttd-box { float: right; width: 230px; text-align: center; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td class="logo-cell">@if($logoPonpes) <img src="{{ $logoPonpes }}" style="width: 65px;"> @endif</td>
            <td class="text-cell">
                <div style="font-weight: bold;">YAYASAN PENDIDIKAN ISLAM AL-AMIN</div>
                <div class="header-title">PONDOK PESANTREN AL-AMIN</div>
                <div style="font-size: 9px;">Jl. Industri Kp. Sempu Gardu RT.04/02 Desa Pasir Gombong, Cikarang Utara, Bekasi</div>
            </td>
            <td class="logo-cell">@if($logoYayasan) <img src="{{ $logoYayasan }}" style="width: 65px;"> @endif</td>
        </tr>
    </table>

    <h3 style="text-align: center; text-decoration: underline; text-transform: uppercase;">Laporan Rekapitulasi Tagihan SPP</h3>
    <p>Dicetak pada: <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</strong></p>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Santri</th>
                <th width="15%">Bulan/Tahun</th>
                <th width="20%">Nominal</th>
                <th width="15%">Status</th>
                <th width="15%">Tgl Lunas</th>
            </tr>
        </thead>
        <tbody>
            @php $totalLunas = 0; $totalTunggakan = 0; @endphp
            @forelse($data as $index => $item)
            @php
                if($item->status_bayar == 'LUNAS') $totalLunas += $item->nominal;
                else $totalTunggakan += $item->nominal;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td><strong>{{ $item->santri->nama_santri }}</strong></td>
                <td class="text-center">{{ $item->bulan }} {{ $item->tahun }}</td>
                <td class="text-right">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                <td class="text-center {{ $item->status_bayar == 'LUNAS' ? 'lunas' : 'belum-lunas' }}">
                    {{ $item->status_bayar }}
                </td>
                <td class="text-center">
                    {{ $item->tanggal_lunas ? \Carbon\Carbon::parse($item->tanggal_lunas)->format('d/m/Y') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Data tagihan tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" class="text-right">Total Sudah Dibayar (Lunas) :</td>
                <td colspan="3" class="text-right lunas">Rp {{ number_format($totalLunas, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="3" class="text-right">Total Belum Dibayar (Tunggakan) :</td>
                <td colspan="3" class="text-right belum-lunas">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer-container">
        <div class="ttd-box">
            <p>Bekasi, {{ date('d F Y') }}</p>
            <p>Bendahara Pesantren,</p>
            <div style="height: 60px;">
                @if($ttdBase64) <img src="{{ $ttdBase64 }}" style="max-height: 60px;"> @else <br><br> @endif
            </div>
            <p><strong>Ust. Faisal Tirta Nazmuddin, S.Pd.</strong></p>
            <p style="font-size: 9px;">+62-857-7335-3921</p>
        </div>
    </div>
</body>
</html>
@php
    // FUNGSI PENTING: Mengubah Gambar menjadi Base64 agar Tampil di PDF
    function imageToBase64($path) {
        $fullPath = public_path($path);
        
        // Cek apakah file benar-benar ada dan bukan sebuah folder
        if (file_exists($fullPath) && !is_dir($fullPath)) {
            $type = pathinfo($fullPath, PATHINFO_EXTENSION);
            $data = file_get_contents($fullPath);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return null;
    }

    // Mengambil Asset dari folder public/images/
    $logoPonpesBase64 = imageToBase64('images/logo-ponpes.png');
    $logoYayasanBase64 = imageToBase64('images/logo-yayasan.png');
    $ttdBase64 = imageToBase64('images/ttd-bendahara.png');
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Buku Kas Ponpes Al-Amin</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #333; line-height: 1.4; }
        
        /* HEADER / KOP SURAT BERLOGO (Tiga Kolom) */
        .header-container { width: 100%; border-bottom: 3px solid #065f46; padding-bottom: 10px; margin-bottom: 20px; text-align: center; }
        .logo-cell { width: 15%; text-align: center; vertical-align: middle; }
        .text-cell { width: 70%; text-align: center; vertical-align: middle; }
        
        .header-logo { width: 80px; height: auto; }
        .header-yayasan { font-size: 12px; font-weight: bold; color: #333; margin-bottom: 2px; text-transform: uppercase; }
        .header-title { font-size: 20px; font-weight: bold; color: #065f46; margin: 0; text-transform: uppercase; }
        .header-address { font-size: 11px; margin: 2px 0; }
        .header-contact { font-size: 10px; font-style: italic; color: #555; }

        .title { text-align: center; text-decoration: underline; font-weight: bold; font-size: 15px; margin-bottom: 15px; text-transform: uppercase; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data-table th { background-color: #065f46; color: white; padding: 10px; border: 1px solid #ddd; text-transform: uppercase; font-size: 10px; }
        table.data-table td { padding: 8px; border: 1px solid #ddd; vertical-align: top; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .pemasukan { color: #059669; font-weight: bold; }
        .pengeluaran { color: #dc2626; font-weight: bold; }
        
        .total-row { background-color: #f0fdf4; font-weight: bold; font-size: 12px; }
        .saldo-row { background-color: #065f46; color: white; font-weight: bold; font-size: 13px; }

        /* FOOTER / TANDA TANGAN OTOMATIS */
        .footer-container { margin-top: 40px; width: 100%; page-break-inside: avoid; }
        .ttd-box { float: right; width: 230px; text-align: center; position: relative; }
        .ttd-date { margin-bottom: 10px; }
        .ttd-image-container { height: 80px; position: relative; margin: 10px 0; }
        .ttd-image { max-height: 80px; max-width: 180px; }
        .ttd-name { font-weight: bold; text-decoration: underline; font-size: 12px; }
    </style>
</head>
<body>
    <table class="header-container">
        <tr>
            <td class="logo-cell">
                @if($logoPonpesBase64)
                    <img src="{{ $logoPonpesBase64 }}" class="header-logo" alt="Logo Ponpes">
                @else
                    <span style="color: red; font-size: 9px; font-weight: bold;">[X] logo-ponpes.png</span>
                @endif
            </td>
            
            <td class="text-cell">
                <div class="header-yayasan">YAYASAN PENDIDIKAN ISLAM AL-AMIN</div>
                <div class="header-title">PONDOK PESANTREN AL-AMIN</div>
                <div class="header-address">Jl. Industri Kp. Sempu Gardu RT.04/02 Desa Pasir Gombong, Cikarang Utara, Bekasi</div>
                <div class="header-contact">Email: admin@ponpesalamin.com | Telp: 0857-7335-3921 | Website: www.ponpesalamin.com</div>
            </td>
            
            <td class="logo-cell">
                @if($logoYayasanBase64)
                    <img src="{{ $logoYayasanBase64 }}" class="header-logo" alt="Logo Yayasan">
                @else
                    <span style="color: red; font-size: 9px; font-weight: bold;">[X] logo-yayasan.png</span>
                @endif
            </td>
        </tr>
    </table>

    <div class="title">LAPORAN REKAPITULASI BUKU KAS</div>
    <p>Dicetak pada: <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</strong> oleh Admin Pesantren</p>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th>Keterangan / Uraian Transaksi</th>
                <th width="12%">Jenis</th>
                <th width="22%">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $totalMasuk = 0; 
                $totalKeluar = 0; 
            @endphp
            @forelse($data as $index => $item)
            @php
                if($item->jenis == 'Pemasukan') $totalMasuk += $item->nominal;
                else $totalKeluar += $item->nominal;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $item->keterangan }}</td>
                <td class="text-center">{{ $item->jenis }}</td>
                <td class="text-right {{ $item->jenis == 'Pemasukan' ? 'pemasukan' : 'pengeluaran' }}">
                    {{ $item->jenis == 'Pemasukan' ? '(+) ' : '(-) ' }}
                    Rp {{ number_format($item->nominal, 0, ',', '.') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data transaksi kas untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">Total Pemasukan (Debit) :</td>
                <td class="text-right pemasukan">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="text-right">Total Pengeluaran (Kredit) :</td>
                <td class="text-right pengeluaran">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</td>
            </tr>
            <tr class="saldo-row">
                <td colspan="4" class="text-right">SALDO AKHIR :</td>
                <td class="text-right">Rp {{ number_format($totalMasuk - $totalKeluar, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer-container">
        <div class="ttd-box">
            <div class="ttd-date">Bekasi, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
            <p>Bendahara Pesantren,</p>
            
            <div class="ttd-image-container">
                @if($ttdBase64)
                    <img src="{{ $ttdBase64 }}" class="ttd-image" alt="Tanda Tangan">
                @else
                    <br><br><br>
                @endif
            </div>
            
            <div class="ttd-name">Ust. Faisal Tirta Nazmuddin, S.Pd.</div>
            <p style="font-size: 10px; margin-top: 2px;">+62-857-7335-3921</p>
        </div>
    </div>
</body>
</html>
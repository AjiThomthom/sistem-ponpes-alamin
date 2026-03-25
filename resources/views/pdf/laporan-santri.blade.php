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
    <title>Laporan Data Santri Lengkap</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 9px; color: #333; line-height: 1.2; }
        
        /* HEADER DOUBLE LOGO */
        .header-table { width: 100%; border-bottom: 3px double #065f46; padding-bottom: 10px; margin-bottom: 15px; }
        .logo-cell { width: 10%; text-align: center; vertical-align: middle; }
        .text-cell { width: 80%; text-align: center; vertical-align: middle; }
        
        .header-title { font-size: 16px; font-weight: bold; color: #065f46; text-transform: uppercase; margin: 0; }
        .header-sub { font-size: 10px; font-weight: bold; margin-bottom: 2px; }
        
        table.data-table { width: 100%; border-collapse: collapse; }
        table.data-table th { background-color: #065f46; color: white; padding: 6px; border: 1px solid #ddd; text-transform: uppercase; font-size: 8px; }
        table.data-table td { padding: 5px; border: 1px solid #ddd; vertical-align: middle; }
        
        .foto-santri { width: 30px; height: 30px; border-radius: 50%; object-fit: cover; }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        
        .footer-section { margin-top: 20px; width: 100%; page-break-inside: avoid; }
        .ttd-box { float: right; width: 200px; text-align: center; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                @if($logoPonpes) <img src="{{ $logoPonpes }}" style="width: 55px;"> @endif
            </td>
            <td class="text-cell">
                <div class="header-sub">YAYASAN PENDIDIKAN ISLAM AL-AMIN</div>
                <div class="header-title">PONDOK PESANTREN AL-AMIN</div>
                <div style="font-size: 8px;">Jl. Industri Kp. Sempu Gardu RT.04/02 Desa Pasir Gombong, Cikarang Utara, Bekasi</div>
            </td>
            <td class="logo-cell">
                @if($logoYayasan) <img src="{{ $logoYayasan }}" style="width: 55px;"> @endif
            </td>
        </tr>
    </table>

    <h3 style="text-align: center; text-decoration: underline; margin-bottom: 10px;">LAPORAN DATA PROFIL SANTRI LENGKAP</h3>
    <p>Dicetak pada: <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</strong></p>

    <table class="data-table">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="5%">Foto</th>
                <th width="10%">NIS</th>
                <th width="15%">Nama Lengkap</th>
                <th width="15%">Tempat, Tgl Lahir</th>
                <th width="8%">Kelas</th>
                <th width="10%">HP Santri</th>
                <th width="10%">WA Wali</th>
                <th>Email</th>
                <th width="7%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">
                    @php 
                        $path = $item->foto_profile ? 'storage/' . $item->foto_profile : null;
                        $foto = $path ? imageToBase64($path) : null;
                    @endphp
                    @if($foto) <img src="{{ $foto }}" class="foto-santri"> @else - @endif
                </td>
                <td class="text-center">{{ $item->nis }}</td>
                <td class="text-bold">{{ $item->nama_santri }}</td>
                <td>
                    {{ $item->tempat_lahir }}, 
                    {{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') : '-' }}
                </td>
                <td class="text-center">{{ $item->kelas }}</td>
                <td class="text-center">{{ $item->no_hp_santri ?? '-' }}</td>
                <td class="text-center">{{ $item->no_hp_wali }}</td>
                <td>{{ $item->email ?? '-' }}</td>
                <td class="text-center">{{ strtoupper($item->status_santri) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-section">
        <div class="ttd-box">
            <p>Bekasi, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Kepala Kesantrian,</p>
            <div style="height: 50px;">
                @if($ttdBase64) <img src="{{ $ttdBase64 }}" style="max-height: 50px;"> @else <br><br> @endif
            </div>
            <p><strong>Ust. Faisal Tirta Nazmuddin, S.Pd.</strong></p>
        </div>
    </div>
</body>
</html>
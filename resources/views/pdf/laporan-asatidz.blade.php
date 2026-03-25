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
    <title>Laporan Dewan Asatidz</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #333; line-height: 1.4; }
        .header-table { width: 100%; border-bottom: 3px double #065f46; padding-bottom: 10px; margin-bottom: 20px; }
        .logo-cell { width: 15%; text-align: center; vertical-align: middle; }
        .text-cell { width: 70%; text-align: center; vertical-align: middle; }
        
        .header-title { font-size: 18px; font-weight: bold; color: #065f46; text-transform: uppercase; margin: 0; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data-table th { background-color: #065f46; color: white; padding: 10px; border: 1px solid #ddd; text-transform: uppercase; }
        table.data-table td { padding: 8px; border: 1px solid #ddd; }
        
        .text-center { text-align: center; }
        .foto-profile { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; }
        
        .footer-container { margin-top: 40px; width: 100%; page-break-inside: avoid; }
        .ttd-box { float: right; width: 200px; text-align: center; }
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

    <h3 style="text-align: center; text-decoration: underline; text-transform: uppercase;">Laporan Daftar Dewan Asatidz</h3>
    <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Foto</th>
                <th>Nama Lengkap & Gelar</th>
                <th width="25%">Jabatan / Peran</th>
                <th width="20%">Tanggal Bergabung</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">
                    @php 
                        $path = $item->foto_profile ? 'storage/' . $item->foto_profile : null;
                        $foto = $path ? imageToBase64($path) : null;
                    @endphp
                    @if($foto) <img src="{{ $foto }}" class="foto-profile"> @else - @endif
                </td>
                <td><strong>{{ $item->nama_lengkap }}</strong></td>
                <td class="text-center">{{ $item->jabatan }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->CreatedDate)->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Data asatidz tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-container">
        <div class="ttd-box">
            <p>Bekasi, {{ date('d F Y') }}</p>
            <p>Pimpinan Pesantren,</p>
            <div style="height: 60px;">
                @if($ttdBase64) <img src="{{ $ttdBase64 }}" style="max-height: 60px;"> @else <br><br> @endif
            </div>
            <p><strong>Ust. Faisal Tirta Nazmuddin, S.Pd.</strong></p>
        </div>
    </div>
</body>
</html>
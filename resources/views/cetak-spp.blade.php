<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak {{ $jenis }} - {{ $data->santri->nama_santri }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-ponpes.png') }}">
    
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 14px; color: #333; margin: 0; padding: 0; }
        .print-container { width: 100%; max-width: 800px; margin: 20px auto; padding: 30px; border: 1px solid #ddd; background: #fff; }
        
        /* KOP SURAT */
        .header-table { width: 100%; border-bottom: 4px double #065f46; padding-bottom: 15px; margin-bottom: 25px; }
        .logo-cell { width: 15%; text-align: center; vertical-align: middle; }
        .text-cell { width: 70%; text-align: center; vertical-align: middle; }
        .logo { width: 80px; height: auto; }
        .yayasan-name { font-size: 14px; font-weight: bold; letter-spacing: 1px; }
        .ponpes-name { font-size: 24px; font-weight: bold; color: #065f46; margin: 5px 0; text-transform: uppercase; }
        .address { font-size: 11px; }

        /* KONTEN */
        .document-title { text-align: center; font-size: 18px; font-weight: bold; text-transform: uppercase; text-decoration: underline; margin-bottom: 20px; letter-spacing: 2px;}
        .info-table { width: 100%; margin-bottom: 30px; }
        .info-table td { padding: 5px; font-size: 14px; }
        .info-label { width: 150px; font-weight: bold; }

        /* TABEL TRANSAKSI */
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 12px; text-align: center; }
        .data-table th { background-color: #f3f4f6; font-weight: bold; text-transform: uppercase; }
        .nominal-cell { text-align: right !important; font-weight: bold; font-size: 16px; }

        /* TANDA TANGAN */
        .signature-section { width: 100%; margin-top: 50px; }
        .signature-box { float: right; width: 250px; text-align: center; }
        .signature-space { height: 80px; }

        /* PRINT SETTINGS */
        @media print {
            body { background: #fff; }
            .print-container { border: none; margin: 0; padding: 0; max-width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="print-container">
        <div class="no-print" style="text-align: center; margin-bottom: 20px;">
            <button onclick="window.close()" style="padding: 10px 20px; background: #dc2626; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">TUTUP HALAMAN</button>
            <button onclick="window.print()" style="padding: 10px 20px; background: #065f46; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">CETAK ULANG</button>
        </div>

        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    <img src="{{ asset('images/logo-ponpes.png') }}" class="logo" alt="Logo Ponpes">
                </td>
                <td class="text-cell">
                    <div class="yayasan-name">YAYASAN PENDIDIKAN ISLAM AL-AMIN</div>
                    <div class="ponpes-name">Pondok Pesantren Al-Amin</div>
                    <div class="address">Jl. Industri Kp. Sempu Gardu RT.04/02 Desa Pasir Gombong, Cikarang Utara, Bekasi</div>
                </td>
                <td class="logo-cell">
                    <img src="{{ asset('images/logo-yayasan.png') }}" class="logo" alt="Logo Yayasan">
                </td>
            </tr>
        </table>

        <div class="document-title">{{ $jenis }}</div>

        <table class="info-table">
            <tr>
                <td class="info-label">Telah Diterima Dari</td>
                <td>: <strong>{{ $data->santri->nama_santri }}</strong></td>
                <td class="info-label">Tanggal Cetak</td>
                <td>: {{ date('d F Y') }}</td>
            </tr>
            <tr>
                <td class="info-label">Nomor Induk (NIS)</td>
                <td>: {{ $data->santri->nis }}</td>
                <td class="info-label">No. Referensi</td>
                <td>: #TRX-{{ str_pad($data->id_tagihan, 5, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td class="info-label">Kelas / Asrama</td>
                <td>: {{ $data->santri->kelas }}</td>
                <td class="info-label">Status Dokumen</td>
                <td>: <strong>{{ $data->status_bayar }}</strong></td>
            </tr>
        </table>

        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="45%">Keterangan Pembayaran</th>
                    <th width="20%">Bulan & Tahun</th>
                    <th width="30%">Jumlah Nominal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td style="text-align: left;">Iuran Syahriyah / SPP Santri Bulanan</td>
                    <td>{{ $data->bulan }} {{ $data->tahun }}</td>
                    <td class="nominal-cell">Rp {{ number_format($data->nominal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold;">TOTAL TAGIHAN :</td>
                    <td class="nominal-cell">Rp {{ number_format($data->nominal, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="signature-section">
            <div class="signature-box">
                <div>Bekasi, {{ date('d F Y') }}</div>
                <div>Bendahara Pesantren,</div>
                <div class="signature-space">
                    @if($data->status_bayar == 'LUNAS')
                        <img src="{{ asset('images/ttd-bendahara.png') }}" style="height: 60px; margin-top: 10px;" alt="TTD">
                    @endif
                </div>
                <div style="font-weight: bold; text-decoration: underline;">Ust. Faisal Tirta Nazmuddin, S.Pd.</div>
            </div>
            <div style="clear: both;"></div>
        </div>

        <div style="margin-top: 50px; font-size: 11px; font-style: italic; color: #555;">
            * Dokumen ini sah dicetak otomatis melalui Sistem Informasi Pondok Pesantren Al-Amin. <br>
            * Simpan tanda terima ini sebagai bukti pembayaran yang sah.
        </div>
    </div>

</body>
</html>
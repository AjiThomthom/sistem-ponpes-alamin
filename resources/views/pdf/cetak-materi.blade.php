<!DOCTYPE html>
<html>
<head>
    <title>{{ $record->judul_materi }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; line-height: 1.6; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #065f46; margin-bottom: 20px; padding-bottom: 10px; }
        .kategori { color: #065f46; font-weight: bold; text-transform: uppercase; font-size: 12px; }
        h1 { margin: 10px 0; font-size: 24px; }
        .meta { font-size: 10px; color: #666; margin-bottom: 20px; }
        .isi-konten { text-align: justify; font-size: 12px; }
        img { max-width: 100%; height: auto; display: block; margin: 20px auto; }
    </style>
</head>
<body>
    <div class="header">
        <div class="kategori">{{ $record->kategori }}</div>
        <h1>{{ $record->judul_materi }}</h1>
        <div class="meta">Oleh: Admin Al-Amin | Tanggal: {{ \Carbon\Carbon::parse($record->CreatedDate)->format('d F Y') }}</div>
    </div>

    <div class="isi-konten">
        {!! $record->isi_konten !!}
    </div>

    <div style="margin-top: 50px; font-size: 10px; text-align: center; border-top: 1px solid #ddd; padding-top: 10px;">
        Dokumen ini diterbitkan oleh Pondok Pesantren Al-Amin sebagai materi pembelajaran santri.
    </div>
</body>
</html>
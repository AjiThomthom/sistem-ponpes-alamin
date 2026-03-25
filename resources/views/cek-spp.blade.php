<!DOCTYPE html>
<html lang="id" 
    x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" 
    x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
    :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek SPP - Ponpes Al-Amin</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-ponpes.png') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: { darkbg: '#0f172a', darkcard: '#1e293b' }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 dark:bg-darkbg text-slate-800 dark:text-slate-100 min-h-screen p-4 sm:p-8 transition-colors duration-500 relative">

    <button @click="darkMode = !darkMode" class="fixed top-6 right-6 z-50 p-3.5 rounded-full bg-white dark:bg-darkcard shadow-lg border border-slate-100 dark:border-slate-800 hover:scale-105 transition-all text-slate-500 dark:text-slate-400">
        <i class="fa-solid text-xl" :class="darkMode ? 'fa-sun text-amber-400' : 'fa-moon'"></i>
    </button>
    
    <div class="w-full max-w-6xl mx-auto bg-white dark:bg-darkcard rounded-[2rem] shadow-xl overflow-hidden animate__animated animate__fadeIn border border-slate-100 dark:border-slate-800">
        
        <div class="p-8 sm:p-14">
            
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6 mb-14 text-center">
                <div class="w-24 flex justify-center sm:justify-start hidden sm:flex">
                    <div class="p-2 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                        <img src="{{ asset('images/logo-ponpes.png') }}" alt="Logo Ponpes" class="h-20 w-20 object-contain">
                    </div>
                </div>
                
                <div class="flex-1 flex flex-col items-center justify-center">
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">Pondok Pesantren Al-Amin</h1>
                    <p class="text-emerald-600 dark:text-emerald-400 font-semibold text-lg tracking-wide mt-2">Portal Pengecekan & Pembayaran SPP Santri</p>
                </div>

                <div class="w-24 flex justify-center sm:justify-end hidden sm:flex">
                    <div class="p-2 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                        <img src="{{ asset('images/logo-yayasan.png') }}" alt="Logo Yayasan" class="h-20 w-20 object-contain">
                    </div>
                </div>
            </div>

            <form action="{{ url('/cek-spp') }}" method="GET" class="relative max-w-3xl mx-auto mb-14">
                <input type="text" name="nis" placeholder="Ketik Nomor Induk Santri (NIS)..." 
                       class="w-full bg-slate-50 dark:bg-slate-800/50 border-2 border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-full pl-8 pr-40 py-5 focus:outline-none focus:border-emerald-500 transition-all text-lg font-semibold shadow-sm text-center" 
                       value="{{ request('nis') }}" required>
                <button type="submit" class="absolute right-2 top-2 bottom-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 rounded-full transition-all shadow-md active:scale-95 text-base">
                    CARI DATA
                </button>
            </form>

            @if(request()->has('nis'))
                @if($santri)
                    <div class="mb-10 bg-gradient-to-r from-emerald-600 to-teal-700 rounded-3xl p-8 shadow-lg text-white">
                        <div class="flex flex-col items-center justify-center text-center gap-4">
                            <i class="fa-solid fa-user-graduate text-5xl opacity-90 mb-2"></i>
                            <div>
                                <p class="text-emerald-100 text-sm font-semibold uppercase tracking-wider mb-1">Nama Lengkap Santri</p>
                                <h3 class="text-3xl font-bold">{{ $santri->nama_santri }}</h3>
                            </div>
                            
                            <div class="flex flex-wrap justify-center gap-12 border-t border-white/20 pt-6 mt-2 w-full max-w-2xl">
                                <div>
                                    <p class="text-emerald-100 text-sm font-semibold uppercase tracking-wider mb-1">NIS</p>
                                    <p class="text-2xl font-bold">{{ $santri->nis }}</p>
                                </div>
                                <div>
                                    <p class="text-emerald-100 text-sm font-semibold uppercase tracking-wider mb-1">Kelas Aktif</p>
                                    <p class="text-2xl font-bold">{{ $santri->kelas }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-800/40 border-2 border-slate-100 dark:border-slate-700 rounded-3xl overflow-hidden mb-12">
                        <table class="w-full text-center border-collapse">
                            <thead>
                                <tr class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-sm uppercase font-bold">
                                    <th class="px-8 py-5">Periode</th>
                                    <th class="px-8 py-5">Nominal Tagihan</th>
                                    <th class="px-8 py-5">Status</th>
                                    <th class="px-8 py-5">Aksi / Dokumen</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                @forelse($tagihan as $t)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                    <td class="px-8 py-6 text-xl font-bold text-slate-800 dark:text-slate-100">{{ $t->bulan }} {{ $t->tahun }}</td>
                                    <td class="px-8 py-6 text-2xl font-mono font-bold text-slate-800 dark:text-emerald-400">Rp {{ number_format($t->nominal, 0, ',', '.') }}</td>
                                    <td class="px-8 py-6">
                                        @if($t->status_bayar == 'LUNAS')
                                            <span class="inline-block px-5 py-2.5 rounded-full text-sm font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400"><i class="fa-solid fa-check mr-2"></i>LUNAS</span>
                                        @elseif($t->status_bayar == 'PENDING')
                                            <span class="inline-block px-5 py-2.5 rounded-full text-sm font-bold bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400"><i class="fa-solid fa-clock mr-2"></i>VERIFIKASI</span>
                                        @else
                                            <span class="inline-block px-5 py-2.5 rounded-full text-sm font-bold bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400"><i class="fa-solid fa-xmark mr-2"></i>BELUM BAYAR</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6">
                                        @if($t->status_bayar == 'LUNAS')
                                            <a href="{{ url('/cetak/kwitansi/'.$t->id_tagihan) }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-3 rounded-xl font-bold text-sm transition-all shadow-md hover:shadow-lg w-full max-w-[200px] mx-auto">
                                                <i class="fa-solid fa-print text-lg"></i> Cetak Kwitansi
                                            </a>
                                        @else
                                            <a href="{{ url('/cetak/tagihan/'.$t->id_tagihan) }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-900 dark:bg-slate-600 text-white px-5 py-3 rounded-xl font-bold text-sm transition-all shadow-md hover:shadow-lg w-full max-w-[200px] mx-auto">
                                                <i class="fa-solid fa-file-invoice-dollar text-lg"></i> Cetak Tagihan
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-16 text-slate-500 text-lg">Tidak ada riwayat tagihan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-slate-50 dark:bg-slate-800/30 border-2 border-slate-200 dark:border-slate-700 rounded-3xl p-10 mb-8 text-center">
                        <div class="mb-10">
                            <h3 class="text-3xl font-extrabold text-slate-800 dark:text-white">Pilihan Metode Pembayaran</h3>
                            <p class="text-slate-500 dark:text-slate-400 mt-2 text-lg">Silakan pilih salah satu metode di bawah ini untuk melunasi tagihan SPP.</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 flex flex-col items-center">
                                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-3xl mb-4"><i class="fa-solid fa-building-columns"></i></div>
                                <h4 class="font-bold text-xl mb-2 dark:text-white">Transfer Bank (BSI)</h4>
                                <p class="text-slate-600 dark:text-slate-300 mb-4">Bank Syariah Indonesia</p>
                                <div class="bg-slate-100 dark:bg-slate-900 px-6 py-4 rounded-xl w-full">
                                    <span class="font-mono font-bold text-2xl dark:text-white tracking-widest">7123 4567 89</span>
                                </div>
                                <p class="text-sm font-semibold text-slate-500 mt-3">A.n. Pondok Pesantren Al-Amin</p>
                            </div>

                            <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 flex flex-col items-center">
                                <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-3xl mb-4"><i class="fa-solid fa-qrcode"></i></div>
                                <h4 class="font-bold text-xl mb-2 dark:text-white">Scan QRIS</h4>
                                <p class="text-slate-600 dark:text-slate-300 mb-6">DANA, OVO, Gopay, LinkAja</p>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="QRIS" class="w-40 h-40 rounded-xl border-4 border-slate-100 dark:border-slate-700">
                            </div>

                            <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 flex flex-col items-center">
                                <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-3xl mb-4"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                                <h4 class="font-bold text-xl mb-2 dark:text-white">Tunai / Sekretariat</h4>
                                <p class="text-slate-600 dark:text-slate-300 mb-6">Pembayaran langsung ke Bendahara pada jam kerja (08.00 - 15.00 WIB).</p>
                                <a href="https://wa.me/6285773353921" target="_blank" class="w-full mt-auto text-center bg-emerald-100 hover:bg-emerald-200 text-emerald-800 font-bold py-4 rounded-xl transition-colors text-lg">
                                    <i class="fa-brands fa-whatsapp mr-2 text-xl"></i> Konfirmasi Admin
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-16">
                        <i class="fa-solid fa-circle-exclamation text-7xl text-rose-500 mb-6"></i>
                        <h3 class="text-3xl font-bold text-slate-800 dark:text-white mb-3">Data Tidak Ditemukan</h3>
                        <p class="text-slate-500 text-xl">NIS <strong class="text-slate-700 dark:text-slate-200">{{ request('nis') }}</strong> tidak terdaftar di sistem kami.</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
</body>
</html>
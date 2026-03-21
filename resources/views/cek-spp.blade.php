<!DOCTYPE html>
<html lang="id" 
    x-data="{ 
        darkMode: localStorage.getItem('theme') === 'dark' 
    }" 
    x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
    :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek SPP - Ponpes Al-Amin</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        darkbg: '#0b1120',
                        darkcard: '#1e293b'
                    }
                }
            }
        }
    </script>
    
    <style>
        body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-darkbg text-gray-800 dark:text-gray-100 min-h-screen flex flex-col items-center p-6 transition-colors duration-500">

    <button @click="darkMode = !darkMode" class="fixed top-4 right-4 z-50 p-3 rounded-full bg-white dark:bg-darkcard shadow-lg border border-gray-200 dark:border-gray-700 transition-all">
        <i class="fa-solid" :class="darkMode ? 'fa-sun text-yellow-400' : 'fa-moon text-gray-500'"></i>
    </button>


    
    <div class="w-full max-w-4xl bg-white dark:bg-darkcard rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-800 animate__animated animate__fadeInDown transition-colors duration-500">
        
        <div class="bg-green-700 dark:bg-emerald-900 p-6 text-white flex flex-col sm:flex-row items-center justify-center gap-4">
            <img src="{{ asset('images/logo-ponpes.png') }}" alt="Logo Ponpes" 
                 class="h-16 w-16 object-contain rounded-full bg-white p-1 shadow-md animate__animated animate__pulse animate__infinite">
            
            <div class="text-center sm:text-left">
                <h1 class="text-2xl font-bold uppercase tracking-wide">Pondok Pesantren Al-Amin</h1>
                <p class="text-green-100 dark:text-emerald-200 text-sm mt-1">Sistem Informasi Pengecekan Tagihan SPP Mandiri</p>
            </div>
        </div>

        <div class="p-8">
            <form action="{{ url('/cek-spp') }}" method="GET" class="flex flex-col sm:flex-row gap-3 mb-8">
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1 ml-1">Nomor Induk Santri (NIS)</label>
                    <input type="text" name="nis" placeholder="Contoh: 12345" 
                           class="w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-lg px-4 py-3 focus:outline-none focus:border-green-500 transition-all duration-300 shadow-inner" 
                           value="{{ request('nis') }}" required>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-bold px-8 py-3 rounded-lg transition-all shadow-md active:scale-95">
                        CARI DATA
                    </button>
                </div>
            </form>

            @if(request()->has('nis'))
                @if($santri)
                    <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-50 dark:bg-gray-800/50 p-5 rounded-xl border border-gray-200 dark:border-gray-700 animate__animated animate__fadeInUp shadow-sm">
                        <div>
                            <span class="text-gray-400 dark:text-gray-500 text-xs font-bold uppercase block">Nama Santri</span>
                            <span class="text-gray-800 dark:text-gray-200 font-bold text-lg">{{ $santri->nama_siswa }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 dark:text-gray-500 text-xs font-bold uppercase block">Kelas</span>
                            <span class="text-gray-800 dark:text-gray-200 font-bold text-lg">{{ $santri->kelas }}</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto animate__animated animate__fadeIn animate__delay-1s">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-sm uppercase">
                                    <th class="p-4 border-b dark:border-gray-700">Bulan Tagihan</th>
                                    <th class="p-4 border-b dark:border-gray-700 text-right">Nominal</th>
                                    <th class="p-4 border-b dark:border-gray-700 text-center">Status</th>
                                    <th class="p-4 border-b dark:border-gray-700 text-center text-gray-500">Trace Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @forelse($tagihan as $t)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors duration-200">
                                    <td class="p-4 font-semibold text-gray-700 dark:text-gray-300">{{ $t->bulan_tagihan }}</td>
                                    <td class="p-4 text-right text-gray-800 dark:text-gray-200 font-mono font-medium">
                                        Rp {{ number_format($t->nominal, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4 text-center">
                                        @if($t->status_bayar == 'LUNAS')
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-black bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400">
                                                ✓ LUNAS
                                            </span>
                                        @else
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-black bg-orange-100 text-orange-600 dark:bg-orange-900/40 dark:text-orange-400 animate__animated animate__pulse animate__infinite">
                                                ⏱ PENDING
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center text-gray-500 dark:text-gray-400 text-xs italic">
                                        @if($t->status_bayar == 'LUNAS')
                                            <div class="flex flex-col items-center">
                                                <span class="font-semibold text-gray-600 dark:text-gray-300">{{ $t->metode_pembayaran ?? 'N/A' }}</span>
                                                <span>{{ $t->tanggal_lunas ? $t->tanggal_lunas->format('d M Y, H:i') : 'Data Kosong' }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-600">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center p-10 text-gray-400 dark:text-gray-600 italic">
                                        Belum ada riwayat tagihan untuk NIS ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-md animate__animated animate__headShake">
                        <div class="flex items-center">
                            <div class="text-red-600 dark:text-red-400 font-bold uppercase text-sm">Error</div>
                            <div class="ml-3 text-red-700 dark:text-red-300 text-sm">Data santri dengan NIS <span class="font-bold underline">{{ request('nis') }}</span> tidak ditemukan.</div>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <div class="mb-8 flex justify-center">
            <a href="{{ route('welcome') }}" class="inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-green-700 dark:text-emerald-400 font-bold px-6 py-3 rounded-xl transition-all duration-300 shadow-sm border border-gray-200 dark:border-gray-700 active:scale-95">
                <i class="fa-solid fa-house"></i> 
                <span>KEMBALI KE BERANDA</span>
            </a>
        </div>

        <div class="bg-gray-50 dark:bg-gray-800/50 p-4 border-t border-gray-100 dark:border-gray-700 text-center">
            <p class="text-gray-400 dark:text-gray-500 text-[10px] uppercase tracking-widest font-bold">
                &copy; {{ date('Y') }} Ponpes Al-Amin - Dashboard Sistem Keuangan
            </p>
        </div>
    </div>

</body>
</html>
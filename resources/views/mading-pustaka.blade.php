<!DOCTYPE html>
<html lang="id" 
    x-data="{ 
        darkMode: localStorage.getItem('theme') === 'dark',
        filter: 'SEMUA',
        modalOpen: false,
        mTitle: '',
        mContent: '',
        mDate: '',
        mCat: ''
    }" 
    x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
    :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mading Pustaka - Ponpes Al-Amin</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: { darkbg: '#0b1120', darkcard: '#1e293b' }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .prose img { border-radius: 1rem; margin: 1.5rem 0; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-darkbg text-gray-800 dark:text-gray-100 min-h-screen transition-colors duration-500">

    <nav class="bg-white dark:bg-darkcard shadow-sm sticky top-0 z-50 border-b dark:border-gray-800">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('welcome') }}" class="flex items-center gap-2 font-bold text-primary dark:text-emerald-400">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
            </a>
            <div class="flex items-center gap-4">
                <button @click="darkMode = !darkMode" class="p-2 rounded-full bg-gray-100 dark:bg-gray-800">
                    <i class="fa-solid" :class="darkMode ? 'fa-sun text-yellow-400' : 'fa-moon text-gray-500'"></i>
                </button>
                <img src="{{ asset('images/logo-ponpes.png') }}" class="w-10 h-10 rounded-full">
            </div>
        </div>
    </nav>

    <header class="py-16 bg-gradient-to-b from-white to-gray-50 dark:from-darkcard dark:to-darkbg text-center">
        <h1 class="text-4xl md:text-5xl font-black mb-4">Mading Pustaka Digital</h1>
        <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto px-6 italic">Jendela ilmu santri: Koleksi artikel, materi kajian asatidz, dan pengumuman terbaru Ponpes Al-Amin.</p>
    </header>

    <main class="container mx-auto px-6 py-12">
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            <template x-for="item in ['SEMUA', 'PENGUMUMAN', 'ARTIKEL', 'KAJIAN']">
                <button @click="filter = item" 
                        :class="filter === item ? 'bg-purple-600 text-white shadow-lg' : 'bg-white dark:bg-darkcard text-gray-500 dark:text-gray-400 border dark:border-gray-700'"
                        class="px-6 py-2 rounded-full font-bold text-xs transition-all uppercase" x-text="item"></button>
            </template>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($mading as $m)
            <div x-show="filter === 'SEMUA' || filter === '{{ strtoupper($m->kategori) }}'"
                 class="bg-white dark:bg-darkcard rounded-3xl p-8 shadow-md border border-gray-100 dark:border-gray-800 flex flex-col hover:shadow-xl transition-all group">
                
                <div class="flex justify-between items-center mb-6">
                    <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-300 text-[10px] font-black rounded-lg uppercase tracking-wider">{{ $m->kategori }}</span>
                    <span class="text-[10px] text-gray-400 font-bold">{{ $m->CreatedDate->format('d M Y') }}</span>
                </div>

                <h3 class="text-xl font-bold mb-4 leading-tight group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                    {{ $m->judul_materi }}
                </h3>

                <div class="text-gray-500 dark:text-gray-400 text-sm mb-8 line-clamp-3 leading-relaxed">
                    {!! strip_tags($m->isi_konten) !!}
                </div>

                <div class="mt-auto flex justify-between items-center pt-6 border-t dark:border-gray-800">
                    @if($m->link_google_drive)
                    <a href="{{ $m->link_google_drive }}" target="_blank" class="text-purple-600 dark:text-purple-400 font-bold text-[10px] hover:underline uppercase flex items-center gap-1">
                        <i class="fa-solid fa-download"></i> Unduh File
                    </a>
                    @endif
                    <button @click="modalOpen = true; mTitle = '{{ $m->judul_materi }}'; mContent = `{{ $m->isi_konten }}`; mDate = '{{ $m->CreatedDate->format('d M Y') }}'; mCat = '{{ $m->kategori }}'" 
                            class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-xl text-[10px] font-bold transition-transform active:scale-95 shadow-md shadow-purple-500/20">
                        BACA LENGKAP
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-20 bg-white dark:bg-darkcard rounded-3xl border border-dashed dark:border-gray-700">
                <i class="fa-solid fa-book-open text-5xl text-gray-200 dark:text-gray-700 mb-4"></i>
                <p class="text-gray-400 italic">Belum ada materi atau pengumuman yang tersedia saat ini.</p>
            </div>
            @endforelse
        </div>
    </main>

    <footer class="py-12 text-center text-gray-400 text-[10px] font-bold uppercase tracking-[0.2em]">
        &copy; 2026 Ponpes Al-Amin - Dashboard Materi Pembelajaran
    </footer>

    <div x-cloak x-show="modalOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-md p-4">
        <div x-show="modalOpen" 
             @click.outside="modalOpen = false"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
             class="bg-white dark:bg-darkcard w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-[2.5rem] p-8 md:p-14 shadow-2xl relative">
            
            <button @click="modalOpen = false" class="absolute top-8 right-8 text-gray-400 hover:text-red-500 transition-colors">
                <i class="fa-solid fa-xmark text-3xl"></i>
            </button>

            <div class="mb-10">
                <span class="px-4 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 text-xs font-black rounded-lg uppercase tracking-widest" x-text="mCat"></span>
                <h2 class="text-3xl md:text-4xl font-black mt-6 leading-tight dark:text-white" x-text="mTitle"></h2>
                <div class="flex items-center gap-2 mt-4 text-gray-400 text-xs font-bold">
                    <i class="fa-regular fa-calendar"></i> <span x-text="mDate"></span>
                </div>
            </div>

            <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-loose text-lg" x-html="mContent"></div>

            <button @click="modalOpen = false" class="w-full mt-12 bg-gray-900 dark:bg-purple-600 text-white font-bold py-5 rounded-2xl transition-all hover:bg-black dark:hover:bg-purple-700 active:scale-[0.98]">
                SELESAI MEMBACA
            </button>
        </div>
    </div>

</body>
</html>
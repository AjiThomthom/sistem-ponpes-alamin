<!DOCTYPE html>
<html lang="id" 
    x-data="appData()" 
    x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
    :class="{ 'dark': darkMode }" 
    class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal Resmi Pondok Pesantren Al-Amin Cikarang Utara. Layanan informasi santri dan pengecekan SPP mandiri.">
    <meta property="og:title" content="Portal Ponpes Al-Amin">
    <meta property="og:image" content="{{ asset('images/logo-ponpes.png') }}">

    <title>Portal Resmi - Ponpes Al-Amin</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#065f46', 
                        secondary: '#10b981', 
                        darkbg: '#0b1120', 
                        darkcard: '#1e293b' 
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-50 dark:bg-darkbg text-gray-800 dark:text-gray-100 transition-colors duration-700 antialiased flex flex-col min-h-screen relative">

    <nav class="bg-white/95 dark:bg-darkcard/95 backdrop-blur-lg shadow-sm sticky top-0 z-50 transition-colors duration-700 border-b border-gray-200 dark:border-gray-800">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/logo-ponpes.png') }}" alt="Logo Ponpes" class="w-12 h-12 object-contain rounded-full shadow-sm" onerror="this.outerHTML='<div class=\'w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold\'><i class=\'fa-solid fa-mosque\'></i></div>'">
                <span class="text-2xl font-extrabold text-primary dark:text-emerald-400 tracking-tight">معهد الأمين الاسلامي</span>
            </div>

            <div class="hidden md:flex items-center space-x-8 font-semibold text-gray-600 dark:text-gray-300">
                <a href="#" class="hover:text-primary transition-colors">Beranda</a>
                <a href="#profil" class="hover:text-primary transition-colors">Visi & Profil</a>
                <a href="#akademik" class="hover:text-primary transition-colors">Akademik</a>
                <a href="#struktural" class="hover:text-primary transition-colors">Asatidz</a>
                <a href="#layanan" class="hover:text-primary transition-colors">Layanan</a>
                
                <button @click="darkMode = !darkMode" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <i class="fa-solid text-lg" :class="darkMode ? 'fa-sun text-yellow-400' : 'fa-moon text-gray-500'"></i>
                </button>

                <a href="/pengurus-ppalamin" class="bg-primary hover:bg-emerald-800 text-white px-6 py-2.5 rounded-full shadow-lg transition-transform transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-lock mr-2"></i>Login
                </a>
            </div>

            <div class="md:hidden flex items-center space-x-4">
                <button @click="darkMode = !darkMode" class="p-2">
                    <i class="fa-solid text-xl" :class="darkMode ? 'fa-sun text-yellow-400' : 'fa-moon text-gray-500'"></i>
                </button>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-2xl text-gray-700 dark:text-gray-200">
                    <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'"></i>
                </button>
            </div>
        </div>

        <div x-show="mobileMenuOpen" x-cloak x-transition class="md:hidden bg-white dark:bg-darkcard border-t dark:border-gray-800 absolute w-full shadow-xl">
            <div class="flex flex-col px-6 py-6 space-y-5 font-medium text-gray-700 dark:text-gray-300">
                <a href="#profil" @click="mobileMenuOpen = false" class="hover:text-primary">Visi & Profil</a>
                <a href="#akademik" @click="mobileMenuOpen = false" class="hover:text-primary">Akademik & Jadwal</a>
                <a href="#struktural" @click="mobileMenuOpen = false" class="hover:text-primary">Dewan Asatidz</a>
                <a href="#layanan" @click="mobileMenuOpen = false" class="hover:text-primary">Layanan Digital</a>
                <a href="/pengurus-ppalamin" class="bg-primary text-white text-center px-5 py-3 rounded-xl shadow-md mt-4">Login Admin</a>
            </div>
        </div>
    </nav>

    <header class="relative overflow-hidden flex-grow flex items-center py-24 lg:py-32">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-white to-white dark:from-darkbg dark:via-darkbg dark:to-gray-900 z-0 transition-colors duration-700"></div>
        <div class="absolute right-0 top-0 w-1/2 h-full bg-emerald-100 dark:bg-emerald-900/10 blur-[150px] rounded-full opacity-60"></div>
        
        <div class="container mx-auto px-6 relative z-10 text-center" data-aos="fade-up">
            <div class="flex flex-col items-center justify-center mb-8">
                <img src="{{ asset('images/logo-ponpes.png') }}" alt="Logo Ponpes" class="w-24 h-24 mb-6 drop-shadow-xl animate__animated animate__zoomIn">
                <span class="text-4xl md:text-5xl font-extrabold text-primary dark:text-emerald-300 tracking-widest leading-loose">
                    معهد الأمين الاسلامي
                </span>
            </div>
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-gray-900 dark:text-white mb-6 leading-tight tracking-tight">
                Pondok Pesantren <br> 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-emerald-400">Al-Amin Cikarang Utara</span>
            </h1>
            <p class="text-xl md:text-2xl mb-12 text-gray-600 dark:text-gray-300 max-w-3xl mx-auto italic font-medium">
                "Cerdas, Mandiri, Santun dan Berakhlaqul Karimah"
            </p>
            <div class="flex flex-col sm:flex-row justify-center">
                <a href="#profil" class="w-full sm:w-auto bg-primary hover:bg-emerald-800 text-white font-bold py-4 px-10 rounded-full shadow-lg transition-transform transform hover:-translate-y-1 text-lg">
                    Tentang Kami
                </a>
            </div>
        </div>
    </header>

    <section id="profil" class="py-24 bg-white dark:bg-darkcard relative z-10 shadow-[0_-10px_40px_-15px_rgba(0,0,0,0.05)]">
        <div class="container mx-auto px-6 max-w-6xl">
            <div data-aos="fade-up" class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-8">Visi & Misi</h2>
                <div class="bg-gradient-to-br from-emerald-50 to-white dark:from-gray-800 dark:to-darkcard border border-emerald-100 dark:border-gray-700 p-8 lg:p-12 rounded-3xl shadow-lg relative overflow-hidden text-center mb-10 max-w-4xl mx-auto">
                    <i class="fa-solid fa-quote-left text-6xl absolute top-4 left-4 text-emerald-200 dark:text-gray-700 opacity-30"></i>
                    <p class="text-gray-800 dark:text-gray-200 text-xl lg:text-2xl italic leading-relaxed font-semibold relative z-10">
                        "Menjadi pondok pesantren unggulan yang melahirkan generasi Muslim yang beriman, berilmu, dan beramal, serta mampu menghadapi tantangan global dengan tetap berpegang pada nilai-nilai Islami."
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow border border-gray-100 dark:border-gray-700 flex flex-col items-center hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-16 h-16 bg-primary text-white rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-md"><i class="fa-solid fa-graduation-cap"></i></div>
                        <h4 class="font-bold text-xl text-gray-900 dark:text-white mb-3">Pendidikan Terpadu</h4>
                        <p class="text-gray-600 dark:text-gray-400">Mengintegrasikan ilmu agama dan umum untuk mencetak santri cerdas secara intelektual dan spiritual.</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow border border-gray-100 dark:border-gray-700 flex flex-col items-center hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-16 h-16 bg-secondary text-white rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-md"><i class="fa-solid fa-mosque"></i></div>
                        <h4 class="font-bold text-xl text-gray-900 dark:text-white mb-3">Spiritualitas</h4>
                        <p class="text-gray-600 dark:text-gray-400">Membina spiritualitas santri melalui pengajian rutin, tazkiyah an-nafs, dan amalan sunnah.</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow border border-gray-100 dark:border-gray-700 flex flex-col items-center hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-16 h-16 bg-primary text-white rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-md"><i class="fa-solid fa-heart"></i></div>
                        <h4 class="font-bold text-xl text-gray-900 dark:text-white mb-3">Karakter Mulia</h4>
                        <p class="text-gray-600 dark:text-gray-400">Menanamkan nilai akhlak yang mulia dalam kehidupan sehari-hari melalui keteladanan yang baik.</p>
                    </div>
                </div>
            </div>

            <div class="text-center" data-aos="fade-up">
                <button @click="profilModalOpen = true" class="inline-flex items-center space-x-3 bg-gray-900 dark:bg-emerald-500 text-white font-bold py-4 px-8 rounded-full shadow-xl hover:scale-105 transition duration-300">
                    <i class="fa-solid fa-book-open"></i>
                    <span>Baca Profil Singkat Pesantren</span>
                </button>
            </div>
        </div>
    </section>

    <section id="struktural" class="py-24 bg-gray-50 dark:bg-gray-900 transition-colors duration-700 overflow-hidden">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="text-center mb-20" data-aos="fade-up">
                <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white">Struktural & Dewan Asatidz</h2>
                <div class="w-24 h-1.5 bg-primary mx-auto mt-6 rounded-full"></div>
            </div>

            <div class="flex flex-col items-center space-y-8 mb-24" data-aos="fade-up" data-aos-delay="100">
                <div class="w-full max-w-md bg-gradient-to-br from-emerald-400 to-primary p-1.5 rounded-3xl shadow-2xl relative">
                    <div class="absolute -top-5 left-1/2 transform -translate-x-1/2 bg-yellow-400 text-yellow-900 w-10 h-10 flex items-center justify-center rounded-full shadow-lg border-2 border-white"><i class="fa-solid fa-crown"></i></div>
                    <div class="bg-white dark:bg-darkcard p-8 rounded-[20px] text-center">
                        <span class="text-sm font-bold text-primary dark:text-emerald-400 uppercase tracking-widest block mb-2">Pimpinan Umum</span>
                        <h4 class="text-2xl font-black text-gray-900 dark:text-white">Drs. KH Hasyim Al-Ihsan</h4>
                    </div>
                </div>

                <div class="hidden md:block w-0.5 h-10 bg-primary/30"></div>
                <div class="hidden md:block w-3/4 max-w-3xl h-0.5 bg-primary/30"></div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-5xl relative">
                    <div class="hidden md:block absolute top-0 left-1/2 w-0.5 h-6 bg-primary/30 transform -translate-x-1/2 -mt-6"></div>
                    <div class="hidden md:block absolute top-0 left-[16.5%] w-0.5 h-6 bg-primary/30 -mt-6"></div>
                    <div class="hidden md:block absolute top-0 right-[16.5%] w-0.5 h-6 bg-primary/30 -mt-6"></div>

                    <div class="bg-white dark:bg-darkcard p-6 rounded-3xl shadow-lg border-t-4 border-secondary text-center hover:-translate-y-2 transition duration-300">
                        <span class="text-xs font-bold text-secondary dark:text-emerald-400 uppercase tracking-widest block mb-2">Pengasuh Pondok Pesantren</span>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white">Ust. M. Busyaeri, S.Pd.I.</h4>
                    </div>
                    <div class="bg-white dark:bg-darkcard p-6 rounded-3xl shadow-lg border-t-4 border-primary text-center hover:-translate-y-2 transition duration-300">
                        <span class="text-xs font-bold text-primary dark:text-emerald-400 uppercase tracking-widest block mb-2">Sekretaris Pondok Pesantren</span>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white">Ust. Romi Ahmad H., S.Pd.</h4>
                    </div>
                    <div class="bg-white dark:bg-darkcard p-6 rounded-3xl shadow-lg border-t-4 border-secondary text-center hover:-translate-y-2 transition duration-300">
                        <span class="text-xs font-bold text-secondary dark:text-emerald-400 uppercase tracking-widest block mb-2">Bendahara Pondok Pesantren</span>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white">Ust. Faisal Tirta N., S.Pd.</h4>
                    </div>
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="200" class="max-w-5xl mx-auto">
                <h3 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-10">Mudarris Ma'had (Dewan Guru)</h3>
                
                <div x-data="{ active: 0, count: 10, next() { this.active = this.active === this.count - 1 ? 0 : this.active + 1 }, prev() { this.active = this.active === 0 ? this.count - 1 : this.active - 1 } }" class="relative w-full">
                    <div class="overflow-hidden relative rounded-3xl py-4">
                        <div class="flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${active * 100}%)`">
                            
                            <template x-for="(teacher, index) in [
                                {name: 'Drs KH. Hasyim Al-Ihsan', role: 'Pimpinan Umum Pondok Pesantren', img: 'ust-hasyim.jpg'},
                                {name: 'Ust. Ali Muzaki, S.Sos.', role: 'Asatidz', img: 'ust-ali.jpg'},
                                {name: 'Ust. Rahman Pasatrio, S.Pd.', role: 'Asatidz', img: 'ust-rahman.jpg'},
                                {name: 'Ust. Faiq Helmi, S.S', role: 'Asatidz', img: 'ust-faiq.jpg'},
                                {name: 'Ust. Abdul Qodir, M.Pd.', role: 'Asatidz', img: 'ust-kodir.jpg'},
                                {name: 'Ust. M. Busyaeri, S.Pd.I.', role: 'Pengurus Pondok Pesantren', img: 'ust-busyaeri.jpg'},
                                {name: 'Ust. Romi Ahmad H., S.Pd.', role: 'Sekretaris Pondok Pesantren', img: 'ust-romi.jpg'},
                                {name: 'Ust. Faisal Tirta, S.Pd.', role: 'Bendahara Pondok Pesantren', img: 'ust-faisal.jpg'},
                                {name: 'Ust. Robi Sugara, S.Pd.', role: 'Asatidz', img: 'ust-robi.jpg'},
                                {name: 'Ust. Abdul Rosyid, S.Pd.', role: 'Asatidz', img: 'ust-rosyid.jpg'}
                            ]">
                                <div class="w-full shrink-0 px-4 md:px-12">
                                    <div class="bg-white dark:bg-darkcard rounded-3xl shadow-xl border border-gray-100 dark:border-gray-800 p-10 text-center flex flex-col items-center max-w-lg mx-auto">
                                        <img :src="`{{ asset('images/asatidz/') }}/${teacher.img}`" :alt="teacher.name" class="w-40 h-40 rounded-full object-cover mb-6 ring-8 ring-emerald-50 dark:ring-gray-700 shadow-lg" onerror="this.src='https://ui-avatars.com/api/?name='+this.alt+'&background=065f46&color=fff&size=250'">
                                        <h4 class="font-extrabold text-2xl text-gray-900 dark:text-white mb-2" x-text="teacher.name"></h4>
                                        <p class="text-primary dark:text-emerald-400 font-bold bg-emerald-50 dark:bg-gray-800 px-4 py-1 rounded-full text-sm" x-text="teacher.role"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <button @click="prev()" class="absolute left-0 top-1/2 -translate-y-1/2 -ml-2 md:-ml-6 w-12 h-12 md:w-14 md:h-14 bg-white dark:bg-gray-700 rounded-full shadow-xl flex items-center justify-center text-primary dark:text-white hover:bg-primary hover:text-white dark:hover:bg-emerald-500 transition-colors z-10 focus:outline-none"><i class="fa-solid fa-chevron-left text-xl"></i></button>
                    <button @click="next()" class="absolute right-0 top-1/2 -translate-y-1/2 -mr-2 md:-mr-6 w-12 h-12 md:w-14 md:h-14 bg-white dark:bg-gray-700 rounded-full shadow-xl flex items-center justify-center text-primary dark:text-white hover:bg-primary hover:text-white dark:hover:bg-emerald-500 transition-colors z-10 focus:outline-none"><i class="fa-solid fa-chevron-right text-xl"></i></button>

                    <div class="flex justify-center space-x-2 mt-6">
                        <template x-for="i in count">
                            <button @click="active = i - 1" :class="active === i - 1 ? 'bg-primary dark:bg-emerald-400 w-8' : 'bg-gray-300 dark:bg-gray-600 w-3'" class="h-3 rounded-full transition-all duration-300 focus:outline-none"></button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="akademik" class="py-24 bg-white dark:bg-darkcard transition-colors duration-700">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white">Kurikulum & Kegiatan</h2>
                <div class="w-24 h-1.5 bg-primary mx-auto mt-6 rounded-full"></div>
            </div>

            <div x-data="{ activeTab: 'jadwal' }" class="max-w-6xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4 mb-12 bg-gray-100 dark:bg-gray-800 p-2 rounded-3xl">
                    <button @click="activeTab = 'jadwal'" :class="activeTab === 'jadwal' ? 'bg-white dark:bg-gray-700 text-primary dark:text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white'" class="flex-1 py-4 px-6 rounded-2xl font-bold text-lg transition-all duration-300">Jadwal Harian</button>
                    <button @click="activeTab = 'tingkatan'" :class="activeTab === 'tingkatan' ? 'bg-white dark:bg-gray-700 text-primary dark:text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white'" class="flex-1 py-4 px-6 rounded-2xl font-bold text-lg transition-all duration-300">Pengajian Tingkatan</button>
                    <button @click="activeTab = 'umum'" :class="activeTab === 'umum' ? 'bg-white dark:bg-gray-700 text-primary dark:text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white'" class="flex-1 py-4 px-6 rounded-2xl font-bold text-lg transition-all duration-300">Pengajian Umum</button>
                </div>

                <div class="relative min-h-[500px]">
                    <div x-show="activeTab === 'jadwal'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 absolute w-full" x-transition:leave-end="opacity-0 absolute w-full">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div class="relative p-8 rounded-3xl bg-gradient-to-br from-white to-gray-50 dark:from-darkcard dark:to-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:scale-105 transition duration-300 group overflow-hidden">
                                <div class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-emerald-400 to-primary rounded-full opacity-20 group-hover:scale-150 transition duration-500"></div>
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-primary text-white flex items-center justify-center text-2xl mb-6 shadow-lg shadow-emerald-500/30"><i class="fa-solid fa-moon"></i></div>
                                <h4 class="font-extrabold text-xl text-gray-900 dark:text-white mb-2">04.00 - 05.30</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Sholat Tahajud dan Witir, Shubuh Berjama'ah, Balaghah Al-Qur'an, Hapalan</p>
                            </div>
                            <div class="relative p-8 rounded-3xl bg-gradient-to-br from-white to-gray-50 dark:from-darkcard dark:to-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:scale-105 transition duration-300 group overflow-hidden">
                                <div class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-blue-400 to-secondary rounded-full opacity-20 group-hover:scale-150 transition duration-500"></div>
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-secondary text-white flex items-center justify-center text-2xl mb-6 shadow-lg shadow-blue-500/30"><i class="fa-solid fa-bath"></i></div>
                                <h4 class="font-extrabold text-xl text-gray-900 dark:text-white mb-2">05.30 - 06.30</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Giat Pribadi, Sarapan Pagi Persiapan Berangkat ke Sekolah</p>
                            </div>
                            <div class="relative p-8 rounded-3xl bg-gradient-to-br from-white to-gray-50 dark:from-darkcard dark:to-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:scale-105 transition duration-300 group overflow-hidden">
                                <div class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-emerald-400 to-primary rounded-full opacity-20 group-hover:scale-150 transition duration-500"></div>
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-primary text-white flex items-center justify-center text-2xl mb-6 shadow-lg shadow-emerald-500/30"><i class="fa-solid fa-school"></i></div>
                                <h4 class="font-extrabold text-xl text-gray-900 dark:text-white mb-2">07.00 - 16.00</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">KBM di Sekolah Formal dan Kegiatan Ekstrakulikuler</p>
                            </div>
                            <div class="relative p-8 rounded-3xl bg-gradient-to-br from-white to-gray-50 dark:from-darkcard dark:to-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:scale-105 transition duration-300 group overflow-hidden">
                                <div class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-orange-400 to-red-500 rounded-full opacity-20 group-hover:scale-150 transition duration-500"></div>
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-400 to-red-500 text-white flex items-center justify-center text-2xl mb-6 shadow-lg shadow-orange-500/30"><i class="fa-solid fa-utensils"></i></div>
                                <h4 class="font-extrabold text-xl text-gray-900 dark:text-white mb-2">16.00 - 17.45</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Giat Pribadi, Makan Sore, Istirahat, Persiapan Maghrib</p>
                            </div>
                            <div class="relative p-8 rounded-3xl bg-gradient-to-br from-white to-gray-50 dark:from-darkcard dark:to-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:scale-105 transition duration-300 group overflow-hidden">
                                <div class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-full opacity-20 group-hover:scale-150 transition duration-500"></div>
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 text-white flex items-center justify-center text-2xl mb-6 shadow-lg shadow-purple-500/30"><i class="fa-solid fa-book-quran"></i></div>
                                <h4 class="font-extrabold text-xl text-gray-900 dark:text-white mb-2">18.00 - 19.30</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Maghrib Berjama'ah, Pengajian Umum, Isya Berjama'ah</p>
                            </div>
                            <div class="relative p-8 rounded-3xl bg-gradient-to-br from-white to-gray-50 dark:from-darkcard dark:to-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:scale-105 transition duration-300 group overflow-hidden">
                                <div class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-emerald-400 to-primary rounded-full opacity-20 group-hover:scale-150 transition duration-500"></div>
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-primary text-white flex items-center justify-center text-2xl mb-6 shadow-lg shadow-emerald-500/30"><i class="fa-solid fa-mug-hot"></i></div>
                                <h4 class="font-extrabold text-xl text-gray-900 dark:text-white mb-2">19.30 - 20.15</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Waktu Istirahat Bebas</p>
                            </div>
                            <div class="relative p-8 rounded-3xl bg-gradient-to-br from-white to-gray-50 dark:from-darkcard dark:to-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:scale-105 transition duration-300 group overflow-hidden">
                                <div class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-blue-400 to-secondary rounded-full opacity-20 group-hover:scale-150 transition duration-500"></div>
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-secondary text-white flex items-center justify-center text-2xl mb-6 shadow-lg shadow-blue-500/30"><i class="fa-solid fa-book-open-reader"></i></div>
                                <h4 class="font-extrabold text-xl text-gray-900 dark:text-white mb-2">20.20 - 21.45</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Hapalan, Mutola'ah dan Belajar Bersama</p>
                            </div>
                            <div class="relative p-8 rounded-3xl bg-gradient-to-br from-white to-gray-50 dark:from-darkcard dark:to-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:scale-105 transition duration-300 group overflow-hidden">
                                <div class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-gray-600 to-gray-900 rounded-full opacity-20 group-hover:scale-150 transition duration-500"></div>
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-gray-700 to-gray-900 text-white flex items-center justify-center text-2xl mb-6 shadow-lg shadow-gray-900/30"><i class="fa-solid fa-bed"></i></div>
                                <h4 class="font-extrabold text-xl text-gray-900 dark:text-white mb-2">22.00 - 04.00</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Istirahat Malam dan Tidur</p>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="activeTab === 'tingkatan'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 absolute w-full" x-transition:leave-end="opacity-0 absolute w-full" class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full">
                        <div class="bg-gradient-to-br from-emerald-50 to-white dark:from-gray-800 dark:to-darkcard rounded-3xl p-8 lg:p-10 shadow-xl border border-emerald-100 dark:border-gray-700">
                            <h4 class="font-extrabold text-3xl text-primary dark:text-emerald-400 mb-8 border-b-2 border-primary/20 pb-4 text-center">TINGKAT IBTIDA</h4>
                            <ul class="space-y-6 text-center md:text-left">
                                <li><p class="font-bold text-lg text-primary dark:text-emerald-400 mb-1">Tauhid:</p><p class="text-gray-700 dark:text-gray-300 text-lg">Kitab Tijan Ad-Daruri, Majmuatul Aqidah</p></li>
                                <li><p class="font-bold text-lg text-primary dark:text-emerald-400 mb-1">Fiqih:</p><p class="text-gray-700 dark:text-gray-300 text-lg">Kitab Safinah An-Naja & Kitab Safinah Ash-Sholah</p></li>
                                <li><p class="font-bold text-lg text-primary dark:text-emerald-400 mb-1">Akhlaq:</p><p class="text-gray-700 dark:text-gray-300 text-lg">Kitab Akhlak Lil Banin Jilid 1 & 2</p></li>
                                <li><p class="font-bold text-lg text-primary dark:text-emerald-400 mb-1">Alat:</p><p class="text-gray-700 dark:text-gray-300 text-lg">Ilmu Tajwid, Tasrifan & Kitab Matan Bina</p></li>
                            </ul>
                        </div>
                        <div class="bg-gradient-to-br from-emerald-50 to-white dark:from-gray-800 dark:to-darkcard rounded-3xl p-8 lg:p-10 shadow-xl border border-emerald-100 dark:border-gray-700">
                            <h4 class="font-extrabold text-3xl text-secondary dark:text-emerald-400 mb-8 border-b-2 border-secondary/20 pb-4 text-center">TINGKAT TSANAWI</h4>
                            <ul class="space-y-6 text-center md:text-left">
                                <li><p class="font-bold text-lg text-secondary dark:text-emerald-400 mb-1">Tauhid:</p><p class="text-gray-700 dark:text-gray-300 text-lg">Kitab Kifayatul Awam & Kitab Jauhar Tauhid</p></li>
                                <li><p class="font-bold text-lg text-secondary dark:text-emerald-400 mb-1">Fiqih:</p><p class="text-gray-700 dark:text-gray-300 text-lg">Kitab Riyadhul Badiah</p></li>
                                <li><p class="font-bold text-lg text-secondary dark:text-emerald-400 mb-1">Akhlaq:</p><p class="text-gray-700 dark:text-gray-300 text-lg">Kitab Akhlak Lil Banin Jilid 3</p></li>
                                <li><p class="font-bold text-lg text-secondary dark:text-emerald-400 mb-1">Alat:</p><p class="text-gray-700 dark:text-gray-300 text-lg">Ilmu Tajwid, Kitab Jurumiyyah & Kitab Nazhom Maqsud</p></li>
                            </ul>
                        </div>
                    </div>

                    <div x-cloak x-show="activeTab === 'umum'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 absolute w-full" x-transition:leave-end="opacity-0 absolute w-full" class="bg-white dark:bg-darkcard rounded-3xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden w-full">
                        <div class="overflow-x-auto">
                            <table class="w-full text-center text-gray-700 dark:text-gray-300 text-base md:text-lg">
                                <thead class="bg-gradient-to-r from-primary to-secondary text-white font-bold">
                                    <tr>
                                        <th class="px-6 py-5 text-center">Hari & Waktu</th>
                                        <th class="px-6 py-5 text-center">Materi / Kitab</th>
                                        <th class="px-6 py-5 text-center">Pengajar (Klik Nama)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"><td class="px-6 py-4 font-semibold text-primary dark:text-emerald-400">Senin Ba'da Maghrib</td><td class="px-6 py-4">Pengajian Tingkatan Fan Ilmu Alat</td><td class="px-6 py-4">-</td></tr>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"><td class="px-6 py-4 font-semibold text-primary dark:text-emerald-400">Selasa Ba'da Maghrib</td><td class="px-6 py-4">Pengajian Tingkatan Fan Ilmu Fiqih</td><td class="px-6 py-4">-</td></tr>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"><td class="px-6 py-4 font-semibold text-primary dark:text-emerald-400">Rabu Maghrib</td><td class="px-6 py-4">Kitab Ta'lim Muta'lim</td><td class="px-6 py-4"><button @click="modalOpen = true; modalName = 'Ust. Ali Muzaki, S.Pd'; modalImg = '{{ asset('images/asatidz/ust-ali.jpg') }}'" class="font-bold text-secondary hover:text-primary dark:hover:text-white underline decoration-dashed decoration-2 underline-offset-4 cursor-pointer">Ust. Ali Muzaki, S.Pd</button></td></tr>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"><td class="px-6 py-4 font-semibold text-primary dark:text-emerald-400">Kamis Maghrib</td><td class="px-6 py-4">Kitab Sulamutaufiq</td><td class="px-6 py-4"><button @click="modalOpen = true; modalName = 'Drs. KH. Hasyim Al-Ihsan'; modalImg = '{{ asset('images/asatidz/ust-hasyim.jpg') }}'" class="font-bold text-secondary hover:text-primary dark:hover:text-white underline decoration-dashed decoration-2 underline-offset-4 cursor-pointer">Drs. KH. Hasyim Al-Ihsan</button></td></tr>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"><td class="px-6 py-4 font-semibold text-primary dark:text-emerald-400">Kamis Isya</td><td class="px-6 py-4">Nadzom Sulamuttaufiq</td><td class="px-6 py-4"><button @click="modalOpen = true; modalName = 'Ust. Abdul Qadir, S.Pd'; modalImg = '{{ asset('images/asatidz/ust-kodir.jpg') }}'" class="font-bold text-secondary hover:text-primary dark:hover:text-white underline decoration-dashed decoration-2 underline-offset-4 cursor-pointer">Ust. Abdul Qadir, S.Pd</button></td></tr>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"><td class="px-6 py-4 font-semibold text-primary dark:text-emerald-400">Jum'at Maghrib</td><td class="px-6 py-4">Riyadhoh & Yasin</td><td class="px-6 py-4"><button @click="modalOpen = true; modalName = 'Ust. Faisal Nazmudin'; modalImg = '{{ asset('images/asatidz/ust-faisal.jpg') }}'" class="font-bold text-secondary hover:text-primary dark:hover:text-white underline decoration-dashed decoration-2 underline-offset-4 cursor-pointer">Ust. Faisal Nazmudin</button></td></tr>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"><td class="px-6 py-4 font-semibold text-primary dark:text-emerald-400">Jum'at Ba'da Shubuh</td><td class="px-6 py-4">Pengajian Tingkatan Fan Ilmu Tauhid</td><td class="px-6 py-4">-</td></tr>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"><td class="px-6 py-4 font-semibold text-primary dark:text-emerald-400">Sabtu</td><td class="px-6 py-4">Kitab Akhlakul Lil Banin</td><td class="px-6 py-4"><button @click="modalOpen = true; modalName = 'Ust. Faiq Helmi, S.S'; modalImg = '{{ asset('images/asatidz/ust-faiq.jpg') }}'" class="font-bold text-secondary hover:text-primary dark:hover:text-white underline decoration-dashed decoration-2 underline-offset-4 cursor-pointer">Ust. Faiq Helmi, S.S</button></td></tr>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"><td class="px-6 py-4 font-semibold text-primary dark:text-emerald-400">Sabtu Isya</td><td class="px-6 py-4">Lughoh A'robiyyah</td><td class="px-6 py-4"><button @click="modalOpen = true; modalName = 'Ust. Rahman Pasatrio, S.Pd'; modalImg = '{{ asset('images/asatidz/ust-rahman.jpg') }}'" class="font-bold text-secondary hover:text-primary dark:hover:text-white underline decoration-dashed decoration-2 underline-offset-4 cursor-pointer">Ust. Rahman Pasatrio, S.Pd</button></td></tr>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"><td class="px-6 py-4 font-semibold text-primary dark:text-emerald-400">Sabtu Ba'da Shubuh</td><td class="px-6 py-4">Pengajian Tingkatan Fan Ilmu Alat</td><td class="px-6 py-4">-</td></tr>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"><td class="px-6 py-4 font-semibold text-primary dark:text-emerald-400">Sabtu Ba'da Ashar</td><td class="px-6 py-4">Seni Kalighrafi</td><td class="px-6 py-4"><button @click="modalOpen = true; modalName = 'Ust. Roby Sughara, S.Pd'; modalImg = '{{ asset('images/asatidz/ust-robi.jpg') }}'" class="font-bold text-secondary hover:text-primary dark:hover:text-white underline decoration-dashed decoration-2 underline-offset-4 cursor-pointer">Ust. Roby Sughara, S.Pd</button></td></tr>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"><td class="px-6 py-4 font-semibold text-primary dark:text-emerald-400">Ahad Maghrib</td><td class="px-6 py-4">Qiroat & Murotal</td><td class="px-6 py-4"><button @click="modalOpen = true; modalName = 'Ust. Romi Ahmad H., S.Pd'; modalImg = '{{ asset('images/asatidz/ust-romi.jpg') }}'" class="font-bold text-secondary hover:text-primary dark:hover:text-white underline decoration-dashed decoration-2 underline-offset-4 cursor-pointer">Ust. Romi Ahmad H., S.Pd</button></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="layanan" class="py-24 bg-gray-50 dark:bg-gray-900 transition-colors duration-700">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white">Layanan Digital Integrasi</h2>
                <div class="w-24 h-1.5 bg-secondary mx-auto mt-6 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div data-aos="fade-up" data-aos-delay="100" class="bg-white dark:bg-darkcard rounded-3xl shadow-xl p-10 text-center hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-b-8 border-green-500">
                    <div class="w-24 h-24 mx-auto bg-green-50 dark:bg-green-900/20 text-green-500 rounded-full flex items-center justify-center text-5xl mb-8"><i class="fa-solid fa-wallet"></i></div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Cek Tagihan SPP</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 text-lg leading-relaxed">Informasi Tagihan, Pembayaran dan Riwayat Pembayaran SPP.</p>
                    <a href="{{ route('spp.index') }}" class="inline-block w-full bg-green-500 hover:bg-green-600 text-white font-bold text-lg py-4 rounded-xl transition-colors text-center">Buka Portal SPP</a>
                </div>

                <div data-aos="fade-up" data-aos-delay="200" class="bg-white dark:bg-darkcard rounded-3xl shadow-xl p-10 text-center hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-b-8 border-blue-500">
                    <div class="w-24 h-24 mx-auto bg-blue-50 dark:bg-blue-900/20 text-blue-500 rounded-full flex items-center justify-center text-5xl mb-8"><i class="fa-solid fa-wifi"></i></div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Beli Voucher Wi-Fi</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 text-lg leading-relaxed">Beli Paket Internet Harian, Mingguan, dan Bulanan.</p>
                    <button class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold text-lg py-4 rounded-xl transition-colors">Beli Sekarang</button>
                </div>

                <div data-aos="fade-up" data-aos-delay="300" class="bg-white dark:bg-darkcard rounded-3xl shadow-xl p-10 text-center hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-b-8 border-purple-500">
                    <div class="w-24 h-24 mx-auto bg-purple-50 dark:bg-purple-900/20 text-purple-500 rounded-full flex items-center justify-center text-5xl mb-8"><i class="fa-solid fa-book-open"></i></div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Materi Pembelajaran</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 text-lg leading-relaxed">Akses materi pembelajaran yang dibuat oleh asatidz dan santri.</p>
                    <a href="{{ route('mading.index') }}" class="inline-block w-full bg-purple-500 hover:bg-purple-600 text-white font-bold text-lg py-4 rounded-xl transition-colors text-center">Mulai Membaca</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-[#0f172a] text-gray-300 pt-20 pb-10">
        <div class="container mx-auto px-6 max-w-7xl grid grid-cols-1 md:grid-cols-3 gap-16 mb-16">
            <div>
                <h4 class="text-3xl font-bold text-white mb-6 flex items-center tracking-tight">
                    <img src="{{ asset('images/logo-ponpes.png') }}" alt="Logo" class="w-10 h-10 mr-4 rounded-full bg-white p-1"> Ponpes Al-Amin
                </h4>
                <p class="mb-8 text-base leading-relaxed text-gray-400">Mendidik generasi Islami yang cerdas, mandiri, dan melek teknologi berlandaskan Al-Qur'an dan Sunnah.</p>
                <div class="flex space-x-4">
                    <a href="https://www.facebook.com/share/18BdDnC1Ng/" target="_blank" class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center hover:bg-blue-600 text-white transition-all"><i class="fa-brands fa-facebook-f text-xl"></i></a>
                    <a href="https://www.instagram.com/ponpes_alamin_sempu?igsh=bHN2MmR0eDQxbnJx" target="_blank" class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center hover:bg-pink-600 text-white transition-all"><i class="fa-brands fa-instagram text-xl"></i></a>
                    <a href="https://youtube.com/@ponpesprojects99?si=9sl9w8wCv6O7DJqW" target="_blank" class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center hover:bg-red-600 text-white transition-all"><i class="fa-brands fa-youtube text-xl"></i></a>
                </div>
            </div>

            <div>
                <h4 class="text-xl font-bold text-white mb-6">Kontak Kami</h4>
                <ul class="space-y-6 text-base text-gray-400">
                    <li class="flex items-start"><i class="fa-solid fa-location-dot mt-1.5 mr-4 text-emerald-400 text-xl"></i> Jl. Industri Kp. Sempu Gardu RT.04/02 Desa Pasir Gombong Cikarang Utara, Bekasi</li>
                    <li class="flex items-center"><i class="fa-solid fa-phone mr-4 text-emerald-400 text-lg"></i> Ust. Faisal : +62 857-7335-3921</li>
                    <li class="flex items-center"><i class="fa-solid fa-phone mr-4 text-emerald-400 text-lg"></i> Ust. Romi : +62 858-1454-8293</li>
                </ul>
            </div>

            <div>
                <h4 class="text-xl font-bold text-white mb-6">Lokasi Pesantren</h4>
                <div class="w-full h-56 rounded-2xl overflow-hidden border border-gray-700 shadow-lg relative group">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.736868641981!2d107.1517409741829!3d-6.298285961642875!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e699b8004f260ef%3A0xc3c9428c0570be0b!2sPonpes%20Al-Amin%20Sempu!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0" class="grayscale hover:grayscale-0 transition duration-700"></iframe>
                    <a href="https://share.google/HyP4MhUORAj2iwq9m" target="_blank" class="absolute inset-0 z-10 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-black/60 backdrop-blur-sm transition-all duration-300">
                        <span class="bg-primary text-white px-6 py-3 rounded-full font-bold shadow-xl flex items-center"><i class="fa-solid fa-map-location-dot mr-3"></i>Buka Google Maps</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-800 pt-8 text-center text-sm text-gray-500">
            <p>© 2026 Pondok Pesantren Al-Amin.</p>
            <p>Powered by PonpesProjects</p>
        </div>
    </footer>

    <div x-cloak x-show="profilModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm p-4" aria-modal="true">
        <div x-show="profilModalOpen" 
             @click.outside="profilModalOpen = false"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-8 scale-95"
             class="relative w-full max-w-3xl max-h-[90vh] overflow-y-auto bg-white dark:bg-darkcard rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8 md:p-12">
            
            <button @click="profilModalOpen = false" class="absolute top-6 right-6 text-gray-400 hover:text-red-500 transition-colors focus:outline-none"><i class="fa-solid fa-xmark text-3xl"></i></button>
            
            <div class="text-justify text-gray-700 dark:text-gray-300">
                <p class="text-3xl font-arabic mb-8 text-center text-primary dark:text-emerald-400">بِسْمِ اللهِ الرَّحْمَنِ الرَّحِيمِ</p>
                <p class="text-lg leading-loose mb-6">
                    Puji syukur kehadirat Allah, sholawat serta salam semoga senantiasa tercurahkan kepada Rosululloh SAW. Alhamdulillah Pondok Pesantren Al-Amin telah hadir di tengah masyarakat yang Insya Allah akan menjadi lembaga Islam yang dapat membantu dan mencetak generasi muslim yang berakhlakul karimah dan berilmu tinggi.
                </p>
                <p class="text-lg leading-loose mb-6">
                    Ponpes Al-Amin adalah lembaga Pendidikan Islam berbasis masyarakat yang menyelenggarakan Pendidikan Islam dengan kajian kitab-kitab kuning. Didirikan pada tanggal <strong>17 Januari 2016</strong> oleh <strong>Drs. KH. Hasyim Al-Ihsan</strong> beserta pihak yang membantu dari penasehat, pengurus Yayasan, Asatidz, dan Dewan Guru.
                </p>
                <p class="text-lg leading-loose">
                    Mudah-mudahan dengan hadirnya Pondok Pesantren Islam Al-Amin ini menjadi lembaga yang bermanfaat dan dapat menyampaikan kajian ilmu-ilmu agama yang dibutuhkan masyarakat, sehingga dapat membentuk generasi penerus Islam yang berilmu dan berakhlakul karimah. Aamiin.
                </p>
            </div>
            
            <button @click="profilModalOpen = false" class="w-full mt-10 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-800 dark:text-white font-bold py-4 rounded-xl transition-colors">Tutup Profil</button>
        </div>
    </div>

    <div x-cloak x-show="modalOpen" class="fixed inset-0 z-[110] flex items-center justify-center bg-black/70 backdrop-blur-sm p-4" aria-modal="true">
        <div x-show="modalOpen" 
             @click.outside="modalOpen = false"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-4 scale-95"
             class="relative w-full max-w-sm p-8 bg-white dark:bg-darkcard rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 text-center">
            
            <button @click="modalOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors focus:outline-none"><i class="fa-solid fa-xmark text-2xl"></i></button>
            
            <div class="mt-4 mb-2">
                <img :src="modalImg" onerror="this.src='https://ui-avatars.com/api/?name=Ustaz&background=065f46&color=fff&size=200'" alt="Foto Asatidz" class="w-32 h-32 mx-auto rounded-full object-cover ring-8 ring-emerald-50 dark:ring-gray-800 mb-6 shadow-lg">
                <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white mb-2" x-text="modalName"></h3>
                <p class="text-sm text-primary dark:text-emerald-400 font-bold bg-emerald-50 dark:bg-gray-800 inline-block px-4 py-1.5 rounded-full">Mudarris Ma'had</p>
            </div>
            
            <button @click="modalOpen = false" class="w-full mt-8 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-800 dark:text-white font-bold py-3 rounded-xl transition-colors">Tutup</button>
        </div>
    </div>

    <div class="fixed bottom-8 right-8 z-50">
        <div x-cloak x-show="chatOpen" 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-8 scale-95"
             class="mb-6 w-80 sm:w-96 bg-white dark:bg-darkcard rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col">
            
            <div class="bg-primary p-5 text-white flex justify-between items-center shadow-md z-10">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center"><i class="fa-solid fa-robot text-xl"></i></div>
                    <div>
                        <h4 class="font-bold text-base">Bot Al-Amin</h4>
                        <p class="text-xs text-emerald-200 flex items-center"><span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span> Online</p>
                    </div>
                </div>
                <button @click="chatOpen = false" class="text-white/70 hover:text-white transition-colors focus:outline-none"><i class="fa-solid fa-xmark text-2xl"></i></button>
            </div>
            
            <div x-ref="chatContainer" class="p-5 bg-gray-50 dark:bg-gray-800/50 h-72 overflow-y-auto space-y-4 text-base scroll-smooth">
                <template x-for="(msg, index) in messages" :key="index">
                    <div class="flex items-start space-x-3" :class="msg.sender === 'user' ? 'flex-row-reverse space-x-reverse' : ''">
                        
                        <div x-show="msg.sender === 'bot'" class="w-8 h-8 rounded-full bg-primary flex items-center justify-center shrink-0 text-white text-xs shadow-sm">
                            <i class="fa-solid fa-robot"></i>
                        </div>

                        <div class="p-4 rounded-2xl shadow-sm max-w-[85%] text-sm leading-relaxed"
                             :class="msg.sender === 'user' 
                                ? 'bg-primary text-white rounded-tr-sm border border-emerald-700' 
                                : 'bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 border border-gray-100 dark:border-gray-600 rounded-tl-sm'"
                             x-html="msg.text">
                        </div>
                    </div>
                </template>
            </div>
            
            <div class="p-4 bg-white dark:bg-darkcard border-t dark:border-gray-700 flex items-center space-x-3">
                <input type="text" 
                       x-model="newMessage"
                       @keydown.enter="sendMessage()"
                       placeholder="Ketik pesan..." 
                       class="w-full bg-gray-100 dark:bg-gray-800 dark:text-white border-transparent focus:border-primary focus:bg-white dark:focus:bg-gray-700 rounded-full px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all">
                <button @click="sendMessage()" 
                        class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center hover:bg-emerald-700 transition-colors shadow-md shrink-0 focus:outline-none">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
        </div>

        <button @click="chatOpen = !chatOpen" class="w-16 h-16 bg-emerald-500 text-white rounded-full flex items-center justify-center text-3xl shadow-2xl shadow-emerald-500/40 hover:bg-emerald-600 hover:scale-110 transition-all duration-300 relative focus:outline-none">
            <i class="fa-brands fa-whatsapp" x-show="!chatOpen" x-transition></i>
            <i class="fa-solid fa-xmark text-2xl" x-cloak x-show="chatOpen" x-transition></i>
            <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-30 animate-ping"></span>
        </button>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 50, duration: 1200, easing: 'ease-out-cubic' });

        document.addEventListener('alpine:init', () => {
            Alpine.data('appData', () => ({
                darkMode: localStorage.getItem('theme') === 'dark', 
                mobileMenuOpen: false, 
                chatOpen: false, 
                modalOpen: false, 
                modalName: '', 
                modalImg: '', 
                profilModalOpen: false,

                newMessage: '',
                messages: [
                    { 
                        sender: 'bot', 
                        text: 'اَلسَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُهُ<br>Selamat datang di Website Ponpes Al-Amin. Ada yang bisa kami bantu hari ini?' 
                    }
                ],

                scrollToBottom() {
                    setTimeout(() => {
                        const container = this.$refs.chatContainer;
                        if(container) container.scrollTop = container.scrollHeight;
                    }, 50);
                },

                sendMessage() {
                    if (this.newMessage.trim() === '') return;

                    const userText = this.newMessage;
                    this.messages.push({ sender: 'user', text: userText });
                    this.newMessage = ''; 
                    this.scrollToBottom();

                    setTimeout(() => {
                        const textLower = userText.toLowerCase();
                        let botReply = 'Maaf, saya belum mengerti pertanyaan tersebut. Silakan hubungi Ust. Faisal di nomor +62 857-7335-3921 untuk informasi lebih akurat.';

                        if (textLower.includes('spp') || textLower.includes('tagihan') || textLower.includes('bayar')) {
                            botReply = 'Untuk mengecek atau membayar tagihan SPP, silakan klik menu <strong>Cek Tagihan SPP</strong> di bagian Layanan Digital, atau langsung login ke portal admin.';
                        } else if (textLower.includes('daftar') || textLower.includes('pendaftaran') || textLower.includes('masuk')) {
                            botReply = 'Pendaftaran santri baru saat ini dapat dilakukan dengan datang langsung ke sekertariat Ponpes Al-Amin di Jl. Industri Kp. Sempu Gardu.';
                        } else if (textLower.includes('assalamualaikum') || textLower.includes('salam') || textLower.includes('halo') || textLower.includes('hai')) {
                            botReply = 'Waalaikumsalam warahmatullahi wabarakatuh. Ada yang ingin ditanyakan seputar kegiatan atau layanan Ponpes Al-Amin?';
                        } else if (textLower.includes('wifi') || textLower.includes('internet') || textLower.includes('voucher')) {
                            botReply = 'Untuk pembelian voucher Wi-Fi (Harian/Mingguan/Bulanan), santri bisa langsung membelinya melalui pengurus pondok di asrama.';
                        } else if (textLower.includes('ustadz') || textLower.includes('guru') || textLower.includes('kyai')) {
                            botReply = 'Ponpes Al-Amin dibina langsung oleh Drs. KH Hasyim Al-Ihsan dan dewan asatidz lainnya. Anda bisa melihat profil lengkapnya di bagian "Dewan Asatidz" pada halaman utama ini.';
                        }

                        this.messages.push({ sender: 'bot', text: botReply });
                        this.scrollToBottom();
                    }, 1000);
                }
            }))
        })
    </script>
</body>
</html>
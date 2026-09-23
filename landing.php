<?php
// Landing page - Inventaris DKP3
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventaris ATK - DKP3 Kota Banjarbaru</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            600: '#059669',
                            700: '#047857',
                            800: '#1e7256', // Warna DKP3
                            900: '#064e3b',
                        }
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        .glass-nav {
            background: rgba(30, 114, 86, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .hero-pattern {
            background-color: #1e7256;
        }
    </style>
</head>
<body class="font-sans text-gray-800 antialiased">

    <header id="navbar" class="fixed top-0 w-full z-50 transition-all duration-300 ease-in-out py-4">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center gap-3" data-aos="fade-down">
                <img src="assets/logo.png" alt="DKP3 Logo" class="h-10 w-auto filter drop-shadow-lg" onerror="this.style.display='none'">
                <div class="text-white">
                    <h1 class="text-lg font-bold leading-tight tracking-wide">DKP3 INVENTARIS</h1>
                    <p class="text-[10px] text-emerald-100 opacity-90 tracking-wider">KOTA BANJARBARU</p>
                </div>
            </div>

            <nav class="hidden md:flex items-center gap-8" data-aos="fade-down" data-aos-delay="100">
                <a href="#fitur" class="text-white hover:text-emerald-200 transition text-sm font-medium">Fitur</a>
                <a href="#kontak" class="text-white hover:text-emerald-200 transition text-sm font-medium">Kontak</a>
                <a href="login.php" class="bg-white text-emerald-800 px-6 py-2.5 rounded-full font-semibold text-sm hover:bg-emerald-50 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    <i class="fas fa-sign-in-alt me-2"></i>Login Sistem
                </a>
            </nav>
        </div>
    </header>

    <section class="relative min-h-screen flex items-center justify-center hero-pattern overflow-hidden">
        <div class="absolute inset-0 z-0">
             <img src="assets/bg_gedung.png" alt="Kantor DKP3" class="w-full h-full object-cover opacity-60" onerror="this.style.display='none'">
            <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/90 via-emerald-800/50 to-emerald-900/60"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center pt-20">
            <span class="inline-block py-1 px-3 rounded-full bg-emerald-700/50 border border-emerald-500 text-emerald-100 text-xs font-semibold mb-6 backdrop-blur-sm" data-aos="fade-down">
                Sistem Manajemen Terpadu
            </span>
            
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight" data-aos="fade-up" data-aos-delay="100">
                Kelola Inventaris ATK <br> 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-200 to-white">Lebih Efisien</span>
            </h1>
            
            <p class="text-lg md:text-xl text-emerald-100 mb-10 max-w-2xl mx-auto font-light leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                Platform digital resmi Dinas Ketahanan Pangan, Pertanian dan Perikanan Kota Banjarbaru untuk monitoring stok dan pelaporan aset secara real-time.
            </p>
            
            <div class="flex flex-col md:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="300">
                <a href="login.php" class="bg-white text-emerald-800 px-8 py-4 rounded-xl font-bold hover:bg-emerald-50 transition shadow-xl hover:shadow-2xl flex items-center justify-center gap-2 group">
                    Mulai Sekarang
                    <i data-feather="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#fitur" class="px-8 py-4 rounded-xl font-semibold text-white border border-emerald-400 hover:bg-emerald-800/50 transition flex items-center justify-center">
                    Pelajari Lebih Lanjut
                </a>
            </div>
            
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto border-t border-emerald-700/50 pt-8" data-aos="fade-up" data-aos-delay="500">
                <div>
                    <h4 class="text-3xl font-bold text-white">100%</h4>
                    <p class="text-xs text-emerald-300 uppercase tracking-wider">Digital</p>
                </div>
                <div>
                    <h4 class="text-3xl font-bold text-white">24/7</h4>
                    <p class="text-xs text-emerald-300 uppercase tracking-wider">Akses Data</p>
                </div>
                <div>
                    <h4 class="text-3xl font-bold text-white">Realtime</h4>
                    <p class="text-xs text-emerald-300 uppercase tracking-wider">Monitoring</p>
                </div>
                <div>
                    <h4 class="text-3xl font-bold text-white">Secure</h4>
                    <p class="text-xs text-emerald-300 uppercase tracking-wider">Data Privacy</p>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-24 bg-white relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 max-w-2xl mx-auto">
                <h2 class="text-emerald-800 font-bold text-3xl md:text-4xl mb-4" data-aos="fade-up">Fitur Unggulan</h2>
                <div class="h-1 w-20 bg-emerald-500 mx-auto rounded-full mb-4"></div>
                <p class="text-gray-600" data-aos="fade-up" data-aos-delay="100">
                    Dirancang khusus untuk memudahkan administrasi dan pelaporan barang di lingkungan dinas.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-10">
                <div class="group p-8 rounded-2xl bg-white border border-gray-100 shadow-lg hover:shadow-xl transition-all hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 transition-colors duration-300">
                        <i data-feather="database" class="text-emerald-600 w-7 h-7 group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Database Terpusat</h3>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        Semua data barang masuk, keluar, dan sisa stok tersimpan dalam satu database yang aman dan mudah diakses.
                    </p>
                </div>

                <div class="group p-8 rounded-2xl bg-white border border-gray-100 shadow-lg hover:shadow-xl transition-all hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 transition-colors duration-300">
                        <i data-feather="printer" class="text-emerald-600 w-7 h-7 group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Cetak Laporan Otomatis</h3>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        Hasilkan laporan bulanan atau tahunan dalam format PDF siap cetak hanya dengan sekali klik.
                    </p>
                </div>

                <div class="group p-8 rounded-2xl bg-white border border-gray-100 shadow-lg hover:shadow-xl transition-all hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 transition-colors duration-300">
                        <i data-feather="sliders" class="text-emerald-600 w-7 h-7 group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Manajemen Stok</h3>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        Peringatan otomatis ketika stok barang menipis untuk memastikan ketersediaan ATK selalu terjaga.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <footer id="kontak" class="bg-emerald-900 text-white pt-20 pb-10">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-12 border-b border-emerald-800 pb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="assets/logo.png" alt="Logo" class="h-12 w-auto brightness-200 grayscale-0" onerror="this.style.display='none'">
                        <div>
                            <h3 class="text-xl font-bold">DKP3 Banjarbaru</h3>
                            <p class="text-xs text-emerald-400 tracking-widest">INVENTARIS SYSTEM</p>
                        </div>
                    </div>
                    <p class="text-emerald-200 text-sm leading-relaxed max-w-sm">
                        Jl. KH Agus Salim, Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjar Baru, Kalimantan Selatan 70711
                    </p>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-6">Hubungi Kami</h4>
                    <ul class="space-y-4 text-emerald-200 text-sm">
                        <li class="flex items-start gap-3">
                            <i data-feather="phone" class="w-4 h-4 mt-1"></i>
                            <span>(0511) 4781050</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i data-feather="mail" class="w-4 h-4 mt-1"></i>
                            <span>dkp3@banjarbarukota.go.id</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i data-feather="globe" class="w-4 h-4 mt-1"></i>
                            <span>www.dkp3.banjarbarukota.go.id</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-6">Sosial Media</h4>
                    <div class="flex gap-4">
                        <a href="https://www.facebook.com/dkp3.kotabanjarbaru/" class="w-10 h-10 rounded-full bg-emerald-800 flex items-center justify-center hover:bg-white hover:text-emerald-900 transition-all">
                            <i data-feather="facebook" class="w-5 h-5"></i>
                        </a>
                        <a href="https://www.instagram.com/dkp3kotabanjarbaru/" class="w-10 h-10 rounded-full bg-emerald-800 flex items-center justify-center hover:bg-white hover:text-emerald-900 transition-all">
                            <i data-feather="instagram" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-emerald-800 flex items-center justify-center hover:bg-white hover:text-emerald-900 transition-all">
                            <i data-feather="youtube" class="w-5 h-5"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="pt-8 text-center">
                <p class="text-emerald-400 text-sm">
                    &copy; 2026 Dinas Ketahanan Pangan, Pertanian dan Perikanan Kota Banjarbaru. <br class="md:hidden"> All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Init Icons
        feather.replace();
        
        // Init Animation
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });

        // Navbar Scroll Effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('glass-nav', 'py-2');
                navbar.classList.remove('py-4');
            } else {
                navbar.classList.remove('glass-nav', 'py-2');
                navbar.classList.add('py-4');
            }
        });
    </script>
</body>
</html>

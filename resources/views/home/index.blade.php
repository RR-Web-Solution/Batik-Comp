<!DOCTYPE html>

<html lang="id" style="">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Bean &amp; Brew - Company Profile</title>
    <!-- Bootstrap 5.3 CSS -->
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" rel="stylesheet" />
    <!-- Font Awesome -->
    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        referrerpolicy="no-referrer" rel="stylesheet" />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Source+Serif+4:wght@400;600;700&amp;family=Work+Sans:wght@400;600&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- <style>
        :root {
            --bs-body-font-family: 'Work Sans', sans-serif;
            --bs-heading-font-family: 'Source Serif 4', serif;

            /* Theme Colors from Artisanal Brew Aesthetic */
            --bs-primary: #32170d;
            --bs-primary-rgb: 50, 23, 13;
            --bs-primary-container: #4b2c20;
            --bs-on-primary-container: #bf9282;

            --bs-secondary: #675d54;
            --bs-secondary-container: #ebddd2;

            --bs-tertiary-fixed: #fcdccd;

            --bs-body-bg: #fbf9f7;
            /* surface */
            --bs-body-color: #1b1c1b;
            /* on-surface */
            --bs-surface-variant: #e4e2e0;
            --bs-on-surface-variant: #504440;

            --bs-surface-lowest: #ffffff;
            --bs-surface-low: #f5f3f1;
            --bs-surface-high: #eae8e6;

            --bs-border-color: #d5c3bd;
            /* outline-variant */
            --bs-outline: #83746f;
        }

        body {
            font-family: var(--bs-body-font-family);
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
            padding-top: 64px;
            /* For fixed header */
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .navbar-brand,
        .display-font {
            font-family: var(--bs-heading-font-family);
        }

        .text-primary-custom {
            color: var(--bs-primary);
        }

        .text-secondary-custom {
            color: var(--bs-on-surface-variant);
        }

        .bg-surface-lowest {
            background-color: var(--bs-surface-lowest);
        }

        .bg-surface-low {
            background-color: var(--bs-surface-low);
        }

        .bg-surface-high {
            background-color: var(--bs-surface-high);
        }

        .bg-secondary-container {
            background-color: var(--bs-secondary-container);
        }

        .border-outline-variant {
            border-color: var(--bs-border-color) !important;
        }

        .ambient-shadow {
            box-shadow: 0 4px 20px -2px rgba(43, 26, 17, 0.05);
        }

        .btn-primary-custom {
            background-color: var(--bs-primary);
            color: white;
            font-weight: 600;
            font-family: var(--bs-body-font-family);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 12px;
            border: none;
            border-radius: 0.25rem;
            transition: background-color 0.2s;
        }

        .btn-primary-custom:hover {
            background-color: var(--bs-primary-container);
            color: white;
        }

        .icon-box {
            width: 48px;
            height: 48px;
            background-color: var(--bs-tertiary-fixed);
            color: var(--bs-primary-container);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.25rem;
        }

        .footer-link {
            color: var(--bs-on-surface-variant);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-link:hover {
            color: var(--bs-primary);
            text-decoration: underline;
        }

        .label-caps {
            font-family: var(--bs-body-font-family);
            font-size: 12px;
            line-height: 16px;
            letter-spacing: 0.08em;
            font-weight: 600;
            text-transform: uppercase;
        }

        .product-card {
            transition: box-shadow 0.3s ease;
        }

        .product-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .product-img-wrapper {
            overflow: hidden;
            background-color: var(--bs-surface-low);
        }

        .product-img {
            transition: transform 0.5s ease-out;
        }

        .product-card:hover .product-img {
            transform: scale(1.05);
        }
    </style> --}}
    <style class="">
        .dropdown-toggle::after {
            display: none !important;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="padding-top: 64px;">
    <!-- Navbar -->
    <header class="bg-surface-lowest border-bottom border-outline-variant fixed-top">
        <div class="container-xl d-flex justify-content-between align-items-center" style="height: 64px;">
            <a class="navbar-brand d-flex align-items-center gap-2 text-primary-custom fw-bold fs-4 m-0 text-decoration-none"
                href="{{ route('home') }}">
                <img alt="Bean &amp; Brew Logo"
                    src="https://lh3.googleusercontent.com/aida/AP1WRLudyyAt8ZB7awYRpuMI8z_Ab8YR0g9GymAfD2P3xCExUbi25yI7a5cGKjLUBeCOMNx1Wh77h02NCOpRefLSZINF1gWeffMZ9heVzLZAo2XsT6ds893HEFBppohD73ilcoU8z7aNmNDGhfEp0PidH5lP0l-2kbxGM1C8MebAMSsZGDp5YRpqyAQERY2LO0zRRr28TgyY_hWTBRSszOHASJi8KJjA1xXlNLgnaIkqBEsbDZEVNsgm79dBqa4"
                    style="height: 32px; width: auto; object-fit: contain;" />
            </a>
            <div class="dropdown">
                <button aria-expanded="false"
                    class="btn btn-link text-primary-custom p-2 border-0 fs-5 dropdown-toggle text-decoration-none"
                    data-bs-toggle="dropdown" type="button">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end ambient-shadow border-outline-variant">
                    <li class=""><a class="dropdown-item text-primary-custom fw-semibold"
                            href="{{ route('product.index') }}">Produk</a></li>
                </ul>
            </div>
        </div>
    </header>
    <!-- Main Content Canvas -->
    <main class="d-flex flex-column gap-5 mb-5">
        <!-- Hero Section -->
        <section class="container-xl mt-4">
            <div class="row align-items-center g-4 flex-column-reverse flex-md-row">
                <div class="col-12 col-md-6 text-center text-md-start">
                    <h1 class="display-4 fw-bold text-primary-custom mb-3">Seni Memanggang Kopi yang Sempurna</h1>
                    <p class="fs-5 text-secondary-custom mb-4">Mendedikasikan diri untuk menghadirkan pengalaman kopi
                        terbaik dari biji pilihan hingga ke cangkir Anda. Nikmati kehangatan dalam setiap tegukan.</p>
                    <a class="btn btn-primary-custom py-2 px-4" href="{{ route('product.index') }}">
                        Lihat Koleksi Kami
                    </a>
                </div>
                <div class="col-12 col-md-6">
                    <img alt="Coffee Pouring" class="img-fluid rounded-4 ambient-shadow w-100 object-fit-cover"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuB4yw85mpwi7VFPzFO0WTIWHL6F4Sl8lf5pMDZ52t-MuMmVkSt1yIoG0MBLWhnqfxgFmjMpmAHGmOlGainJjGcgFTAev49kZfjJAmY7vS-y22nJrtAovdqBlNsAs1Jg3FiSfs6juXXp5PM2MUOJS4CUC6AR5PyMOS-EiyOcSYZBM9XO4ferjaEmfS8O9-tEhBnz4ckJZTA69a5ARxcpZI7XQEnM7rBZcOS7e6SaokBAfmTbLZJz6swv"
                        style="aspect-ratio: 4/3;" />
                </div>
            </div>
        </section>
        <!-- About Section -->
        <section class="container-xl" id="tentang">
            <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 p-md-5 ambient-shadow">
                <div class="row g-4 align-items-center">
                    <div class="col-12 col-lg-5 text-center">
                        <img alt="Bean &amp; Brew Logo" class="img-fluid"
                            src="https://lh3.googleusercontent.com/aida/AP1WRLudyyAt8ZB7awYRpuMI8z_Ab8YR0g9GymAfD2P3xCExUbi25yI7a5cGKjLUBeCOMNx1Wh77h02NCOpRefLSZINF1gWeffMZ9heVzLZAo2XsT6ds893HEFBppohD73ilcoU8z7aNmNDGhfEp0PidH5lP0l-2kbxGM1C8MebAMSsZGDp5YRpqyAQERY2LO0zRRr28TgyY_hWTBRSszOHASJi8KJjA1xXlNLgnaIkqBEsbDZEVNsgm79dBqa4"
                            style="max-width: 250px;" />
                    </div>
                    <div class="col-12 col-lg-7">
                        <h2 class="fw-bold text-primary-custom mb-3">Tentang Perusahaan</h2>
                        <p class="text-secondary-custom mb-0">Bean &amp; Brew berawal dari kecintaan sederhana terhadap
                            kopi berkualitas. Berdiri sejak tahun 2018, kami telah berkembang dari sebuah kedai kecil
                            menjadi rumah roasting artisanal yang dipercaya oleh para penikmat kopi. Warisan kami
                            dibangun di atas dedikasi terhadap kualitas, hubungan langsung dengan petani, dan komitmen
                            untuk mengeksplorasi potensi penuh dari setiap biji kopi.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Vision & Mission -->
        <section class="container-xl">
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <div
                        class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow h-100 d-flex flex-column gap-3">
                        <div class="icon-box"><i class="fa-solid fa-eye fs-4"></i></div>
                        <h3 class="fs-4 fw-bold text-primary-custom mb-0">Visi</h3>
                        <p class="text-secondary-custom mb-0">Menjadi roastery kopi artisanal terkemuka yang diakui atas
                            kualitas luar biasa, praktik berkelanjutan, dan kemampuan untuk menyatukan komunitas melalui
                            kecintaan pada kopi.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div
                        class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow h-100 d-flex flex-column gap-3">
                        <div class="icon-box"><i class="fa-solid fa-bullseye fs-4"></i></div>
                        <h3 class="fs-4 fw-bold text-primary-custom mb-0">Misi</h3>
                        <ul class="text-secondary-custom mb-0 ps-3">
                            <li class="mb-2">Mendapatkan biji kopi terbaik melalui perdagangan langsung dan adil.</li>
                            <li class="mb-2">Memanggang setiap batch dengan presisi untuk menonjolkan profil rasa
                                unik.</li>
                            <li>Mengedukasi dan menginspirasi pelanggan tentang seni dan ilmu apresiasi kopi.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- Founder Bio -->
        <section class="container-xl">
            <div class="bg-surface-low border border-outline-variant rounded-4 p-4 p-md-5">
                <div class="row g-4 align-items-center flex-column flex-md-row">
                    <div class="col-12 col-md-4 text-center">
                        <img alt="Founder"
                            class="img-fluid rounded-circle border border-outline-variant p-1 bg-surface-lowest"
                            src=""
                            style="width: 200px; height: 200px; object-fit: cover;" />
                    </div>
                    <div class="col-12 col-md-8 text-center text-md-start">
                        <h2 class="fw-bold text-primary-custom mb-1">Rendy</h2>
                        <h4 class="text-secondary-custom fs-6 fw-normal mb-3">Pendiri &amp; Master Roaster</h4>
                        <p class="text-secondary-custom mb-0">Dengan pengalaman lebih dari satu dekade di industri kopi,
                            Rendy percaya bahwa memanggang kopi adalah perpaduan antara seni dan sains. Dedikasinya
                            terhadap kesempurnaan telah membawa Bean &amp; Brew memenangkan berbagai penghargaan lokal.
                            Bagi Rendy, setiap cangkir kopi menceritakan kisah perjalanan biji kopi dari tanah hingga ke
                            tangan Anda.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="container-xl" id="kontak">
            <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 p-md-5 ambient-shadow">
                <div class="row g-5">
                    <div class="col-12 col-lg-5">
                        <h2 class="fw-bold text-primary-custom mb-3">Hubungi Kami</h2>
                        <p class="text-secondary-custom mb-4">Punya pertanyaan tentang kopi kami atau ingin bekerja
                            sama? Jangan ragu untuk menghubungi kami.</p>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box" style="width: 40px; height: 40px;"><i
                                        class="fa-solid fa-location-dot"></i></div>
                                <span class="text-secondary-custom">Jl. Kopi Roaster No. 8, Jakarta Selatan</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box" style="width: 40px; height: 40px;"><i
                                        class="fa-solid fa-envelope"></i></div>
                                <span class="text-secondary-custom">hello@beanandbrew.id</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box" style="width: 40px; height: 40px;"><i
                                        class="fa-solid fa-phone"></i></div>
                                <span class="text-secondary-custom">+62 812 3456 7890</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-7">
                        <form>
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-primary-custom" for="name">Nama
                                    Lengkap</label>
                                <input class="form-control border-outline-variant bg-surface-low" id="name"
                                    placeholder="Masukkan nama Anda" type="text" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-primary-custom" for="email">Alamat
                                    Email</label>
                                <input class="form-control border-outline-variant bg-surface-low" id="email"
                                    placeholder="nama@email.com" type="email" />
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-primary-custom" for="message">Pesan</label>
                                <textarea class="form-control border-outline-variant bg-surface-low" id="message"
                                    placeholder="Tulis pesan Anda di sini..." rows="4"></textarea>
                            </div>
                            <button class="btn btn-primary-custom py-2 px-4" type="button">Kirim Pesan</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <footer class="bg-surface-low border-top border-outline-variant mt-auto">
        <div class="container-xl py-5 d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">
            <div class="text-primary-custom fw-semibold label-caps text-center text-md-start">© 2026 Bean &amp; Brew
                Artisanal Coffee. Hak Cipta Dilindungi.</div>
            <nav class="d-flex flex-wrap justify-content-center gap-4">
                <a class="footer-link fs-6" href="#">Kebijakan Privasi</a>
                <a class="footer-link fs-6" href="#">Syarat &amp; Ketentuan</a>
                <a class="footer-link fs-6" href="#">Kemitraan</a>
            </nav>
        </div>
    </footer>
</body>

</html>

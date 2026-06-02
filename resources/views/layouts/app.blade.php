<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MyLoRa Gym Trainer') — My Local Jepara Gym Trainer</title>
    <meta name="description" content="@yield('description', 'MyLoRa - Platform marketplace jasa personal trainer fitness di Jepara. Temukan trainer terbaik untuk mencapai goals fitness kamu.')">
    <link rel="icon" href="{{ asset('images/mylora-logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #CCFF00;
            --primary-dark: #b3e600;
            --primary-light: rgba(204, 255, 0, 0.15);
            --secondary: #CCFF00;
            --dark: #121212;
            --dark-2: #1e1e24;
            --gray: #9ca3af;
            --light: #000000;
        }

        * { font-family: 'Inter', sans-serif; }

        body {
            background-color: var(--light);
            color: #ffffff;
        }

        .navbar-mylora {
            background: rgba(18, 18, 24, 0.95) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding: 0.75rem 0;
        }
        .navbar-mylora .navbar-brand {
            font-weight: 800;
            font-size: 1.4rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .navbar-mylora .nav-link {
            color: rgba(255,255,255,0.7) !important;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s;
            padding: 0.5rem 1rem !important;
        }
        .navbar-mylora .nav-link:hover,
        .navbar-mylora .nav-link.active {
            color: var(--primary) !important;
        }
        .btn-primary-mylora {
            background: var(--primary);
            border: none;
            color: #000;
            font-weight: 700;
            padding: 0.6rem 1.5rem;
            border-radius: 0.75rem;
            transition: all 0.3s;
        }
        .btn-primary-mylora:hover {
            background-color: #d4ff00;
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(204, 255, 0, 0.4);
            color: #000 !important;
        }
        .btn-outline-mylora {
            border: 2px solid var(--primary);
            color: var(--primary);
            font-weight: 700;
            padding: 0.6rem 1.5rem;
            border-radius: 0.75rem;
            transition: all 0.3s;
            background: transparent;
        }
        .btn-outline-mylora:hover {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #000 !important;
            transform: translateY(-2px);
        }

        .card-trainer {
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 1rem;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 1px 3px rgba(0,0,0,0.5);
            background: var(--dark-2);
        }
        .card-trainer:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(204,255,0,0.1);
            border-color: rgba(204,255,0,0.3);
        }

        .star-rating { color: #f59e0b; }
        .star-rating .bi-star-fill { margin-right: 1px; }

        .badge-category {
            background: var(--primary-light);
            color: var(--primary-dark);
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.8rem;
        }

        .footer-mylora {
            background: var(--dark-2);
            color: rgba(255,255,255,0.6);
            padding: 3rem 0 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .footer-mylora a {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer-mylora a:hover { color: var(--primary); }

        .hero-gradient {
            background: linear-gradient(135deg, var(--dark) 0%, #1a2744 50%, #0c3b2e 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-gradient::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 80%;
            height: 200%;
            background: radial-gradient(circle, rgba(16,185,129,0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .price-tag {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-dark);
        }
        .price-tag small {
            font-size: 0.8rem;
            font-weight: 400;
            color: var(--gray);
        }

        .stat-card {
            background: var(--dark-2);
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 1px 3px rgba(0,0,0,0.5);
        }
        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
        }

        .trainer-avatar {
            width: 100%;
            height: 220px;
            background: linear-gradient(135deg, var(--dark-2), #1e293b);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
        }

        .badge-status {
            padding: 0.4rem 0.75rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.78rem;
        }

        html { scroll-behavior: smooth; }

        .alert-mylora {
            border: none;
            border-radius: 0.75rem;
            border-left: 4px solid var(--primary);
        }

        .section-title {
            font-weight: 800;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        .section-subtitle {
            color: var(--gray);
            font-size: 1.05rem;
            max-width: 600px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-mylora fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('images/mylora-logo.png') }}" alt="MyLoRa" height="32" class="me-2">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('trainers*') ? 'active' : '' }}" href="{{ route('trainers.index') }}">Cari Trainer</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-primary-mylora btn-sm" href="{{ route('register') }}">Daftar Gratis</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                                <span class="badge bg-secondary ms-1" style="font-size:0.65rem;">{{ ucfirst(Auth::user()->role) }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard Admin</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.members') }}">Kelola Member</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.payouts') }}">Pusat Resolusi</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.withdrawals') }}">Tarik Dana Pelatih</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.reports') }}">Laporan & Statistik</a></li>
                                @elseif(Auth::user()->isTrainer())
                                    <li><a class="dropdown-item" href="{{ route('trainer.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard Trainer</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('member.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @if(session('success'))
    <div class="container" style="margin-top:5rem; margin-bottom:-3rem;">
        <div class="alert alert-success alert-mylora alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="container" style="margin-top:5rem; margin-bottom:-3rem;">
        <div class="alert alert-danger alert-mylora alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <main>
        @yield('content')
    </main>

    @hasSection('hide-footer')
    @else
    <footer class="footer-mylora">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="text-white fw-bold mb-3">
                        <img src="{{ asset('images/mylora-logo.png') }}" alt="MyLoRa" height="32" class="me-2">
                    </h5>
                    <p class="small">My Local Jepara Gym Trainer — Platform marketplace jasa personal trainer fitness di Jepara.</p>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="text-white fw-semibold mb-3">Menu</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ url('/') }}">Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('trainers.index') }}">Cari Trainer</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h6 class="text-white fw-semibold mb-3">Kontak</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i>Jepara, Jawa Tengah</li>
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i>hello@mylora.com</li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h6 class="text-white fw-semibold mb-3">Tentang</h6>
                    <p class="small">MyLoRa adalah platform revolusioner yang menghubungkan personal trainer profesional dengan klien yang mendambakan perubahan nyata.</p>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.1);">
            <p class="text-center small mb-0">&copy; {{ date('Y') }} MyLoRa Gym Trainer. All rights reserved.</p>
        </div>
    </footer>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Global SweetAlert2 confirmation interceptor
            document.querySelectorAll('[data-confirm]').forEach(el => {
                el.addEventListener('click', function(e) {
                    e.preventDefault();
                    let target = this;
                    Swal.fire({
                        title: 'Apakah Anda Yakin?',
                        text: target.getAttribute('data-confirm'),
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#343a40',
                        confirmButtonText: 'Ya, Lanjutkan!',
                        cancelButtonText: 'Batal',
                        background: '#1e1e24',
                        color: '#fff'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (target.tagName.toLowerCase() === 'button' && target.closest('form')) {
                                target.closest('form').submit();
                            } else if (target.hasAttribute('href')) {
                                window.location.href = target.getAttribute('href');
                            }
                        }
                    });
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>

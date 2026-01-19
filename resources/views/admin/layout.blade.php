<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Admin')</title>

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <style>
    /* RESET & DASAR */
    *{box-sizing:border-box}
    body {
        margin: 0;
        font-family: 'Montserrat';
        background: #fff9e9;
        height: 100vh;
        overflow: hidden;
        display: flex;
        color: #3A1309;
    }
    
    a { text-decoration: none; color: inherit; }
    .app { display: flex; width: 100%; height: 100vh; position: relative; }

    /* ============= SIDEBAR ============= */
    .sidebar {
        width: 260px;
        background: #f7cb1d; 
        padding: 25px;
        color: #3A1309;
        display: flex;
        flex-direction: column;
        box-shadow: 3px 0 12px rgba(0,0,0,0.1);
        height: 100vh;
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .brand {
        text-align: center;
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .menu {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px;
        border-radius: 12px;
        background: white;
        margin-bottom: 12px;
        color: #3A1309;
        font-weight: 600;
        transition: 0.25s;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .link:hover {
        background: #fff2b0;
        transform: translateX(6px);
    }

    .link.active {
        background: #3A1309;
        color: #f7cc1d;
    }

    /* ============= CONTENT AREA ============= */
    .content {
        flex: 1;
        padding: 28px 34px;
        overflow-y: auto;
    }

    .title {
        font-size: 48px;
        font-weight: 900;
        margin: 0 0 22px 0;
        color: #4b2c1a;
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(3, minmax(240px, 1fr));
        gap: 26px;
        margin-bottom: 26px;
    }

    .card {
        background: #fff;
        border-radius: 22px;
        padding: 26px;
        box-shadow: 0 10px 25px rgba(0,0,0,.10);
        min-height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 6px;
    }

    /* ============= HAMBURGER & MOBILE OPTIMIZATION ============= */
    .hamburger {
        display: none; /* Sembunyi di desktop */
        position: fixed;
        top: 15px;
        right: 15px;
        z-index: 1100;
        background: #3A1309;
        color: #f7cc1d;
        border: none;
        padding: 10px 12px;
        border-radius: 8px;
        font-size: 24px;
        cursor: pointer;
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 999;
        backdrop-filter: blur(2px);
    }

    @media (max-width: 768px) {
        .hamburger { display: block; }
        
        .sidebar {
            position: fixed;
            left: -100%; /* Sembunyikan sidebar ke kiri */
        }

        .sidebar.active {
            left: 0; /* Munculkan sidebar */
            width: 280px;
        }

        .sidebar-overlay.active {
            display: block;
        }

        .content {
            padding: 70px 20px 20px 20px;
        }

        .cards {
            grid-template-columns: 1fr;
        }

        .title {
            font-size: 32px;
        }

        .grid2 {
            grid-template-columns: 1fr;
        }
    }

    /* LOGOUT BUTTON */
    form { margin-top: auto; }
    .logout {
        width: 100%;
        background: #ff4d4d;
        color: #ffffff;
        border: none;
        border-radius: 12px;
        padding: 14px 18px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: 0.25s;
    }
    .logout:hover { background: #e63939; transform: scale(1.02); }

    /* UI REUSABLE LAINNYA */
    .panel{ background:#fff; border-radius:18px; padding:24px; box-shadow:0 10px 25px rgba(0,0,0,.10); }
    table{ width:100%; border-collapse:collapse; margin-top:14px; background:#fff; }
    th, td{ border:1px solid #eee; padding:10px 12px; font-size:14px; }
    th{ background:#fafafa; font-weight:900; color:#4b2c1a; }
  </style>
</head>

<body>
  <button class="hamburger" id="hamburgerBtn">
    <i class="bi bi-list"></i>
  </button>

  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <div class="app">
    <aside class="sidebar" id="sidebar">
      <div class="brand">Keluarga BaBa</div>

      <div class="menu">
        <a class="link {{ request()->routeIs('admin.dashboard')?'active':'' }}" href="{{ route('admin.dashboard') }}">🏠 Beranda</a>
        <a class="link {{ request()->routeIs('admin.anggota.*')?'active':'' }}" href="{{ route('admin.anggota.index') }}">👥 Anggota</a>
        <a class="link {{ request()->routeIs('admin.penilaian')?'active':'' }}" href="{{ route('admin.penilaian') }}">📝 Penilaian PM</a>
        <a class="link {{ request()->routeIs('admin.daily')?'active':'' }}" href="{{ route('admin.daily') }}">📒 Daily Report</a>
      </div>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="logout" type="submit">Logout</button>
      </form>
    </aside>

    <main class="content">
      @yield('content')
    </main>
  </div>

  <script>
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    // Fungsi untuk toggle sidebar
    function toggleSidebar() {
        sidebar.classList.toggle('active');
        sidebarOverlay.classList.toggle('active');
        
        // Ganti icon saat menu terbuka
        const icon = hamburgerBtn.querySelector('i');
        if (sidebar.classList.contains('active')) {
            icon.classList.replace('bi-list', 'bi-x-lg');
        } else {
            icon.classList.replace('bi-x-lg', 'bi-list');
        }
    }

    hamburgerBtn.addEventListener('click', toggleSidebar);
    sidebarOverlay.addEventListener('click', toggleSidebar);
  </script>
</body>
</html>
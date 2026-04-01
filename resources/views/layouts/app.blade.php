<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Maintenance System')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --primary-light: #eef0ff;
            --secondary: #6c757d;
            --success: #2ec4b6;
            --danger: #e63946;
            --warning: #f4a261;
            --info: #4cc9f0;
            --dark: #1a1a2e;
            --sidebar-width: 260px;
            --gradient-primary: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            --gradient-dark: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            --shadow-sm: 0 1px 3px rgba(0,0,0,.08);
            --shadow-md: 0 4px 12px rgba(0,0,0,.1);
            --shadow-lg: 0 8px 30px rgba(0,0,0,.12);
            --radius: 12px;
            --radius-sm: 8px;
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: #f0f2f5;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--gradient-dark);
            color: #fff;
            z-index: 1050;
            transition: transform .3s cubic-bezier(.4,0,.2,1);
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .sidebar-brand h4 {
            font-weight: 700;
            font-size: 1.15rem;
            margin: 0;
            letter-spacing: -.3px;
        }

        .sidebar-brand small {
            color: rgba(255,255,255,.5);
            font-size: .75rem;
            font-weight: 400;
        }

        .sidebar-nav {
            padding: 16px 12px;
        }

        .sidebar-nav .nav-label {
            font-size: .68rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255,255,255,.35);
            padding: 16px 12px 6px;
            font-weight: 600;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: rgba(255,255,255,.65);
            border-radius: var(--radius-sm);
            font-size: .875rem;
            font-weight: 500;
            transition: all .2s ease;
            text-decoration: none;
            margin-bottom: 2px;
        }

        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            background: rgba(67, 97, 238, .2);
            color: #fff;
        }

        .sidebar-nav .nav-link.active {
            background: var(--primary);
            box-shadow: 0 4px 12px rgba(67,97,238,.4);
        }

        .sidebar-nav .nav-link i {
            font-size: 1.15rem;
            width: 22px;
            text-align: center;
        }

        /* ── Main Content ── */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left .3s cubic-bezier(.4,0,.2,1);
        }

        /* ── Top Navbar ── */
        .top-navbar {
            background: #fff;
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(0,0,0,.06);
            position: sticky;
            top: 0;
            z-index: 1040;
            box-shadow: var(--shadow-sm);
        }

        .top-navbar .breadcrumb {
            margin: 0;
            font-size: .875rem;
        }

        .top-navbar .breadcrumb-item a {
            color: var(--secondary);
            text-decoration: none;
        }

        .top-navbar .breadcrumb-item.active {
            color: var(--dark);
            font-weight: 600;
        }

        .btn-toggle-sidebar {
            display: none;
            background: none;
            border: none;
            font-size: 1.4rem;
            color: var(--dark);
            cursor: pointer;
            padding: 4px 8px;
            border-radius: var(--radius-sm);
            transition: background .2s;
        }

        .btn-toggle-sidebar:hover {
            background: var(--primary-light);
        }

        /* ── Page Container ── */
        .page-container {
            padding: 24px 28px;
        }

        /* ── Card Styles ── */
        .card-main {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0,0,0,.06);
            overflow: hidden;
        }

        .card-main .card-header {
            background: #fff;
            padding: 20px 24px;
            border-bottom: 1px solid rgba(0,0,0,.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .card-main .card-header h5 {
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--dark);
            margin: 0;
        }

        .card-main .card-body {
            padding: 20px 24px;
        }

        /* ── Buttons ── */
        .btn-primary-custom {
            background: var(--gradient-primary);
            color: #fff;
            border: none;
            padding: 9px 20px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: .875rem;
            transition: all .2s ease;
            box-shadow: 0 2px 8px rgba(67,97,238,.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(67,97,238,.4);
            color: #fff;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            font-size: .82rem;
            transition: all .2s ease;
            cursor: pointer;
        }

        .btn-action:hover {
            transform: translateY(-1px);
        }

        .btn-view    { background: #e8f4fd; color: #0ea5e9; }
        .btn-edit    { background: #fef3c7; color: #d97706; }
        .btn-void    { background: #fee2e2; color: #e63946; }
        .btn-log     { background: #e0e7ff; color: #4361ee; }
        .btn-status  { background: #d1fae5; color: #059669; }
        .btn-danger  { background: #e63946; color: #fff; }

        .btn-view:hover    { background: #0ea5e9; color: #fff; }
        .btn-edit:hover    { background: #d97706; color: #fff; }
        .btn-void:hover    { background: #e63946; color: #fff; }
        .btn-log:hover     { background: #4361ee; color: #fff; }
        .btn-status:hover  { background: #059669; color: #fff; }

        /* ── Table ── */
        .table-custom {
            font-size: .85rem;
        }

        .table-custom thead th {
            background: #f8f9fc;
            color: var(--dark);
            font-weight: 600;
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 12px 16px;
            border-bottom: 2px solid rgba(0,0,0,.06);
            white-space: nowrap;
        }

        .table-custom tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(0,0,0,.04);
        }

        .table-custom tbody tr {
            transition: background .15s ease;
        }

        .table-custom tbody tr:hover {
            background: #f8f9fc;
        }

        /* ── Status Badges ── */
        .badge-active {
            background: #d1fae5;
            color: #059669;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: .75rem;
        }

        .badge-inactive {
            background: #fee2e2;
            color: #e63946;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: .75rem;
        }

        .badge-void {
            background: #f3f4f6;
            color: #6b7280;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: .75rem;
        }

        /* ── Modal Styling ── */
        .modal-fullscreen-custom .modal-dialog {
            max-width: 95vw;
            margin: 1.75rem auto;
        }

        .modal-fullscreen-custom .modal-content {
            border-radius: var(--radius);
            border: none;
            box-shadow: var(--shadow-lg);
            min-height: 85vh;
        }

        .modal-fullscreen-custom .modal-header {
            background: var(--gradient-primary);
            color: #fff;
            padding: 18px 24px;
            border-radius: var(--radius) var(--radius) 0 0;
        }

        .modal-fullscreen-custom .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-fullscreen-custom .modal-body {
            padding: 28px;
        }

        .modal-fullscreen-custom .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid rgba(0,0,0,.06);
        }

        /* ── Form Styles ── */
        .form-label-custom {
            font-weight: 600;
            font-size: .8rem;
            color: var(--dark);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        .form-control-custom {
            border: 1.5px solid #e2e8f0;
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            font-size: .875rem;
            transition: all .2s ease;
        }

        .form-control-custom:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67,97,238,.15);
        }

        .form-select-custom {
            border: 1.5px solid #e2e8f0;
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            font-size: .875rem;
        }

        /* ── Image Upload ── */
        .image-upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: var(--radius);
            padding: 32px 20px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all .25s ease;
        }

        .image-upload-area:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .image-upload-area i {
            font-size: 2.5rem;
            color: #94a3b8;
            display: block;
            margin-bottom: 10px;
        }

        .image-preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 12px;
            margin-top: 16px;
        }

        .image-preview-item {
            position: relative;
            border-radius: var(--radius-sm);
            overflow: hidden;
            aspect-ratio: 1;
            border: 2px solid #e2e8f0;
        }

        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview-item .btn-remove-img {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: rgba(230,57,70,.9);
            color: #fff;
            border: none;
            font-size: .75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform .2s;
        }

        .image-preview-item .btn-remove-img:hover {
            transform: scale(1.1);
        }

        /* ── Toast ── */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        /* ── Pagination ── */
        .pagination-custom .page-link {
            border-radius: var(--radius-sm);
            margin: 0 2px;
            font-size: .82rem;
            font-weight: 500;
            color: var(--dark);
            border: 1px solid #e2e8f0;
        }

        .pagination-custom .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* ── Responsive ── */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .btn-toggle-sidebar {
                display: block;
            }
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,.5);
                z-index: 1049;
                display: none;
            }
            .sidebar-overlay.show {
                display: block;
            }
        }

        @media (max-width: 767.98px) {
            .page-container {
                padding: 16px;
            }
            .card-main .card-header {
                padding: 16px;
            }
            .card-main .card-body {
                padding: 16px;
            }
            .modal-fullscreen-custom .modal-dialog {
                max-width: 100%;
                margin: 0;
            }
            .modal-fullscreen-custom .modal-content {
                border-radius: 0;
                min-height: 100vh;
            }
        }

        /* ── Animations ── */
        .fade-in {
            animation: fadeIn .3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
            border-radius: 4px;
        }

        @keyframes skeleton-loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4><i class="bi bi-gear-wide-connected me-2"></i>Maintenance</h4>
            <small>System Management</small>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-label">Menu Utama</div>
            <a href="{{ route('master-machine.index') }}" class="nav-link {{ request()->routeIs('master-machine.*') ? 'active' : '' }}">
                <i class="bi bi-cpu"></i>
                <span>Master Mesin</span>
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-box-seam"></i>
                <span>Master Sparepart</span>
            </a>
            <div class="nav-label">Operasional</div>
            <a href="#" class="nav-link">
                <i class="bi bi-tools"></i>
                <span>Work Order</span>
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-clipboard-data"></i>
                <span>Laporan</span>
            </a>
            <div class="nav-label">Pengaturan</div>
            <a href="#" class="nav-link">
                <i class="bi bi-person-gear"></i>
                <span>User Management</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn-toggle-sidebar" id="btnToggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        @yield('breadcrumb')
                    </ol>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted" style="font-size:.82rem;">
                    <i class="bi bi-person-circle me-1"></i> Admin
                </span>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-container">
            @yield('content')
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        // CSRF Token setup for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Sidebar Toggle (Mobile)
        document.getElementById('btnToggleSidebar')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        });
        document.getElementById('sidebarOverlay')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.remove('show');
            document.getElementById('sidebarOverlay').classList.remove('show');
        });

        // Show toast notification
        function showToast(message, type = 'success') {
            const bgClass = type === 'success' ? 'bg-success' : type === 'danger' ? 'bg-danger' : 'bg-warning';
            const icon = type === 'success' ? 'bi-check-circle-fill' : type === 'danger' ? 'bi-exclamation-triangle-fill' : 'bi-info-circle-fill';
            const html = `
                <div class="toast show fade-in" role="alert" style="min-width:320px;">
                    <div class="toast-header ${bgClass} text-white">
                        <i class="bi ${icon} me-2"></i>
                        <strong class="me-auto">${type === 'success' ? 'Berhasil' : 'Error'}</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">${message}</div>
                </div>
            `;
            const container = document.getElementById('toastContainer');
            container.insertAdjacentHTML('beforeend', html);
            setTimeout(() => {
                container.firstElementChild?.remove();
            }, 4000);
        }
    </script>

    @stack('scripts')
</body>
</html>

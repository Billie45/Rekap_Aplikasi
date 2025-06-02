<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        overflow-x: hidden;
        --sb-width: 5rem;
        font-family: system-ui, sans-serif;
        font-size: 16px;
        line-height: 1.7;
        color: #333;
        background-color: #fff;
    }

    body.sb-expanded {
        --sb-width: 12.5rem;
    }

    aside {
        position: fixed;
        inset: 0 auto 0 0;
        padding: 1rem;
        width: var(--sb-width);
        background-color: #ffffff;
        transition: width 0.5s ease-in-out;
    }

    nav {
        height: 100%;
    }

    nav ul {
        list-style: none;
        height: 100%;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    nav li:last-child {
        margin-top: auto;
    }

    nav a {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        padding: 0.625rem 0.875rem;
        font-size: 1.25rem;
        line-height: 1;
        color: #000000;
        text-decoration: none;
        border-radius: 0.375rem;
        transition: background-color 0.5s ease-in-out, color 0.5s ease-in-out;
    }

    nav a.active,
    nav a:hover,
    nav a:focus-visible {
        outline: none;
        color: #ffffff;
        background-color: #1e3a8a;
    }

    button.bg-white:hover {
        background-color: #f1f5f9;
        color: #1f2937;
    }

    nav a span {
        font-size: 0.875rem;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
    }

    .sb-expanded nav a span {
        opacity: 1;
        visibility: visible;
    }

    nav a i {
        font-size: 0.875rem;
        font-style: normal;
    }

    .sb-expanded aside .bx-chevrons-right {
        rotate: 180deg;
    }

    @media (min-width: 640px) {
        .hidden.sm\:flex.sm\:items-center.sm\:ms-6 {
            display: flex;
            align-items: center;
            margin-left: 1rem;
            gap: 1rem;
        }
    }

</style>

<aside>
    <nav>
        <ul>
            <li>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.list-apk') ? 'active' : '' }}">
                        <i class="bx bx-home-circle"></i>
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="bx bx-home-circle"></i>
                        <span>Dashboard</span>
                    </a>
                @endif
            </li>
            <li>
                <a href="/rekap-aplikasi-view" class="{{ request()->is('rekap-aplikasi-view') ? 'active' : '' }}">
                    <i class="bx bx-clipboard"></i>
                    <span>Rekap Aplikasi</span>
                </a>
            </li>
            <li>
                <a href="/assessment" class="{{ request()->is('assessment') ? 'active' : '' }}">
                    <i class="bx bx-check-circle"></i>
                    <span>Assessment</span>
                </a>
            </li>
            <li>
                <a href="/development" class="{{ request()->is('development') ? 'active' : '' }}">
                    <i class="bx bx-code-alt"></i>
                    <span>Development</span>
                </a>
            </li>
            <li>
                <a href="/selesai" class="{{ request()->is('selesai') ? 'active' : '' }}">
                    <i class="bx bx-task"></i>
                    <span>Selesai</span>
                </a>
            </li>
            <li>
                <a href="/akses-server" class="{{ request()->is('akses-server') ? 'active' : '' }}">
                    <i class="bx bx-server"></i>
                    <span>Akses Server</span>
                </a>
            </li>
            <li>
                <a href="#" data-resize-btn>
                    <i class="bx bx-chevrons-right"></i>
                    <span>Collapse</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>

<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const resizeBtn = document.querySelector("[data-resize-btn]");

        // Cek localStorage apakah sidebar harus expanded
        const isExpanded = localStorage.getItem("sidebar-expanded") === "true";
        if (isExpanded) {
            document.body.classList.add("sb-expanded");
        }

        // Toggle dan simpan status ke localStorage
        resizeBtn.addEventListener("click", function (e) {
            e.preventDefault();
            document.body.classList.toggle("sb-expanded");
            const expanded = document.body.classList.contains("sb-expanded");
            localStorage.setItem("sidebar-expanded", expanded);
        });
    });
</script>

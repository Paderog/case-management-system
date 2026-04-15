<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>
        .sidebar{
        width: 290px;
        height: 100vh;
        background: #1f2937;
        padding: 20px 12px;
        position: fixed;
        left: 0;
        top: 0;
        display: flex;
        flex-direction: column;
        overflow-x: hidden;
        z-index: 1000;
    }

    .sidebar.collapsed{
        width: 90px;
    }

    .sidebar-menu{
        flex: 1;
    }

    .sidebar-header-wrap{
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .sidebar-header{
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 6px 14px 6px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        margin-bottom: 18px;
    }

    .deped-logo{
        width: 58px;
        height: 58px;
        object-fit: contain;
        flex-shrink: 0;
    }

    .brand-text{
        display: flex;
        flex-direction: column;
        line-height: 1.15;
        flex: 1;
        min-width: 0;
    }

    .brand-title{
        font-size: 13px;
        font-weight: 700;
        color: white;
        white-space: nowrap;
    }

    .brand-subtitle{
        font-size: 10px;
        color: #bbb;
        letter-spacing: .5px;
        white-space: nowrap;
    }

    .sidebar-toggle-btn{
        border: none;
        background: #374151;
        color: white;
        border-radius: 12px;
        padding: 10px;
        margin: 0 10px 10px 10px;
        cursor: pointer;
        transition: 0.2s;
    }

    .sidebar-toggle-btn:hover{
        background: #4b5563;
    }

    .sidebar-item{
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        margin-bottom: 12px;
        border-radius: 12px;
        color: #e5e7eb;
        text-decoration: none;
        font-weight: 600;
        font-size: 18px;
        transition: 0.2s;
        white-space: nowrap;
    }

    .sidebar-item:hover{
        background: #374151;
        color: white;
    }

    .sidebar-active{
        background: linear-gradient(90deg,#6366f1,#8b5cf6);
        color: white !important;
    }

    .sidebar-logout{
        margin-top: auto;
        color: #ef4444;
    }

    .sidebar-logout:hover{
        color: #ef4444;
        background: rgba(255,255,255,0.05);
    }

    .icon{
        min-width: 24px;
        text-align: center;
        flex-shrink: 0;
        font-size: 18px;
    }

    .item-text{
        transition: opacity 0.3s ease, width 0.3s ease;
        white-space: nowrap;
    }

    .menu-box{
        background: #243244;
        border-radius: 18px;
        padding: 18px 16px;
        color: white;
        margin-bottom: 15px;
        transition: 0.2s;
    }

    .menu-box:hover{
        background: #2d3b4d;
    }

    .menu-box.active-box{
        background: linear-gradient(135deg, #9b7cf6, #7c4dff);
    }

    .menu-header{
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
    }

    .menu-title{
        font-size: 18px;
        font-weight: 700;
        color: white;
        margin: 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        line-height: 1.2;
        flex: 1;
    }

    .add-circle-btn{
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: white;
        color: #7c4dff;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-weight: bold;
        font-size: 20px;
        line-height: 1;
        transition: 0.2s;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .add-circle-btn:hover{
        background: #f3f4f6;
        color: #5b21b6;
    }

    .menu-list{
        max-height: 220px;
        overflow-y: auto;
        margin-top: 14px;
        padding-right: 4px;
    }

    .menu-list::-webkit-scrollbar{
        width: 6px;
    }

    .menu-list::-webkit-scrollbar-thumb{
        background: rgba(255,255,255,0.35);
        border-radius: 10px;
    }

    .menu-item-row{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
    }

    .menu-link{
        display: block;
        width: 100%;
        color: rgba(255,255,255,0.78);
        text-decoration: none;
        font-size: 16px;
        padding: 10px 12px;
        border-radius: 10px;
        transition: 0.2s;
    }

    .menu-link:hover{
        background: rgba(255,255,255,0.10);
        color: white;
    }

    .menu-link.active-submenu{
        background: rgba(255,255,255,0.24);
        color: white !important;
        font-weight: 700;
        border-left: 4px solid white;
    }

    .menu-delete-btn{
        background: transparent;
        border: none;
        color: white;
        font-size: 14px;
        cursor: pointer;
        padding: 6px 8px;
        border-radius: 8px;
    }

    .menu-delete-btn:hover{
        background: rgba(255,255,255,0.12);
        color: #fecaca;
    }

    .main-content{
        margin-left: 290px;
        width: calc(100% - 290px);
        transition: 0.3s ease;
    }

    .main-content.expanded{
        margin-left: 90px;
        width: calc(100% - 90px);
    }

    /* COLLAPSED */
    .sidebar.collapsed .brand-text,
    .sidebar.collapsed .item-text,
    .sidebar.collapsed .add-circle-btn{
        opacity: 0;
        width: 0;
        overflow: hidden;
        pointer-events: none;
    }

    .sidebar.collapsed .sidebar-header{
        justify-content: center;
        padding-left: 0;
        padding-right: 0;
    }

    .sidebar.collapsed .deped-logo{
        width: 50px;
        height: 50px;
    }

    .sidebar.collapsed .sidebar-item{
        justify-content: center;
        padding: 14px 10px;
    }

    .sidebar.collapsed .menu-box{
        padding: 14px 10px;
    }

    .sidebar.collapsed .menu-header{
        justify-content: center;
    }

    .sidebar.collapsed .menu-title{
        justify-content: center;
    }

    .sidebar.collapsed .menu-list{
        display: none !important;
    }

    .sidebar.collapsed .sidebar-logout{
        justify-content: center;
    }
    </style>

    <title>
        @hasSection('title')
            @yield('title') | Cases CRUD
        @else
            Cases CRUD
        @endif
    </title>

    @vite(['resources/js/app.js'])
</head>

<body class="bg-dark">

<div class="d-flex">

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header-wrap">
            <div class="sidebar-header">
                <img src="{{ asset('image/deped-2.png') }}" alt="DepEd Logo" class="deped-logo">

                <div class="brand-text">
                    <div class="brand-title">Department of Education</div>
                    <div class="brand-subtitle">SCHOOLS DIVISION OF BUKIDNON</div>
                </div>
            </div>

            <button class="sidebar-toggle-btn" id="sidebarToggle" type="button">☰</button>
        </div>

        <div class="sidebar-menu">

            <a href="{{ route('dashboard') }}"
               class="sidebar-item {{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }}">
                <span class="icon">🏠</span>
                <span class="item-text">Dashboard</span>
            </a>

            @php
                $selectedYearParam = request()->routeIs('cases.year') ? request()->route('year') : null;
                $selectedYearId = is_object($selectedYearParam) ? $selectedYearParam->id : $selectedYearParam;
                $casesActive = !is_null($selectedYearId);

                $currentRoute = request()->route() ? request()->route()->getName() : null;

                $selectedAdminParam = $currentRoute === 'admin-cases.show' ? request()->route('admin_case') : null;
                $selectedAdminId = is_object($selectedAdminParam) ? $selectedAdminParam->id : $selectedAdminParam;
                $adminActive = !is_null($selectedAdminId);
            @endphp

            <div class="menu-box {{ $casesActive ? 'active-box' : '' }}">
                <div class="menu-header">
                    <h5 class="menu-title" onclick="toggleCases()">
                        <span class="icon">📁</span>
                        <span class="item-text">Cases</span>
                    </h5>

                    <a href="{{ route('years.create') }}" class="add-circle-btn" title="Add Year">+</a>
                </div>

                <div id="casesMenu" class="menu-list" style="display: none;">
                    @foreach($sidebarYears as $year)
                        <div class="menu-item-row">
                            <a href="{{ route('cases.year', $year->id) }}"
                               class="menu-link {{ $selectedYearId == $year->id ? 'active-submenu' : '' }}">
                                {{ $year->year }}
                            </a>

                            <form action="{{ route('years.destroy', $year->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Delete this year?')"
                                        class="menu-delete-btn">
                                    🗑
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="menu-box {{ $adminActive ? 'active-box' : '' }}">
                <div class="menu-header">
                    <h5 class="menu-title" onclick="toggleAdmin()">
                        <span class="icon">⚖️</span>
                        <span class="item-text">Administrative Case</span>
                    </h5>

                    <a href="{{ route('admin-cases.create') }}" class="add-circle-btn" title="Add Administrative Case">+</a>
                </div>

                <div id="adminMenu" class="menu-list" style="display: none;">
                    @foreach($groupedCases ?? [] as $title => $cases)
                        @php
                            preg_match('/As of (.*)$/', $title, $matches);
                            $date = $matches[1] ?? $title;
                            $firstCaseId = $cases->first()->id;
                        @endphp

                        <a href="{{ route('admin-cases.show', $firstCaseId) }}"
                           class="menu-link {{ (string)$selectedAdminId === (string)$firstCaseId ? 'active-submenu' : '' }}">
                            {{ $date }}
                        </a>
                    @endforeach
                </div>
            </div>

        </div>

        <a href="{{ route('home') }}" class="sidebar-item sidebar-logout">
            <span class="icon">🚪</span>
            <span class="item-text">Logout</span>
        </a>
    </div>

    <div class="main-content flex-grow-1 p-4" id="mainContent">
        <div id="app">
            <main class="py-4 px-4">
                @yield('content')
            </main>
        </div>
    </div>

</div>

<script>
    function toggleCases() {
        if (document.getElementById("sidebar").classList.contains("collapsed")) return;

        let menu = document.getElementById("casesMenu");
        menu.style.display = (menu.style.display === "none" || menu.style.display === "") ? "block" : "none";
    }

    function toggleAdmin() {
        if (document.getElementById("sidebar").classList.contains("collapsed")) return;

        let menu = document.getElementById("adminMenu");
        menu.style.display = (menu.style.display === "none" || menu.style.display === "") ? "block" : "none";
    }

    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("mainContent");

    sidebarToggle.addEventListener("click", function () {
        sidebar.classList.toggle("collapsed");
        mainContent.classList.toggle("expanded");

        document.getElementById("casesMenu").style.display = "none";
        document.getElementById("adminMenu").style.display = "none";
    });
</script>

@yield('script')

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .sidebar{
            width:270px;
            height:100vh;
            background:#1f2937;
            padding:25px 15px;
            position:fixed;
            left:0;
            top:0;
            display:flex;
            flex-direction:column;
        }

        .sidebar-menu{
            flex:1;
        }

        .sidebar-logo{
            font-size:26px;
            font-weight:bold;
            color:#facc15;
            text-align:center;
            margin-bottom:35px;
        }

        .sidebar-item{
            display:flex;
            align-items:center;
            gap:12px;
            padding:14px 16px;
            margin-bottom:12px;
            border-radius:12px;
            color:#e5e7eb;
            text-decoration:none;
            font-weight:600;
            font-size:18px;
            transition:0.2s;
        }

        .sidebar-item:hover{
            background:#374151;
            color:white;
        }

        .sidebar-active{
            background:linear-gradient(90deg,#6366f1,#8b5cf6);
            color:white !important;
        }

        .sidebar-logout{
            margin-top:auto;
            color:#ef4444;
        }

        /* BOX STYLE FOR CASES + ADMIN CASE */
        .menu-box{
            background:#243244;
            border-radius:18px;
            padding:18px 16px;
            color:white;
            margin-bottom:15px;
            transition:0.2s;
        }

        .menu-box:hover{
            background:#2d3b4d;
        }

        .menu-box.active-box{
            background:linear-gradient(135deg, #9b7cf6, #7c4dff);
        }

        .menu-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .menu-title{
            font-size:20px;
            font-weight:700;
            color:white;
            margin:0;
            cursor:pointer;
        }

        .add-circle-btn{
            width:32px;
            height:32px;
            border-radius:50%;
            background:white;
            color:#7c4dff;
            display:flex;
            align-items:center;
            justify-content:center;
            text-decoration:none;
            font-weight:bold;
            font-size:20px;
            line-height:1;
            transition:0.2s;
            flex-shrink:0;
        }

        .add-circle-btn:hover{
            background:#f3f4f6;
            color:#5b21b6;
        }

        .menu-list{
            max-height:220px;
            overflow-y:auto;
            margin-top:14px;
            padding-right:4px;
        }

        .menu-list::-webkit-scrollbar{
            width:6px;
        }

        .menu-list::-webkit-scrollbar-thumb{
            background:rgba(255,255,255,0.35);
            border-radius:10px;
        }

        .menu-item-row{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:10px;
            margin-bottom:8px;
        }

        .menu-link{
            display:block;
            width:100%;
            color:rgba(255,255,255,0.78);
            text-decoration:none;
            font-size:16px;
            padding:10px 12px;
            border-radius:10px;
            transition:0.2s;
        }

        .menu-link:hover{
            background:rgba(255,255,255,0.10);
            color:white;
        }

        .menu-link.active-submenu{
            background:rgba(255,255,255,0.24);
            color:white !important;
            font-weight:700;
            border-left:4px solid white;
        }

        .menu-delete-btn{
            background:transparent;
            border:none;
            color:white;
            font-size:14px;
            cursor:pointer;
            padding:6px 8px;
            border-radius:8px;
        }

        .menu-delete-btn:hover{
            background:rgba(255,255,255,0.12);
            color:#fecaca;
        }
        .sidebar-header{
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 15px;
        }

        .deped-logo{
            width: 75px;
            height: 75px;
            object-fit: contain;
        }

        .brand-text{
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .brand-title{
            font-size: 16px;
            font-weight: 700;
            color: white;
        }

        .brand-subtitle{
            font-size: 14px;
            color: #bbb;
            letter-spacing: 1px;
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

    <div class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('image/deped-2.png') }}" alt="DepEd Logo" class="deped-logo">

            <div class="brand-text">
                <div class="brand-title">Department of Education</div>
                <div class="brand-subtitle">SCHOOLS DIVISION OF BUKIDNON</div>
            </div>
        </div>

        <div class="sidebar-menu">

            <a href="{{ route('dashboard') }}"
               class="sidebar-item {{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }}">
                🏠 Dashboard
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

            <!-- CASES BOX -->
            <div class="menu-box {{ $casesActive ? 'active-box' : '' }}">
            <div class="menu-header">
                <h5 class="menu-title" onclick="toggleCases()">Cases</h5>

                <a href="{{ route('years.create') }}" class="add-circle-btn" title="Add Year">
                    +
                </a>
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

            <!-- ADMINISTRATIVE CASE BOX -->
            <div class="menu-box {{ $adminActive ? 'active-box' : '' }}">
                <div class="menu-header">
                    <h5 class="menu-title" onclick="toggleAdmin()">Administrative Case</h5>

                    <a href="{{ route('admin-cases.create') }}" class="add-circle-btn" title="Add Administrative Case">
                        +
                    </a>
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
            🚪 Logout
        </a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-grow-1 p-4" style="margin-left:270px;">
        <div id="app">
            <main class="py-4 px-4">
                @yield('content')
            </main>
        </div>
    </div>

</div>

<script>
    function toggleCases() {
        let menu = document.getElementById("casesMenu");
        menu.style.display = (menu.style.display === "none" || menu.style.display === "") ? "block" : "none";
    }

    function toggleAdmin() {
        let menu = document.getElementById("adminMenu");
        menu.style.display = (menu.style.display === "none" || menu.style.display === "") ? "block" : "none";
    }
</script>

@yield('script')

</body>
</html>
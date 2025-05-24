<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel project</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
    .material-icons {
        vertical-align: -14%
    }

    body {
        padding-top: 56px;
    }

    .navbar-nav {
        margin-left: auto;
        display: flex;
        gap: 20px;
    }

    .nav-link {
        color: #000;
        text-decoration: none;
    }

    table {
        width: 100%;
        table-layout: fixed;
        /* Ensures table takes full width */
    }

    body {
        font-family: 'Sarabun', sans-serif;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color: #e3f2fd;">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <form class="form-inline my-2 my-lg-0" action="{{ route('searchMembers') }}" method="GET" id="searchForm">
                    <input class="form-control mr-sm-2" type="search" name="query" placeholder="ค้นหาสมาชิก"
                        aria-label="Search">
                    <i class="material-icons" title="ค้นหาสมาชิก" id="searchIcon" style="cursor: pointer;">search</i>
                </form>
                <li class="nav-item">
                    <a href="{{ url('/setBook') }}" class="nav-link">
                        <span class="material-symbols-outlined" style="color:#004AAD"
                            title="เพิ่มหมวดหมู่หนังสือ">bookmark_add</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/show') }}" class="nav-link">
                        <span class="material-symbols-outlined" style="color:#004AAD" title="ข้อมูลสมาชิก">groups</span>
                    </a>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"
                            style="display: flex; align-items: center; padding: 0;">
                            <span style=" margin-top:10px; color:#004AAD"
                                class="material-symbols-outlined">account_circle</span>
                            @if(Auth::guard('admin')->check())
                            <span style="margin-left: 5px;">{{ Auth::guard('admin')->user()->username }}</span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">ออกจากระบบ</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <script>
    $(document).ready(function() {
        $('#searchIcon').on('click', function() {
            $('#searchForm').submit();  // ส่งฟอร์มเมื่อคลิกไอคอนค้นหา
        });
    });
    </script>
</body>

</html>

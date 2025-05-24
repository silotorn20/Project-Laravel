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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-straight/css/uicons-regular-straight.css'>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    li {
        display: inline;
    }

    .material-icons {
        vertical-align: -14%;
    }

    body {
        padding-top: 56px;
        font-family: 'Sarabun', sans-serif;
        font-size: 20px;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' height='30' width='30' viewBox='0 0 30 30'%3E%3Cpath stroke='%23004AAD' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        background-size: contain;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md fixed-top" style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('/home') }}" style="color:#545454"><i class="material-icons"
                                style="color:#004AAD">home</i> หน้าแรก</a>
                    </li>
                    <li class="nav-item dropdown" style="margin-top:3px;">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#545454">
                            <i class="fas fa-list" style="color:#004AAD"></i> หมวดหมู่หนังสือ
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item category-item" href="#" data-category="ทั้งหมด">ทั้งหมด</a>
                            @foreach ($setBooks as $setBook)
                            <a class="dropdown-item category-item" href="#"
                                data-category="{{ $setBook->nameSetBook }}">{{ $setBook->nameSetBook }}</a>
                            @endforeach
                            <div class="dropdown-divider"></div>
                        </div>
                    </li>
                    @if (Auth::check())
                    @if (Auth::user()->status == 'ผู้เขียน' || Auth::user()->status == 'ผู้เขียนและผู้อ่าน')
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('/writer/' . Auth::user()->id_member) }}"
                            style="color:#545454"><img src="{{ '../../public/storage/image/writing.png' }}"
                                style="width: 20px;">
                            หน้านักเขียน</a>
                    </li>
                    @endif
                    @endif
                </ul>
                <div class="d-flex align-items-center flex-wrap">
                    <a href="{{ url('/search') }}" class="mx-2">
                        <i class="material-icons" style="color:#004AAD" title="ค้นหา">search</i>
                    </a>

                    @if (Auth::check() && (Auth::user()->status == 'ผู้เขียน' || Auth::user()->status ==
                    'ผู้เขียนและผู้อ่าน'))
                    <a href="{{ route('orderDetails', ['id_member' => Auth::user()->id_member]) }}" class="mx-2">
                        <i class="bi bi-receipt-cutoff" style="color:#004AAD; font-size:20px;"
                            title="รายการคำสั่งซื้อ"></i>
                    </a>
                    @endif

                    @if (Auth::guard('member')->check())
                    <a href="{{ url('/bookShelf/' . Auth::guard('member')->user()->id_member) }}" class="mx-2">
                        <i class="fas fa-book-medical" style="color:#004AAD; font-size:20px;" title="ชั้นหนังสือ"></i>
                    </a>
                    <span style="font-weight: bold; color:#004AAD;">{{ $bookShelfCount }}</span>

                    <a href="{{ url('/cartBook/' . Auth::guard('member')->user()->id_member) }}" class="mx-2">
                        <i class="fi fi-rs-shopping-bag" style="color:#004AAD;" title="ตะกร้าหนังสือ"></i>
                    </a>
                    <span style="font-weight: bold; color:#004AAD;">{{ $cartCount }}</span>
                    @endif
                </div>
            </div>
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" style="display: flex; align-items: center; padding: 0;">
                    <span style="margin-left: 20px; color:#004AAD"
                        class="material-symbols-outlined">account_circle</span>
                    @if(Auth::guard('member')->check())
                    <span 
                        style="margin-left: 5px; font-size: 20px">{{ Auth::guard('member')->user()->Firstname }}</span>
                    @endif

                </button>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item"
                            href="{{ url('/profile/' . Auth::guard('member')->user()->id_member) }}">โปรไฟล์</a>
                    </li>
                    <hr class="dropdown-divider">
                    <li><a class="dropdown-item"
                            href="{{ url('/regisWriter/' . Auth::guard('member')->user()->id_member) }}">ลงทะเบียนนักเขียน</a>
                    </li>
                    <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ url('/historyRead/' . Auth::guard('member')->user()->id_member) }}">ประวัติการอ่าน</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ url('/OrderHistory/' . Auth::guard('member')->user()->id_member) }}">ประวัติการซื้อ</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ url('/showmyBook/' . Auth::guard('member')->user()->id_member) }}">หนังสือของชั้น</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">ออกจากระบบ</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>

</html>

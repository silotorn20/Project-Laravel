<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book_Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Alert -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        vertical-align: -14%
    }

    label {
        display: block;
        margin-bottom: 5px;
    }


    input[type="text"],
    input[type="number"],
    select {
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }


    input[type="submit"] {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border-radius: 10px;
        cursor: pointer;
    }


    .container-center {
        display: flex;
        justify-content: center;
        align-items: center;
    }


    .form-container {
        display: flex;
        margin-top: 5%;
    }


    .square {
        width: 500px;
        /* height: 400px; */
        /* background-color: #CCECFF; */
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        margin-right: 6%;
        margin-top: 3%;
        text-align: center;
    }

    .square img {
        max-width: 100%;
        max-height: 100%;
    }


    .square i {
        font-size: 24px;
        color: #545454;
        position: absolute;
    }


    .square input[type="file"] {
        display: none;
    }


    #preview {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
        display: none;
    }


    .fa-camera {
        font-size: 50px;
        color: #fff;
    }


    .form-content {
        display: flex;
        flex-direction: column;
        width: 100%;
    }


    .form-content div {
        margin-bottom: 0%;
    }


    .form-content .flex-row {
        display: flex;
        gap: 10%;
    }


    .form-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 10%;
        gap: 25px;
    }


    .form-actions .btn:first-child {
        margin-right: 2%;
    }

    .button-group {
        display: flex;
        gap: 10px;

    }

    .btn-size {
        width: 150px;
        height: 50px;
    }

    .navbar-nav {
        display: flex;
        align-items: center;
    }

    .nav-item {
        margin-right: 10px;
    }

    .btn-bottom {
        margin-bottom: 10px;
    }
    </style>
</head>

<body>
    @if(Auth::check())
    @include('navHome')
    @else
    @include('navbar')
    @endif
    @if(session('success'))
    <script>
    Swal.fire({
        icon: 'success',
        title: 'สำเร็จ',
        text: 'เพิ่มหนังสือลงในตะกร้าแล้ว!',
        confirmButtonColor: '#3085d6' // เปลี่ยนสีปุ่มตกลง
    });
    </script>
    @endif

    @if(session('error'))
    <script>
    Swal.fire({
        icon: 'error',
        title: 'มีข้อผิดพลาด',
        text: '{{ session("error") }}',
        confirmButtonColor: '#d33' // เปลี่ยนสีปุ่มตกลง
    });
    </script>
    @endif

    <!-- @if(session('book_in_cart'))
    <script>
    Swal.fire({
        icon: 'warning',
        title: 'แจ้งเตือน',
        text: 'มีหนังสือในตะกร้าแล้ว',
        confirmButtonColor: '#f39c12' // เปลี่ยนสีปุ่มตกลง
    });
    </script>
@endif -->
    <nav class="navbar navbar-expand-lg">
        <ul class="navbar-nav" style="margin-left:5%">
            <li class="nav-item">
                <a class="nav-link" href="{{ auth()->check() ? url('/home') : url('/') }}">
                    <i class="material-icons">home</i>
                </a>
            </li>
            <!-- <li class="nav-item">
                <span class="nav-link"><i class="material-icons">chevron_right</i></span>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="{{ url('/home') }}">หนังสือ</a>
            </li> -->
            <li class="nav-item">
                <span class="nav-separator"><i class="material-icons">chevron_right</i></span>
            </li>
            <li class="nav-item">
                @if (isset($Book))
                <a class="nav-link-current" href="#">{{$Book->name_book}}</a>
                @endif
            </li>
        </ul>
    </nav>

    <div class="container-center">
        <div class="form-container">
            <div class="square" style="display: flex; flex-direction: column-reverse;">
                @if(isset($Book))
                <img src="{{'../../public/images/' . $Book->image_book }}" alt="Image" style="width: 500px;">
                @else
                <img src="https://cdn-local.mebmarket.com/meb/server1/283512/Thumbnail/book_detail_large.gif?2"
                    alt="Default Image" style="width: 500px; background-color: #CCECFF;">
                @endif
                <!-- <img src="https://cdn-local.mebmarket.com/meb/server1/283512/Thumbnail/book_detail_large.gif?2"
                        alt="Image" style="width: 500px; height: 400px;"> -->
            </div>
            @if(isset($message))
            <p>{{ $message }}</p>
            @endif
            <div class="form-content" style="margin-top: 70px;">

                <div class="form-group row">
                    @if (isset($Book))
                    <label class="col-sm-10 col-form-label">ชื่อหนังสือ: {{$Book->name_book}}</label>
                    @endif
                </div>
                <div class="form-group row align-items-center">
                    @if ($setbook->isNotEmpty())
                    @foreach ($setbook as $book)
                    <label class="col-sm-4 col-form-label">ผู้เขียน : {{ $book->Firstname  }}</label>
                    @endforeach
                    @endif
                    <div>
                        @if (Auth::guard('member')->check())
                        @if ($loggedInMember->isFollowing($author->id_member))
                        <button type="button" class="btn btn-danger"
                            onclick="window.location.href='{{ route('member.unfollow', $author->id_member) }}'">
                            เลิกติดตาม
                        </button>
                        @else
                        <button type="button" class="btn btn-primary"
                            onclick="window.location.href='{{ route('member.follow', $author->id_member) }}'">
                            ติดตาม
                        </button>
                        @endif
                        @else
                        <button type="button" class="btn btn-primary"
                            onclick="alert('กรุณาเข้าสู่ระบบก่อนเพื่อทำการติดตาม')">
                            ติดตาม
                        </button>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    @if ($setbook->isNotEmpty())
                    @foreach ($setbook as $book)
                    <label class="col-sm-4 col-form-label">หมวดหมู่: {{ $book->nameSetBook  }}</label>
                    @endforeach
                    @endif


                </div>
                <div class="form-group row" style="margin-top:20px;">
                    <div class="col-lg-3" style="margin-bottom:10px">
                        <button type="button"
                            class="btn btn-outline-primary d-inline-flex align-items-center btn-size open-pdf"
                            onclick="window.location.href='{{ route('books.showPdf', $book->id_book) }}'">
                            <i class="material-icons ml-1" style="vertical-align: middle;">visibility</i>
                            <span class="ml-2">ทดลองอ่าน</span>
                        </button>
                    </div>
                    @if(Auth::check())
                    <!-- ถ้าผู้ใช้เข้าสู่ระบบแล้ว -->
                    <div class="col-lg-3" style="margin-bottom:10px">
                        <button type="button" class="btn btn-outline-primary d-inline-flex align-items-center btn-size"
                            onclick="{{ $hasPurchased ? 'event.preventDefault();' : ($Book->price == 0 ? 'window.location.href=\'' . route('pdf.viewer', $Book->id_book) . '\'' : 'window.location.href=\'' . route('cart.add', $Book->id_book) . '\'' ) }}"
                            {{ $hasPurchased ? 'disabled' : '' }}>
                            <i class="material-icons ml-1" style="vertical-align: middle;">shopping_cart</i>
                            @if (isset($Book))
                            <span
                                class="ml-2">{{ $hasPurchased ? 'ซื้อแล้ว' : ($Book->price == 0 ? 'ฟรี' : 'ซื้อ ' . $Book->price . ' ฿') }}</span>
                            @endif
                        </button>
                    </div>
                    <div class="col-lg-3 ">
                        <button type="button" class="btn btn-outline-primary d-inline-flex align-items-center btn-size"
                            onclick="window.location.href='{{ route('bookShelf.add',$Book->id_book) }}'">
                            <i class="material-icons ml-1" style="vertical-align: middle;">library_add</i>
                            <span class="ml-2">เพิ่มเข้าชั้น</span>
                        </button>
                    </div>
                    @else
                    <!-- ถ้าผู้ใช้ยังไม่ได้เข้าสู่ระบบ -->
                    <div class="col-lg-3" style="margin-bottom:10px">
                        <button type="button" class="btn btn-outline-primary d-inline-flex align-items-center btn-size"
                            @if(auth()->check())
                            onclick="window.location.href =
                            '{{ $Book->price == 0 ? route('myBook') : route('cart.add', $Book->id_book) }}';"
                            @else
                            onclick="alert('กรุณาเข้าสู่ระบบก่อน');"
                            @endif>
                            <i class="material-icons ml-1" style="vertical-align: middle;">shopping_cart</i>
                            @if (isset($Book))
                            <span class="ml-2">{{ $Book->price == 0 ? 'ฟรี' : 'ซื้อ ' . $Book->price . ' ฿' }}</span>
                            @endif
                        </button>
                    </div>
                    <div class="col-lg-3" style="margin-bottom:10px">
                        <button type="button" class="btn btn-outline-primary d-inline-flex align-items-center btn-size"
                            onclick="alert('กรุณาเข้าสู่ระบบก่อนทำรายการ');">
                            <i class="material-icons ml-1" style="vertical-align: middle;">library_add</i>
                            <span class="ml-2">เพิ่มเข้าชั้น</span>
                        </button>
                    </div>
                    @endif
                    <!-- </div> -->
                </div>
                <div class="form-group row " style="margin-top: 20px;">
                    <div class="col-sm-3">
                        <label class="col-form-label">ยอดวิว</label>
                        <div>
                            <label class="col-form-label">
                                @php
                                $totalViews = isset( $totalViewsBybook[$book->id_book]) ?
                                $totalViewsBybook[$book->id_book] : 0;
                                @endphp
                                {{$totalViews}}
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label class="col-form-label">ความคิดเห็น</label>
                        <div><label class="col-form-label">
                                @php
                                $count = isset($reviewsCountBybook[$book->id_book]) ?
                                $reviewsCountBybook[$book->id_book] : 0;
                                @endphp
                                {{ $count }}
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label class="col-form-label">จำนวนหน้า</label>
                        @if (isset($Book))
                        <div>
                            <label class="col-form-label">{{$Book->amount_page}}</label>
                        </div>
                        @endif
                    </div>
                    <div class="col-sm-3">
                        <label class="col-form-label">ประเภทไฟล์</label>
                        <div class="col-sm-2">
                            <label class="col-form-label">pdf</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

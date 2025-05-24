<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@100;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
    /* Global Font Settings */
    label {
        font-family: 'Sarabun', sans-serif;
    }

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

    .circular-img {
        border-radius: 100%;
        width: 50%;
        height: 50%;
    }

    .search-form {
        display: flex;
        align-items: center;
        width: 100%;
    }

    .card-custom {
        width: 100px;
        height: 100px;
        overflow: hidden;

    }

    .card-custom img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .no-results {
        text-align: center;
        margin-top: 20px;
        font-size: 1.2em;
        color: #888;
    }

    .category-select {
        display: flex;
        align-items: center;
        margin-right: 10px;
    }

    .category-select label {
        margin-right: 5px;
    }

    .category-select select {
        padding: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 1em;
        width: 200px;
    }

    .search-wrapper {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .search-input {
        padding-left: 35px;
        /* ปรับให้เข้ากับขนาดของปุ่ม */
        width: 150%;
        /* ให้พื้นที่มากขึ้น */
    }

    .search-icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #888;
        z-index: 1;
        /* ทำให้ปุ่มอยู่เหนือ input */
    }

    .button-container {
        margin-top: 10px;
        /* Adjust margin as needed */
    }

    .col-justify label {
        text-align: right;
        display: block;
        /* Ensure it's applied to the full width */
    }
    </style>
</head>

<body>
    @if(Auth::check())
    @include('navHome')
    @else
    @include('navbar')
    @endif

    <div class="container">
        <h2 style="margin-top:2%">ค้นหา</h2>
        <form action="{{ route('search') }}" method="GET">
            <div class="search-wrapper">
                <div class="form-group">
                    <label for="category" style="margin-bottom: 5px; font-weight: bold;">หมวดหมู่</label>
                    <select name="category" id="category" class="form-control">
                        <option value="ทั้งหมด">ทั้งหมด</option>
                        @foreach ($setBooks as $setBook)
                        <option value="{{ $setBook->id_setbook }}"
                            {{ request('category') == $setBook->id_setbook ? 'selected' : '' }}>
                            {{ $setBook->nameSetBook }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="search-query" style="margin-bottom: 5px; font-weight: bold;">คำค้นหา</label>
                    <input class="  form-control " type="search" name="query" aria-label="Search"
                        value="{{ request('query') }}" style="width: 800px;">
                </div>

                <div class="form-group">
                    <label for="search_by" style="margin-bottom: 5px; font-weight: bold;">ค้นหาตาม:</label>
                    <select name="search_by" id="search_by" class="form-control">
                        <option value="book" {{ request('search_by') == 'book' ? 'selected' : '' }}>ชื่อเรื่อง</option>
                        <option value="writer" {{ request('search_by') == 'writer' ? 'selected' : '' }}>ชื่อผู้แต่ง
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    </button>
                    <button type="submit" class="btn" style="background-color: #ffffff; color: #000; width: 100%; margin-top: 40px; ">
                        <span class="material-icons">search</span>
                    </button>
                </div>
            </div>
            <hr>
        </form>

        @if(count($writers) > 0)
        <div class="container">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-3 col-justify">
                    <!-- <h4 style="text-align: center;">ชื่อผู้แต่ง</h3> -->
                    <label style="text-align: center; font-weight: bold;">ชื่อผู้แต่ง</label>
                </div>
                <div class="col-sm-3 col-justify">
                    <label style="text-align: center; font-weight: bold;">จำนวนเรื่อง</label>
                </div>
                <div class="col-sm-3 col-justify">
                    <label style="text-align: center; font-weight: bold;">จำนวนผู้ติดตาม</label>
                </div>
            </div>
        </div>
        @foreach($writers as $writer)
        <div class="container">
            <div class="row book-row" style="margin-top:5%">
                <div class="col-sm-3 text-center ">
                    <img src="{{ asset('public/profiles/' . $writer->profile) }}" alt="Profile Image"
                        style="width: 70%; height: 100%; object-fit: cover;">
                </div>
                <div class="col-sm-3 text-center">
                    <label style="text-align: center; ">{{ $writer->Firstname }}</label>
                </div>
                <div class="col-sm-3 text-center">
                    <label style="text-align: center;">{{ $bookCounts[$writer->id_member] ?? 0 }}</label>
                </div>
                <div class="col-sm-3 text-center">
                    <label style="text-align: center;">{{ $followersCount[$writer->id_member] ?? 0 }}</label>
                </div>
            </div>
        </div>
        @endforeach
        @endif

        @if(count($books) > 0)
        <div class="container">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-3 col-justify">
                    <label style="text-align: center; font-weight: bold;">ชื่อหนังสือ</label>

                </div>
                <div class="col-sm-3 col-justify">
                    <label style="text-align: center; font-weight: bold;">หมวดหมู่</label>
                </div>

            </div>
        </div>
        @foreach($books as $book)
        <div class="container">
            <div class="row book-row" style="margin-top:5%">
                <div class="col-sm-3 text-center">
                    <a href="{{ url('/bookPage/' . $book->id_book) }}">
                        <img src="{{ asset('public/images/' . $book->image_book) }}" alt="Profile Image"
                            style="width: 60%; height: 100%; object-fit: cover;">
                    </a>
                </div>
                <div class="col-sm-3 text-center">
                    <!-- จัดตำแหน่งเป็น text-center เพื่อให้ตรงกัน -->
                    <label>{{ $book->name_book }}</label>
                </div>
                <div class="col-sm-3 text-center">
                    <!-- ปรับ text-align ให้ตรงกัน -->
                    <label>{{ $book->nameSetBook }}</label>
                </div>

            </div>
        </div>
        @endforeach
        @endif

        @if(count($writers) === 0 && count($books) === 0)
        <div class="no-results">ไม่พบผลลัพธ์ที่ตรงกัน</div>
        @endif
    </div>
</body>

</html>

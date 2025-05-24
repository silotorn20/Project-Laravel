<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <style>
    body {
        font-family: 'Sarabun', sans-serif;
    }

    h1 {
        text-align: center;
        background-color: #EBF8FD;
        padding: 20px;
        border-radius: 10px;
    }

    .book-cover {
        max-width: 150px;
        margin-bottom: 20px;
    }

    .slider {
        position: relative;
        width: 100%;
        overflow: hidden;
        border-radius: 10px;
        margin-top: 2%;
        max-width: 100%;
    }

    .slides {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .slide {
        display: flex;
        width: 100%;
        flex: 1 0 100%;
    }

    .slide-part {
        flex: 1;
        overflow: hidden;
    }

    .slide-part img {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }

    /* button {
        background-color: rgba(0, 0, 0, 0.5);
        border: none;
        color: white;
        padding: 10px;
        cursor: pointer;
        border-radius: 50%;
        z-index: 10;
    }

    button.prev {
        left: 8px;
    }

    button.next {
        right: 8px;
    } */

    a.carousel-control-prev,
    a.carousel-control-next {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        text-decoration: none;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
    }

    a.carousel-control-prev {
        left: 10px;
    }

    a.carousel-control-next {
        right: 10px;
    }

    .dots {
        text-align: center;
        margin-top: 10px;
    }

    .dot {
        display: inline-block;
        height: 10px;
        width: 10px;
        margin: 0 5px;
        background-color: #bbb;
        border-radius: 50%;
        cursor: pointer;
    }

    .action {
        background-color: #717171;
    }

    .w3-container {
        margin-left: 4%;
    }

    .card-container {
        margin-left: 5%;
        display: flex;
        flex-wrap: wrap;
    }

    .card {
        position: relative;
        /* เพิ่มตำแหน่ง relative เพื่อให้สามารถจัดวางปุ่มได้ */
        width: calc(15% - 15px);
        background-color: #e3f2fd;
        margin-left: 4%;
        margin-top: 2%;
    }

    .btn {
        align-self: flex-end;
    }
    .card-body {
        margin-left: 5%;
        color: #545454;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }
    </style>
</head>

<body>
    @include('navHome')
    <h1>หนังสือของฉัน</h1>
    <div class="w3-container">
        <div class="card-container">
            @foreach($books as $book)
            <div class="card" style=" width: calc(15% - 15px);background-color: #e3f2fd;margin-left:4%;margin-top:2%;">
                <!-- <img src="{{ asset('storage/image/images.jpg') }}" class="book-image" alt="รูปภาพหนังสือ" style="width: 80%;margin-left:10%"> -->
                <img src="{{ '../../public/images/' . $book->image_book }}" class="book-image" alt="รูปภาพหนังสือ"
                    style="width: 80%;margin-left:10%">

                <div class="card-body">
                    <h5 style="color:#545454">{{ $book->name_book }}</h5>
                    <h5 style="color:#545454">{{ $book->Firstname }}</h5>
                    <h5 style="color:#545454">หมวดหมู่ : {{ $book->nameSetBook }}</h5>
                    @if($book->status == 3)
                    <!-- ถ้าสถานะเป็น 3 แสดงปุ่มอ่านและลิงก์ไปยังไฟล์ PDF -->
                    <form action="{{ route('books.storeReadBook', $book->id_book) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-read" style="float: right;">
                            <span class="ml-2">อ่าน</span>
                        </button>
                    </form>

                    @elseif($book->status == 2)
                    <!-- ถ้าสถานะเป็น 2 ไม่สามารถอ่านได้ -->
                    <button class="btn btn-secondary btn-read" style="float: right;" disabled>อ่าน</button>
                    @else
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>

</html>

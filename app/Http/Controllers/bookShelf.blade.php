<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <style>
    .book-cover {
        max-width: 150px;
        margin-bottom: 20px;
    }
    h1 {
        text-align: center;
        background-color: #EBF8FD;
        padding: 20px;
        border-radius: 10px;
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

    .card-body {
        margin-left: 5%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }


    body {
        font-family: 'Sarabun', sans-serif;
    }
    </style>
</head>

<body>
    @include('navHome')
    <h1>ชั้นหนังสือ</h1>
    <div class="w3-container">
        <div class="card-container">
            @foreach($books as $book)
            <a href="{{ url('/bookPage/' . $book->id_book) }}">
            <div class="card" style=" width: calc(15% - 15px);background-color: #e3f2fd;margin-left:4%;margin-top:2%;">
                <!-- <img src="{{ asset('storage/image/images.jpg') }}" class="book-image" alt="รูปภาพหนังสือ" style="width: 80%;margin-left:10%"> -->
                <img src="{{ '../../public/images/' . $book->image_book }}" class="book-image" alt="รูปภาพหนังสือ" style="width: 80%;margin-left:10%">

                <div class="card-body">
                    <h5 style="color:#545454">{{ $book->name_book }}</h5></a>
                    <h5 style="color:#545454">{{ $book->Firstname }}</h5>
                    <h5 style="color:#545454">หมวดหมู่ : {{ $book->nameSetBook }}</h5>
                    <form action="{{ route('BookShelfs.remove', $book->id_book) }}" method="POST"
                        onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบหนังสือเล่มนี้ออกจากชั้นหนังสือ');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('ต้องการลบหรือไม่?')"
                            style="background: none; border: none; padding: 0; float: right;">
                            <img src="{{ '../../public/storage/image/delete.png' }}" alt="" width="20px">
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>



</html>

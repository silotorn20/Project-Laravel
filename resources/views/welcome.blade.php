<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
    body {}

    .slider {
        position: relative;
        width: 100%;
        overflow: hidden;
        border-radius: 10px;
        margin-top: 2%;
        /* max-width: 100%; */
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
        display: flex;
        flex-wrap: wrap;
    }

    .card {
        position: relative;
        background-color: #e3f2fd;
        margin-top: 2%;
    }

    .card-body {
        margin-left: 5%;
        color: #545454;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .book-title {
        color: #545454;
        line-height: 1.5;
        max-height: 3em;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
        word-wrap: break-word;
    }

    .btn {
        align-self: flex-end;
    }

    h5 {
        font-family: 'Sarabun', sans-serif;
    }
    </style>

</head>

<body>
    @include('navbar')
    <div class="slider">
        <!-- <button class="prev" onclick="prevSlide()">&#10094;</button> -->
        <div class="slides">
            <div class="slide">
                <div class="slide-part">
                    <img src="{{ '../../public/storage/image/1.png' }}" alt="Image 1" style="width:90%;margin-left:10%">
                </div>
                <div class="slide-part">
                    <img src="{{ '../../public/storage/image/2.png' }}" alt="Image 2" style="width:90%;margin-left:5%">
                </div>
                <div class="slide-part">
                    <img src="{{ '../../public/storage/image/3.png' }}" alt="Image 3" style="width:90%;">
                </div>
            </div>
            <div class="slide">
                <div class="slide-part">
                    <img src="{{ '../../public/storage/image/1.png' }}" alt="Image 1" style="width:90%;margin-left:10%">
                </div>
                <div class="slide-part">
                    <img src="{{ '../../public/storage/image/2.png' }}" alt="Image 1" style="width:90%;margin-left:5%">
                </div>
                <div class="slide-part">
                    <img src="{{ '../../public/storage/image/3.png' }}" alt="Image 1" style="width:90%;">
                </div>
            </div>
        </div>
        <!-- <button class="next" onclick="nextSlide()">&#10095;</button> -->
        <a class="carousel-control-prev" onclick="prevSlide()" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" onclick="nextSlide()" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div class="dots">
        <span class="dot" onclick="currentSlide(0)"></span>
        <span class="dot" onclick="currentSlide(1)"></span>
    </div>
    <script>
    let currentSlide = 0;

    function showSlide(index) {
        const slides = document.querySelector('.slides');
        const totalSlides = document.querySelectorAll('.slide').length;
        if (index >= totalSlides) {
            currentSlide = 0;
        } else if (index < 0) {
            currentSlide = totalSlides - 1;
        } else {
            currentSlide = index;
        }
        slides.style.transform = `translateX(-${currentSlide * 100}%)`;
        updateDots();
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    // Automatically show the first slide
    showSlide(currentSlide);

    function updateDots() {
        const dots = document.querySelectorAll('.dot');
        dots.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.classList.add('action');
            } else {
                dot.classList.remove('action');
            }
        });
    }
    </script>
    <div class="w3-container" style="margin-left:4%">
        <h2>5 อันดับหนังสือที่ขายดี</h2>
        <div class="container-fluid">
            <div class="card-container row flex-nowrap overflow-auto" style="margin-left: 0;">
                @foreach($topBooks as $book)
                <a href="{{ url('/bookPage/' . $book->id_book) }}">
                    <div class="card  col-lg-2 col-md-3 col-sm-4 col-6 p-2 book-card"
                        data-category="{{ $book->nameSetBook }}"
                        style=" width: calc(15% - 15px);background-color: #e3f2fd;margin-left:2%;margin-top:2%;">
                        <img src="{{ '../../public/images/' . $book->image_book }}" class="book-image"
                            alt="รูปภาพหนังสือ" style="width: 80%;margin-left:10%">
                        <div class="card-body">
                            <h5 class="book-title">{{ $book->name_book }}</h5>
                            <h5 style="color:#545454">{{ $book->Firstname }}</h5>
                            <h5 style="color:#545454">หมวดหมู่ : {{ $book->nameSetBook }}</h5>
                            <a href="#" class="btn btn-primary" style="float: right;">{{ $book->price }}฿</a>
                        </div>
                    </div>
                    @endforeach
            </div>
        </div>
        <div class="card-container row">
            @foreach($otherBooks as $book)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2" style="margin-top: 2%;">
                <a href="{{ url('/bookPage/' . $book->id_book) }}">
                    <div class="card  book-card" data-category="{{ $book->nameSetBook }}"
                        style="background-color: #e3f2fd; width: 100%; height: 100%;">
                        <img src="{{ '../../public/images/' . $book->image_book }}" class="book-image"
                            alt="รูปภาพหนังสือ" style="width: 80%; margin-left:10%">
                        <div class="card-body">
                            <h5 class="book-title">{{ $book->name_book }}</h5>
                            <h5 style="color:#545454">{{ $book->Firstname }}</h5>
                            <h5 style="color:#545454;">หมวดหมู่ : {{ $book->nameSetBook }}</h5>
                            <a href="#" class="btn btn-primary" style="float: right;">{{ $book->price }}฿</a>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('.category-item').click(function(event) {
            event.preventDefault();
            var selectedCategory = $(this).data('category');

            $('.book-card').each(function() {
                var cardCategory = $(this).data('category');
                if (selectedCategory === 'ทั้งหมด' || selectedCategory === cardCategory) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
    </script>
</body>

</html>

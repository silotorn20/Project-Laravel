<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการอ่าน</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    h1 {
        text-align: center;
        background-color: #EBF8FD;
        padding: 20px;
        border-radius: 10px;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
    }

    .header {
        background-color: #e3f2fd;
        padding: 10px;
        text-align: center;
        font-size: 2.0rem;
    }

    .navbar {
        background-color: #e3f2fd;
        padding: 10px;
    }

    .book-list {
        margin-top: 20px;
    }

    .book-item {
        display: flex;
        align-items: center;
        padding: 15px;
        background-color: transparent;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    .book-image {
        width: 80px;
        height: auto;
        margin-right: 20px;
        border-radius: 5px;
    }

    .book-info {
        flex-grow: 1;
    }

    .book-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .book-publisher {
        font-size: 1rem;
        color: #6c757d;
    }

    .book-date {
        font-size: 0.9rem;
        color: #6c757d;
        text-align: right;
    }
    </style>
</head>

<body>
    @include('navHome')

    <h1>ประวัติการอ่าน</h1>
    <div class="container book-list">
        @foreach ($historyRead as $record)
        <div class="row book-item">
            <div class="col-md-2">
                <img src="{{ '../../public/images/' . $record->image_book }}" alt="Book Image" class="book-image">
            </div>
            <div class="col-md-8 book-info">
                <div class="book-title">{{ $record->name_book }}</div>
                <div class="book-publisher">{{ $record->author_firstname }}</div>
            </div>
            <div class="col-md-2 book-date">{{ \Carbon\Carbon::parse($record->date)->format('d M Y H:i') }}</div>
        </div>
        @endforeach
    </div>

</body>

</html>
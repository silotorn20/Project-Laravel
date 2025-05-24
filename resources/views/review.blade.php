<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="//unpkg.com/alpinejs" defer></script>
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
        width: 300px;
        height: 200px;
        background-color: #CCECFF;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        margin-right: 6%;
        margin-top: 3%;
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
        margin-top: 20%;
        gap: 10px;
    }


    .form-actions .btn:first-child {
        margin-right: auto;
    }

    .star {
        font-size: 24px;
        color: gray;
        transition: color 0.3s;
    }

    .star:hover {
        color: gold;
    }

    .star:hover~.star {
        color: gold;
    }

    .star:hover~.star::before {
        color: gold;
    }
    </style>
</head>


<body>
    @include('navHome')
    <div class="container mt-5">
        <label for="comment" style="font-size:150%;">แสดงความคิดและรีวิว</label>
        <div class="card" style="width: 100%; border-color: blue">
            <div class="form-group">

                <textarea class="form-control" rows="5" id="comment" placeholder="เพิ่มความคิดเห็นของคุณ"
                    style="border:none; resize:none; outline: none; -webkit-box-shadow: none;-moz-box-shadow: none; box-shadow: none;"></textarea>
            </div>
            <div style="display: flex; justify-content:end; padding: 2%">
                <button class="btn btn-primary">submit</button>
            </div>

        </div>

        <!-- ใช้ Material Icons ที่สามารถกดได้ -->
        <div class="rating">
            <span class="star" data-value="1">★</span>
            <span class="star" data-value="2">★</span>
            <span class="star" data-value="3">★</span>
            <span class="star" data-value="4">★</span>
            <span class="star" data-value="5">★</span>
        </div>

        <div id="rating-output"></div>

        <form id="rating-form" method="POST" action="">
            @csrf
            <input type="hidden" id="rating-input" name="rating" value="0">
            <button type="submit" style="display:none;">Submit Rating</button>
        </form>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const stars = document.querySelectorAll(".star");
            const ratingOutput = document.getElementById("rating-output");
            const ratingInput = document.getElementById("rating-input");
            const form = document.getElementById("rating-form");

            let selectedRating = 0;

            stars.forEach((star) => {
                star.addEventListener("mouseover", () => {
                    const value = parseInt(star.getAttribute("data-value"));
                    stars.forEach((s) => {
                        s.style.color = s.getAttribute("data-value") <= value ? "gold" :
                            "gray";
                    });
                });

                star.addEventListener("mouseout", () => {
                    stars.forEach((s) => {
                        s.style.color = s.getAttribute("data-value") <= selectedRating ?
                            "gold" : "gray";
                    });
                });

                star.addEventListener("click", () => {
                    selectedRating = parseInt(star.getAttribute("data-value"));
                    stars.forEach((s) => {
                        s.style.color = s.getAttribute("data-value") <= selectedRating ?
                            "gold" : "gray";
                    });
                    ratingOutput.textContent = `คุณให้คะแนน: ${selectedRating} ดาว`;

                    // Set value in hidden input field
                    ratingInput.value = selectedRating;

                    // Submit form automatically
                    form.submit();
                });
            });
        });
        </script>
    </div>
</body>


</html>

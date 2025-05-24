<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Viewer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
    /* body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    } */

    #pdfViewer {
        width: 100%;
        height: 80vh;
        border: 1px solid #ced4da;
        background-color: #ffffff;
        overflow: auto;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    canvas {
        max-width: 100%;
        max-height: 100%;
        border: 1px solid #ced4da;
    }

    .nav-buttons {
        margin: 20px;
        display: flex;
        justify-content: center;
    }

    .nav-buttons button {
        margin: 0 10px;
    }

    .container {
        margin-top: 30px;
    }

    .form-actions .btn {
        border-radius: 20px;
    }

    .rating {
        display: flex;
    }

    .star {
        font-size: 30px;
        color: gray;
        cursor: pointer;
        transition: color 0.3s;
    }

    .star:hover {
        color: gold;
    }

    .star.selected {
        color: gold;
    }

    .star1 {
        font-size: 30px;
        /* Adjust size as needed */
        color: gray;
        /* Color for empty stars */
    }

    .star1.filled {
        color: gold;
        /* Color for filled stars */
    }

    .circle-frame {
        display: flex;
        align-items: center;
        margin: 2%;
    }

    .circle-frame img {
        border-radius: 50%;
        width: 50px;
        height: 50px;
        object-fit: cover;
        margin-right: 10px;
    }
    </style>
</head>

<body>
    <div class="container">
        <button onclick="window.history.back();" class="btn btn-secondary mb-4">ย้อนกลับ</button>
        <div class="nav-buttons">
            <button id="prevPage" class="btn btn-primary">Previous</button>
            <button id="nextPage" class="btn btn-primary">Next</button>
        </div>
        <div id="pdfViewer"></div>
        <div class="container mt-5">
            <div class="card" style="border-color: blue; padding: 5px; margin-top:3%">
                <div class="reviews">
                    @forelse($reviews as $review)
                    <div class="review-item">
                        <div class="circle-frame" style="margin: 2%;">
                            <img src="{{ '../../public/profiles/' . $review->profile  }}" alt="Your Image">
                            <div class="text">
                                <span style="font-size: 20px;">{{ $review->Firstname}}</span>
                            </div>
                        </div>
                        <div style="margin-top:2%; margin-left:4%; font-size: 20px;"> {{ $review->detail }}</div>
                        <div style="display: flex; justify-content:end; padding: 2%">
                            <!-- Display stars based on score -->
                            @for($i = 1; $i <= 5; $i++) <span
                                class="star1 {{ $i <= $review->score_review ? 'filled' : '' }}">
                                ★</span>
                                @endfor
                        </div>
                    </div>
                    @empty
                    <p>ยังไม่มีความคิดเห็น</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <label for="comment" style="font-size:150%;">แสดงความคิดและรีวิว</label>
            <div class="card" style="border-color: blue; padding: 5px;">
                <div class="card-body">
                    <form id="rating-form" method="POST" action="{{ route('reviews.store',['id_book' => $id_book]) }}"
                        class="mt-3">
                        @csrf
                        <!-- ใช้ Material Icons ที่สามารถกดได้ -->
                        <div class="rating mt-3">
                            <span class="star" data-value="1">★</span>
                            <span class="star" data-value="2">★</span>
                            <span class="star" data-value="3">★</span>
                            <span class="star" data-value="4">★</span>
                            <span class="star" data-value="5">★</span>
                        </div>

                        <div class="form-group mt-3">
                            <textarea class="form-control" rows="5" id="comment" name="detail"
                                placeholder="เพิ่มความคิดเห็นของคุณ"
                                style=" resize:none; border-color: blue; outline: none; -webkit-box-shadow: none;-moz-box-shadow: none; box-shadow: none;"></textarea>
                        </div>

                        <div id="rating-output" class="mt-2"></div>

                        <input type="hidden" id="rating-input" name="score_review" value="0">
                        <div style="display: flex; justify-content:end; padding: 2%">
                            <button type="submit" class="btn btn-primary">เพิ่มรีวิว</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var url = '{{ $pdfUrl }}';
            var pdfViewer = document.getElementById('pdfViewer');
            var currentPage = 1;
            var totalPages = 0;
            var pagesToDisplay = 2; // จำนวนหน้าที่จะแสดง

            function renderPage(pageNum) {
                pdfjsLib.getDocument(url).promise.then(function(pdf) {
                    pdf.getPage(pageNum).then(function(page) {
                        var viewport = page.getViewport({
                            scale: 1.5
                        });
                        var canvas = document.createElement('canvas');
                        var context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;
                        pdfViewer.innerHTML = ''; // ล้างหน้าที่แสดงอยู่
                        pdfViewer.appendChild(canvas);

                        var renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };
                        page.render(renderContext);
                    });
                });
            }

            function updatePageCount(pdf) {
                totalPages = pdf.numPages;
            }

            function goToPage(pageNum) {
                if (pageNum >= 1 && pageNum <= pagesToDisplay && pageNum <= totalPages) {
                    currentPage = pageNum;
                    renderPage(currentPage);
                }
            }

            pdfjsLib.getDocument(url).promise.then(function(pdf) {
                updatePageCount(pdf);
                renderPage(currentPage);
            });

            document.getElementById('prevPage').addEventListener('click', function() {
                goToPage(currentPage - 1);
            });

            document.getElementById('nextPage').addEventListener('click', function() {
                goToPage(currentPage + 1);
            });
        });

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
                    // form.submit();
                });
            });
        });
        </script>
</body>

</html>

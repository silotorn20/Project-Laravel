<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ตะกร้าหนังสือ</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
    h1 {
        text-align: center;
        background-color: #EBF8FD;
        padding: 20px;
        border-radius: 10px;
    }

    .book-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        margin-bottom: 5%;
    }

    .book-image {
        width: 150px;
        height: auto;
        margin-right: 20px;
        object-fit: cover;
        /* ทำให้รูปภาพถูกจัดให้แสดงทั้งหมด */
    }

    .col-justify {
        display: flex;
        justify-content: center;
        align-items: center;

    }

    .quantity-control {
        display: flex;
        align-items: center;
    }

    .quantity-control input {
        width: 40px;
        text-align: center;
        margin: 0 5px;
        padding: 2px;
    }

    .quantity-control button {
        padding: 2px 5px;
        font-size: 12px;
        border: none;
        background-color: #007bff;
        color: white;
        border-radius: 4px;
        cursor: pointer;
    }

    .quantity-control button:hover {
        background-color: #0056b3;
    }

    .checkout-button {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-left: 10px;
    }

    /* 
    .checkout-button:hover {
        background-color: #218838;
    } */

    .total-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 5%;
    }

    .remove-button {
        background-color: transparent;
        border: none;
        cursor: pointer;
        color: #dc3545;
        margin-left: 10px;
    }

    .remove-button .material-icons {
        font-size: 20px;
    }

    h5 {
        margin: 0;
        /* ลบระยะห่างขอบบนและขอบล่างของชื่อหนังสือ */
        line-height: 1.2;
        /* กำหนดระยะห่างระหว่างบรรทัด */
    }

    .empty-message {
        text-align: center;
        color: red;
        margin-top: 50px; 
    }
    </style>
</head>

<body>

    @include('navHome')
    <h1>ตะกร้าหนังสือ</h1>
    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-3 col-justify">
                <label for=""style="margin-top:30px ; font-weight: bold; font-size: 25px;" >ชื่อหนังสือ</label>
                
            </div>
            <div class="col-sm-3 col-justify">
            <label for=""style="margin-top:30px ; font-weight: bold; font-size: 25px;" >ราคา</label>
            </div>
        </div>
    </div>
    @if(count($showcart) > 0)
    @foreach ($showcart as $book)
    <div class="container">
        <div class="row book-row" style="margin-top:5%" data-book-id="{{ $book->id_book }}">
            <div class="col-sm-3">
                <img src="{{ '../../public/images/' . $book->image_book }}" alt="Book Image" class="book-image">
            </div>
            <div class="col-sm-3 col-justify">
                <label for="">{{ $book->name_book }}</label>
               
            </div>
            <div class="col-sm-3 col-justify">
                <label for="">{{ $book->price }}</label>
            </div>
            <div class="col-sm-3 col-justify">
                <div class="quantity-control">
                    <form action="{{ route('cartBooks.remove', $book->id_book) }}" method="POST"
                        onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบหนังสือเล่มนี้ ');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('ต้องการลบหรือไม่?')"
                            style="background: none; border: none; padding: 0;">
                            <img src="{{ '../../public/storage/image/delete.png' }}" alt="" width="20px">
                        </button>
                    </form>

                    <!-- <button class="remove-button" onclick="removeBook(this, {{ $book->id_book }})">
                        <i class="material-icons">delete</i>
                    </button> -->

                </div>
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div class="container">
        <h4 class="empty-message">ไม่มีหนังสือในตะกร้า</h4>
    </div>
    @endif
    <hr>
    <div class="container">
        <div class="row total-section">
            <div class="col-sm-3">
            <label for=""style="font-weight: bold; font-size: 25px;">ราคารวม</label>
              
            </div>
            <div class="col-sm-3 col-justify">

            </div>
            <div class="col-sm-3 col-justify">
            <label for=""style="font-weight: bold;">{{ $totalPrice }}</label>
              
            </div>
            <div class="col-sm-3 col-justify">
                <form id="checkout-form" method="POST" action="{{ route('checkout') }}">
                    @csrf
                    <!-- <button type="submit" class="checkout-button" >ไปที่หน้าชำระ</button> -->
                    <button type="submit" class="checkout-button" id="checkout-button">ไปที่หน้าชำระ</button>
                </form>
            </div>
        </div>
    </div>
    <!-- <script>
    function removeBook(button, bookId) {
        if (confirm('Are you sure you want to remove this book?')) {
            var row = button.closest('.row');

            fetch(`/removeBook/${bookId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the book row from the DOM
                        row.remove();
                        alert(data.message);
                        // Optionally, update the total price or cart count here if needed
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }
    </script> -->
    <!-- <script>
        // ตรวจสอบว่ามีหนังสือในตะกร้าหรือไม่
        document.addEventListener("DOMContentLoaded", function () {
            var totalBooks = {{ count($showcart) }};
            var checkoutButton = document.getElementById('checkout-button');

            if (totalBooks === 0) {
                // ปิดการใช้งานปุ่มชำระเงิน
                checkoutButton.disabled = true;
                alert("ไม่มีสินค้าในตะกร้า");
            }
        });
    </script> -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var totalBooks = {{ count($showcart) }}; // นับจำนวนสินค้าที่อยู่ในตะกร้า
        var checkoutButton = document.getElementById('checkout-button');

        if (totalBooks === 0) {
            // ปิดการใช้งานปุ่มชำระเงิน
            checkoutButton.disabled = true;
            checkoutButton.style.backgroundColor = '#6c757d'; // เปลี่ยนสีปุ่มเพื่อแสดงว่าไม่สามารถใช้งานได้
        }
    });
</script>

</body>

</html>
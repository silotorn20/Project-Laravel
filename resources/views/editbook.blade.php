<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
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
        width: 200px;
        height: 300px;
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
        margin-bottom: 5%;
    }

    .form-content .flex-row {
        display: flex;
        gap: 10%;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        /* margin-top: 10%; */
    }

    .form-actions .btn:first-child {
        margin-right: 2%;
    }

    .text-danger {
        font-size: 18px;
    }
    </style>
</head>

<body>
    @include('navHome')
    <!-- Flash Message Section -->

    <div class="container-center">
        <div class="form-container">
            <div class="form-content">
                <form id="update-form" action="{{ route('editbook', $book->id_book) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col">
                            <div class="square" onclick="document.getElementById('image_book').click();">
                                <i class="fas fa-camera"
                                    style="display: {{ $book->image_book ? 'none' : 'block' }}"></i>
                                <input type="file" id="image_book" name="image_book" accept="image/*"
                                    onchange="handleFileSelect(event)">
                                <img id="preview" src="{{ '../../public/images/' . $book->image_book }}"
                                    alt="Image Preview" style="display: {{ $book->image_book ? 'block' : 'none' }}">
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <label for="name_book">ชื่อหนังสือ</label>
                                <input type="text" id="name_book" name="name_book" value="{{ $book->name_book }}">

                                @if(session('error'))
                                <div>
                                    <span class="text-danger">{{ session('error') }}</span>
                                </div>
                                @endif
                            </div>
                            <div>
                                <label for="file_book">อัพโหลดไฟล์หนังสือ:</label>
                                <input type="file" name="file_book">
                                @error('file_book')
                                <div>
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                            <div class="flex-row">
                                <div>
                                    <label for="category">หมวดหมู่</label>
                                    <select name="category" id="category">
                                        @foreach ($setBooks as $setBook)
                                        <option value="{{ $setBook->id_setbook }}"
                                            {{ $setBook->id_setbook == $book->id_setbook ? 'selected' : '' }}>
                                            {{ $setBook->nameSetBook }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="price">ราคา</label>
                                    <input type="number" id="price" name="price" value="{{ $book->price }}" min="0">
                                    @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex-row">
                                <div>
                                    <label for="amount_page">จำนวนหน้า</label>
                                    <input type="number" id="amount_page" name="amount_page"
                                        value="{{ $book->amount_page }}" min="0">
                                    @error('amount_page')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn" type="submit"
                            style="background-color: #CCECFF; color: #545454;">แก้ไขข้อมูล</button>
                        <a href="{{ route('writer.showWorks', ['id_member' => Auth::user()->id_member]) }}" class="btn"
                            style="background-color:#FFFFFF;color:#545454; border: 1px solid #545454; text-decoration: none; padding: 10px 20px; display: inline-block;">
                            ยกเลิกการแก้ไข
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    function handleFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview');
                const icon = document.querySelector('.square i');
                preview.src = e.target.result;
                preview.style.display = 'block';
                icon.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateForm = document.getElementById('update-form');

        updateForm.addEventListener('submit', function(event) {
            if (confirm('ต้องการบันทึกการเปลี่ยนแปลงหรือไม่?')) {
                alert('แก้ไขข้อมูลเรียบร้อยแล้ว');
                this.submit(); // ทำการส่งฟอร์ม
            } else {
                event.preventDefault(); // หยุดการส่งฟอร์มถ้าผู้ใช้ไม่ยืนยัน
            }
        });
    });
    </script>
</body>

</html>
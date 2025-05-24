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

    .error {
        color: red;
        font-size: 0.875em;
        margin-top: 5px;
    }
    </style>
</head>

<body>
    @include('navHome')
    <div class="container-center">
        <div class="form-container">
            <!-- <div class="square" onclick="document.getElementById('image_book').click();">
                        <i class="fas fa-camera"></i>
                        <input type="file" id="image_book" accept="image/*" onchange="handleFileSelect(event)" required>
                        <img id="preview" src="#" alt="Image Preview">
                    </div> -->

            <div class="form-content">
                <form id="update-form" action="{{route('upload.post')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="square" onclick="document.getElementById('image_book').click();">
                                <i class="fa fa-camera"></i>
                                <input type="file" id="image_book" name="image_book" accept="image/*"
                                    onchange="handleFileSelect(event)" require>
                                <img id="preview" alt="Image Preview">
                            </div>
                            <div id="image-error" class="error"></div>
                        </div>
                        <div class="col">
                            <div>
                                <label for="bookTitle">ชื่อหนังสือ<span style="color: red;">*</span></label>
                                <input type="text" id="bookTitle" name="bookTitle" required>
                                <div id="bookTitle-error" class="error"></div>
                            </div>
                            <div>
                                <label for="file">อัพโหลดไฟล์หนังสือ:<span style="color: red;">*</span></label>
                                <input type="file" id="file_book" name="file_book" required>
                                <div id="file_book-error" class="error"></div>
                            </div>

                            <div class="flex-row">
                                <div>
                                    <label for="category">หมวดหมู่<span style="color: red;">*</span></label>
                                    <select name="category" id="category">
                                        @foreach ($setBooks as $setBook)
                                        <option value="{{ $setBook->id_setbook }}">{{ $setBook->nameSetBook }}</option>
                                        @endforeach
                                    </select>
                                    <div id="category-error" class="error"></div>
                                </div>
                                <div>
                                    <label for="price">ราคา<span style="color: red;">*</span></label>
                                    <input type="number" id="price" name="price" min="0" required>
                                    <div id="price-error" class="error"></div>
                                </div>
                            </div>

                            <div class="flex-row">
                                <div>
                                    <label for="numPages">จำนวนหน้า<span style="color: red;">*</span></label>
                                    <input type="number" id="numPages" name="numPages" min="0" required>
                                    <div id="numPages-error" class="error"></div>
                                </div>
                                <!-- <div>
                                    <label for="fileType">ประเภทไฟล์</label>
                                    <select id="fileType" name="fileType">
                                        <option value="">เลือกประเภทไฟล์</option>
                                        <option value="pdf">PDF</option>
                                    </select>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn" id="submit-button"
                            style="background-color: #CCECFF; color: #545454;">บันทึก</button>
                        <a href="{{ route('writer.showWorks', ['id_member' => Auth::user()->id_member]) }}" class="btn "
                            id="cancel-button"
                            style="background-color:#FFFFFF;color:#545454; border: 1px solid #545454; text-decoration: none; padding: 10px 20px; display: inline-block;">
                            ยกเลิก
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateForm = document.getElementById('update-form');
        const submitButton = document.getElementById('submit-button');

        submitButton.addEventListener('click', function() {
            let isValid = true;

            // Clear previous error messages
            document.querySelectorAll('.error').forEach(errorDiv => errorDiv.textContent = '');

            // Check required fields
            const fields = [{
                    id: 'bookTitle',
                    errorId: 'bookTitle-error',
                    message: 'กรุณากรอกชื่อหนังสือ'
                },
                {
                    id: 'file_book',
                    errorId: 'file_book-error',
                    message: 'กรุณาเลือกไฟล์หนังสือ'
                },
                {
                    id: 'category',
                    errorId: 'category-error',
                    message: 'กรุณาเลือกหมวดหมู่'
                },
                {
                    id: 'price',
                    errorId: 'price-error',
                    message: 'กรุณากรอกราคาหนังสือ'
                },
                {
                    id: 'image_book',
                    errorId: 'image-error',
                    message: 'กรุณาเพิ่มหน้าปกหนังสือ'
                },
                {
                    id: 'numPages',
                    errorId: 'numPages-error',
                    message: 'กรุณากรอกจำนวนหน้าหนังสือ'
                }
            ];

            fields.forEach(field => {
                const input = document.getElementById(field.id);
                const errorDiv = document.getElementById(field.errorId);

                if (!input.value.trim()) {
                    errorDiv.textContent = field.message;
                    isValid = false;
                }
            });

            const fileInput = document.getElementById('file_book');
            const file = fileInput.files[0];
            if (file) {
                if (file.type !== 'application/pdf') {
                    document.getElementById('file_book-error').textContent =
                        'กรุณาอัพโหลดไฟล์ PDF เท่านั้น';
                    isValid = false;
                } else {
                    // Clear the error message if the file is valid
                    document.getElementById('file_book-error').textContent = '';
                }
            }

            const existingTitles = @json($existingTitles);
            // ตรวจสอบชื่อหนังสือซ้ำ
            const bookTitle = document.getElementById('bookTitle').value.trim();
            if (existingTitles.includes(bookTitle)) {
                document.getElementById('bookTitle-error').textContent =
                    'ชื่อหนังสือซ้ำในระบบ กรุณากรอกชื่อใหม่';
                isValid = false;
            }

            // Check if there are any errors
            if (isValid) {
                if (confirm('ต้องการบันทึกการเปลี่ยนแปลงหรือไม่?')) {
                    alert('บันทึกสำเร็จ'); // แสดงข้อความเตือน
                    updateForm.submit(); // ส่งฟอร์ม
                } else {
                    event.preventDefault(); // หยุดการส่งฟอร์มถ้ายังไม่ผ่านการตรวจสอบ
                }
            }
        });
    });


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
</body>

</html>
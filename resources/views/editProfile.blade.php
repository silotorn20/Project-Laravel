<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel project</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
        margin-top: 10%;
        gap: 25px;
    }

    .form-actions .btn:first-child {
        margin-right: 2%;
    }

    body {
        font-family: 'Sarabun', sans-serif;
    }

    .navbar-nav {
        display: flex;
        align-items: center;
    }

    .nav-item {
        margin-right: 10px;
    }
    </style>
</head>

<body>
    @include('navHome')
    <nav class="navbar navbar-expand-lg">
        <ul class="navbar-nav" style="margin-left:5%">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="material-icons" style="color:#545454">home</i>
                </a>
            </li>
            <li class="nav-item">
                <span class="nav-separator"> &gt; </span>
            </li>
            <li class="nav-item">
                <span class="nav-link-current">แก้ไขโปรไฟล์</span>
            </li>
        </ul>
    </nav>
    <div class="container-center">
        <div class="form-container">
            <div class="form-content">
                <form id="update-form" action="{{ route('UpProfile', ['id_member' => $member->id_member]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col">
                            <div class="square" onclick="document.getElementById('profile').click();">
                                <i class="fas fa-camera" style="display: {{ $member->profile ? 'none' : 'block' }}"></i>
                                <input type="file" id="profile" name="profile" accept="image/*"
                                    onchange="handleFileSelect(event)">
                                <img id="preview"
                                    src="{{ $member->profile ? '../../public/profiles/' . $member->profile : '' }}"
                                    alt="Image Preview" style="display: {{ $member->profile ? 'block' : 'none' }}">
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <label style="color:#545454; "><strong>ชื่อ</strong></label>
                                <input type="text" class="form-control" id="Firstname" name="Firstname"
                                    value="{{old('Firstname',$member->Firstname) }}">
                            </div>
                            <div>
                                <label style="color:#545454; "><strong>สกุล</strong></label>
                                <input type="text" class="form-control" id="LastName" name="LastName"
                                    value="{{ old('LastName',$member->LastName) }}">
                            </div>
                            <div>
                                <label style="color:#545454;"><strong>อีเมล</strong></label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $member->email) }}">

                                @if($errors->has('email'))
                                <div class="text-danger">{{ $errors->first('email') }}</div> <!-- แสดงข้อผิดพลาด -->
                                @endif
                            </div>


                            <div>
                                <label style="color:#545454;"><strong>รหัสผ่าน</strong></label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="กรอกรหัสผ่านใหม่">
                                @if ($errors->has('password'))
                                <div class="text-danger">
                                    {{ "กรุณากรอกรหัสผ่านให้ครบ 8 ตัว" }}
                                </div>
                                @endif
                            </div>
                            <div>
                                <label style="color:#545454;"><strong>เบอร์โทร</strong></label>
                                <input type="text" class="form-control @error('Phone') is-invalid @enderror" id="Phone"
                                    name="Phone" value="{{ old('Phone', $member->Phone) }}">
                                <!-- ใช้ old() เพื่อคงค่าเบอร์โทรที่กรอกไว้ -->
                                @if ($errors->has('Phone'))
                                <div class="text-danger">
                                    {{ "กรุณากรอกเบอร์โทรให้ครบ 10 ตัว" }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn" type="submit"
                            style="background-color: #CCECFF; color: #545454; border: 1px solid #545454;">แก้ไขข้อมูล</button>
                        <a href="{{ route('profile', ['id_member' => Auth::user()->id_member]) }}" class="btn"
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
            // ตรวจสอบว่ามีช่องไหนถูกกรอกหรือไม่
            const formData = new FormData(updateForm);
            let isAnyFieldFilled = false;

            // Loop ผ่านข้อมูลฟอร์มเพื่อตรวจสอบว่ามีช่องไหนถูกกรอกบ้าง
            formData.forEach(function(value) {
                if (value.trim() !== "") {
                    isAnyFieldFilled = true;
                }
            });

            if (!isAnyFieldFilled) {
                alert('ไม่สามารแก้ไขโปรไฟล์ได้');
                event.preventDefault(); // หยุดการส่งฟอร์มถ้าไม่มีการกรอกข้อมูล
                return;
            }

            // ถ้ามีการกรอกข้อมูลแล้วให้ถามเพื่อยืนยันการส่งฟอร์ม
            if (confirm('ต้องการบันทึกการเปลี่ยนแปลงหรือไม่?')) {
                alert('แก้ไขข้อมูลเรียบร้อยแล้ว');
                this.submit(); // ทำการส่งฟอร์ม
            } else {
                event.preventDefault(); // หยุดการส่งฟอร์มถ้าผู้ใช้ไม่ยืนยัน
            }
        });
    });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateForm = document.getElementById('update-form');
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('email-error');

        // เก็บรหัสผ่านลงใน Local Storage เมื่อมีการกรอก
        document.getElementById('password').addEventListener('input', function() {
            localStorage.setItem('password', this.value);
        });

        // ตรวจสอบว่ามีรหัสผ่านที่เก็บไว้ใน Local Storage หรือไม่
        window.onload = function() {
            var storedPassword = localStorage.getItem('password');
            if (storedPassword) {
                document.getElementById('password').value = storedPassword;
            }
        };

        updateForm.addEventListener('submit', function(event) {
            const emailValue = emailInput.value.trim();
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const validDomains = emailValue.endsWith('@gmail.com') || emailValue.endsWith('@msu.ac.th');

            // ตรวจสอบรูปแบบอีเมลและว่าลงท้ายด้วย @gmail.com หรือ @msu.ac.th หรือไม่
            if (!emailPattern.test(emailValue) || !validDomains) {
                emailError.style.display = 'block'; // แสดงข้อความผิดพลาด
                event.preventDefault(); // หยุดการส่งฟอร์ม
                return;
            } else {
                emailError.style.display = 'none'; // ซ่อนข้อความผิดพลาด
            }

            // การตรวจสอบอื่นๆ และยืนยันการบันทึก
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

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AddMember</title>
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
        margin-top: 6%;
    }


    .square {
        width: 200px;
        height: 200px;
        /* Change height to make it a circle */
        background-color: #CCECFF;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border-radius: 50%;
        /* Make it circular */
        position: relative;
        overflow: hidden;
        margin-right: 6%;
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
        margin-top: 10%;
        gap: 25px;
    }


    .form-actions .btn:first-child {
        margin-right: 2%;
    }

    .error {
        color: red;
        font-size: 0.875em;
        margin-top: 5px;
    }

    body {
        font-family: 'Sarabun', sans-serif;
    }
    </style>
</head>

<body>
    @include('navadmin')
    <div class="container-center">
        <div class="form-container">
            <div class="form-content">
                <form id="registrationForm" action="{{route('addMember')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="square" onclick="document.getElementById('profile').click();">
                                <i class="fas fa-camera"></i>
                                <input type="file" id="profile" name="profile" accept="image/*"
                                    onchange="handleFileSelect(event)" required>
                                <img id="preview" src="#" alt="Image Preview">
                            </div>
                            <div id="profile-error" class="error"></div>
                        </div>
                        <div class="col">
                            <div>
                                <label style="color:#545454; font-size: 18px;"><strong>ชื่อ</strong><span
                                        style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="Firstname" name="Firstname" required>
                                <div id="firstname-error" class="error"></div>
                            </div>
                            <div>
                                <label style="color:#545454; font-size: 18px;"><strong>สกุล</strong><span
                                        style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="LastName" name="LastName" required>
                                <div id="lastname-error" class="error"></div>
                            </div>
                            <div>
                                <label style="color:#545454; font-size: 18px;"><strong>อีเมล</strong><span
                                        style="color: red;">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div id="email-error" class="error"></div>
                            </div>
                            <div>
                                <label style="color:#545454; font-size: 18px;"><strong>รหัสผ่าน</strong><span
                                        style="color: red;">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div id="password-error" class="error"></div>
                            </div>
                            <div>
                                <label style="color:#545454; font-size: 18px;"><strong>เบอร์โทร</strong><span
                                        style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="Phone" name="Phone" required>
                                <div id="phone-error" class="error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn" id="submitBtn"
                            style="background-color: #CCECFF; color: #545454; border: 1px solid #545454;">บันทึก</button>
                        <a href="{{ url('/show') }}" class="btn"
                            style="background-color:#FFFFFF;color:#545454; border: 1px solid #545454; text-decoration: none; padding: 10px 20px; display: inline-block;">
                            ยกเลิก
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    document.getElementById('submitBtn').onclick = function() {
        // รีเซ็ตข้อความแสดงข้อผิดพลาด
        document.getElementById('firstname-error').innerText = '';
        document.getElementById('lastname-error').innerText = '';
        document.getElementById('email-error').innerText = '';
        document.getElementById('password-error').innerText = '';
        document.getElementById('phone-error').innerText = '';
        document.getElementById('profile-error').innerText = '';

        // ดึงค่าจากฟอร์ม
        var Firstname = document.getElementById('Firstname').value;
        var LastName = document.getElementById('LastName').value;
        var email = document.getElementById('email').value.trim();
        var password = document.getElementById('password').value.trim();
        var Phone = document.getElementById('Phone').value;
        var profile = document.getElementById('profile').value;


        // ตรวจสอบความถูกต้องของฟอร์ม
        var isValid = true;

        // ตรวจสอบแต่ละฟิลด์
        if (!Firstname) {
            document.getElementById('firstname-error').innerText = 'กรุณากรอกชื่อ';
            isValid = false;
        }
        if (!LastName) {
            document.getElementById('lastname-error').innerText = 'กรุณากรอกนามสกุล';
            isValid = false;
        }
        if (!email) {
            document.getElementById('email-error').innerText = 'กรุณากรอกอีเมล';
            isValid = false;
        }
        if (!Phone) {
            document.getElementById('phone-error').innerText = 'กรุณากรอกเบอร์โทร';
            isValid = false;
        }
        if (!password) {
            document.getElementById('password-error').innerText = 'กรุณากรอกรหัสผ่านให้ครบ 8 ตัว';
            isValid = false;
        }
        if (!profile) {
            document.getElementById('profile-error').innerText = 'กรุณาเลือกภาพโปรไฟล์';
            isValid = false;
        }

        if (!password || password.length < 8) {
            document.getElementById('password-error').innerText = 'กรุณากรอกรหัสผ่านให้ครบ 8 ตัว';
            isValid = false;
        } else {
            // ตรวจสอบว่ารหัสผ่านมีเฉพาะตัวอักษรและตัวเลข
            var passwordPattern = /^[a-zA-Z0-9._]+$/; // อนุญาตให้ใช้เฉพาะตัวอักษรและตัวเลข
            if (!passwordPattern.test(password)) {
                document.getElementById('password-error').innerText =
                    'กรุณากรอกรหัสผ่านให้ถูกต้อง เฉพาะตัวอักษร ตัวเลขหรือสัญลักษ์ ._';
                isValid = false;
            }
        }

        // ตรวจสอบรูปแบบอีเมล
        const existingEmails = @json($existingEmails);
        var emailPattern = /^[a-zA-Z0-9._-]+@(gmail\.com|msu\.ac\.th)$/;
        if (!email) {
            document.getElementById('email-error').innerText = 'กรุณากรอกอีเมล';
            isValid = false;
        } else if (!emailPattern.test(email)) {
            document.getElementById('email-error').innerText = 'กรุณากรอกอีเมลให้ถูกต้อง';
            isValid = false;
        } else if (isValid && existingEmails.includes(email)) {
            document.getElementById('email-error').innerText = 'มีอีเมลในระบบแล้ว กรุณากรอกใหม่';
            isValid = false;
        } // ตรวจสอบอีเมลซ้ำ

        // ตรวจสอบเบอร์โทร
        if (!Phone) {
            document.getElementById('phone-error').innerText = 'กรุณากรอกเบอร์โทร';
            isValid = false;
        } else if (Phone.length !== 10) {
            document.getElementById('phone-error').innerText = 'เบอร์โทรต้องมีความยาว 10 หลัก';
            isValid = false;
        } else if (Phone[0] !== '0') {
            document.getElementById('phone-error').innerText = 'เบอร์โทรต้องขึ้นต้นด้วย 0';
            isValid = false;
        }

        // หยุดการส่งฟอร์มหากการตรวจสอบไม่ผ่าน
        if (!isValid) {
            return;
        }

        // แสดงข้อความความสำเร็จและเปลี่ยนหน้า
        if (confirm('ต้องการบันทึกการเปลี่ยนแปลงหรือไม่?')) {
            alert('เพิ่มข้อมูลสมาชิกสำเร็จ');
            document.getElementById('registrationForm').submit();
        } else {
            isValid = false;
        }
    };

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

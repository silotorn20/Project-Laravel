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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
    body {
        font-family: 'Sarabun', sans-serif;
    }

    .container {
        width: 100%;
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
                    <i class="material-icons">home</i>
                </a>
            </li>
            <li class="nav-item">
                <span class="nav-separator"><i class="material-icons">chevron_right</i></span>
            </li>
            <li class="nav-item">
                <span class="nav-link-current">ลงทะเบียนนักเขียน</span>
            </li>
        </ul>
    </nav>
    <div class="container">
        <div style="margin-top:20px;text-align: center;">
            <h1 class="card-title" style="color:#004AAD">ลงทะเบียนนักเขียน</h1>
        </div>
        <div class="row justify-content-center" style="margin:10px;">

            <div class="card mb-3" style="width: 100%; margin-top:150px; background-color:#FCFEFF">
                <form id="registrationForm" action="{{ route('updateWriter', ['id_member' => $member->id_member]) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group row " style="margin:10px; margin-right:10px">
                        <label class="col-sm-2 col-form-label" style="color:#545454; ">ชื่อ<span
                                style="color: red;">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Firstname" name="Firstname"
                                value="{{ $member->Firstname }}" required>
                            <div id="FirstnameError" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group row " style="margin:10px; margin-right:10px">
                        <label class="col-sm-2 col-form-label" style="color:#545454;">นามสกุล<span
                                style="color: red;">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="LastName" name="LastName"
                                value="{{ $member->LastName }}" required>
                            <div id="LastNameError" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group row " style="margin:10px; margin-right:10px">
                        <label class="col-sm-2 col-form-label" style="color:#545454; ">อีเมล<span
                                style="color: red;">*</span></label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $member->email }}" required>
                            <div id="emailError" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="form-group row " style="margin:10px; margin-right:10px">
                        <label class="col-sm-2 col-form-label" style="color:#545454; ">เบอร์โทร<span
                                style="color: red;">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Phone" name="Phone" value="{{ $member->Phone }}"
                                required>
                            <div id="PhoneError" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3 d-flex justify-content-end">
                            <div style="margin-right: 10px;">
                                <button type="button" class="btn" id="submitBtn"
                                    style="background-color:#CCECFF;color:#545454;">บันทึก</button>

                            </div>
                            <div>

                                <a href="{{ url('/home') }}" class="btn"
                                    style="background-color:#FFFFFF;color:#545454;  border: 1px solid #545454;">
                                    ยกเลิก
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <script>
                // เพิ่มอีเวนต์ให้กับปุ่มส่งฟอร์ม
                document.getElementById('submitBtn').onclick = function() {
                    // รีเซ็ตข้อความแสดงข้อผิดพลาด
                    document.getElementById('FirstnameError').innerText = '';
                    document.getElementById('LastNameError').innerText = '';
                    document.getElementById('emailError').innerText = '';
                    document.getElementById('PhoneError').innerText = '';

                    // ดึงค่าจากฟอร์ม
                    var Firstname = document.getElementById('Firstname').value;
                    var LastName = document.getElementById('LastName').value;
                    var email = document.getElementById('email').value.trim();
                    var Phone = document.getElementById('Phone').value;

                    if (!Firstname && !LastName && !email && !Phone) {
                        alert('ไม่สามารถลงทะเบียนได้');
                        return;
                    }

                    // ตรวจสอบความถูกต้องของฟอร์ม
                    var isValid = true;

                    // ตรวจสอบแต่ละฟิลด์
                    if (!Firstname) {
                        document.getElementById('FirstnameError').innerText = 'กรุณากรอกชื่อ';
                        isValid = false;
                    }
                    if (!LastName) {
                        document.getElementById('LastNameError').innerText = 'กรุณากรอกนามสกุล';
                        isValid = false;
                    }
                    if (!email) {
                        document.getElementById('emailError').innerText = 'กรุณากรอกอีเมล';
                        isValid = false;
                    }
                    if (!Phone) {
                        document.getElementById('PhoneError').innerText = 'กรุณากรอกเบอร์โทร';
                        isValid = false;
                    }

                    // ตรวจสอบรูปแบบอีเมล
                    var emailPattern = /^[a-zA-Z0-9._-]+@(gmail\.com|msu\.ac\.th)$/;
                    if (!email) {
                        document.getElementById('emailError').innerText = 'กรุณากรอกอีเมล';
                        isValid = false;
                    } else if (!emailPattern.test(email)) {
                        document.getElementById('emailError').innerText = 'กรุณากรอกอีเมลให้ถูกต้อง';
                        isValid = false;
                    }

                    // ตรวจสอบเบอร์โทร
                    if (!Phone) {
                        document.getElementById('PhoneError').innerText = 'กรุณากรอกเบอร์โทร';
                        isValid = false;
                    } else if (Phone.length !== 10) {
                        document.getElementById('PhoneError').innerText = 'เบอร์โทรต้องมีความยาว 10 หลัก';
                        isValid = false;
                    } else if (Phone[0] !== '0') {
                        document.getElementById('PhoneError').innerText = 'เบอร์โทรต้องขึ้นต้นด้วย 0';
                        isValid = false;
                    }

                    // หยุดการส่งฟอร์มหากการตรวจสอบไม่ผ่าน
                    if (!isValid) {
                        return;
                    }

                    // แสดงข้อความความสำเร็จและเปลี่ยนหน้า
                    if (confirm('ต้องการลงทะเบียนนักเขียนหรือไม่?')) {
                        alert('ลงทะเบียนเรียบร้อยแล้ว');
                        document.getElementById('registrationForm').submit();
                    } else {
                        alert('การบันทึกถูกยกเลิก');
                    }
                };
                </script>
            </div>
        </div>
    </div>
</body>

</html>
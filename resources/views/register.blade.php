<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <style>
    body {
        font-family: 'Sarabun', sans-serif;
    }

    .text-danger {
        color: red;
        /* สีแดงสำหรับข้อความแสดงข้อผิดพลาด */
        font-weight: normal;
        /* ทำให้ข้อความไม่หนา */
    }
    </style>
</head>

<body>
    <div class="row justify-content-center mt-5" style="width: 100%;">
        <div class="card mb-3" style="max-width: 900px; margin:150px; background-color:#FCFEFF">
            <div class="row g-0">
                <div class="col-md-4" style=" margin-top:80px;">
                    <img src="{{ asset('storage/image/register.png') }}" class="img-fluid rounded-start">
                </div>
                <div class="col-md-8">
                    <div class="center-text">
                        <h1 class="card-title" style="color:#004AAD">สมัครสมาชิก</h1>
                    </div>
                    <div class="card-body">

                        <form id="registrationForm" action="{{route('register')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="Firstname" class="form-label" style="color:#545454"><b>ชื่อผู้ใช้</b><span
                                        style="color: red;">*</span></label>
                                <input type="text" name="Firstname" class="form-control" id="Firstname"
                                    placeholder="ชื่อผู้ใช้" required>
                                <div id="FirstnameError" class="text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="LastName" class="form-label" style="color:#545454"><b>นามสกุล</b><span
                                        style="color: red;">*</span></label>
                                <input type="text" name="LastName" class="form-control" id="LastName"
                                    placeholder="นามสกุล" required>
                                <div id="LastNameError" class="text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label" style="color:#545454"><b>อีเมล<b><span
                                                style="color: red;">*</span></label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="อีเมล"
                                    required>
                                <div id="emailError" class="text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label" style="color:#545454"><b>รหัสผ่าน</b><span
                                        style="color: red;">*</span></label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="รหัสผ่าน" required>
                                <div id="passwordError" class="text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <div class="d-grid">
                                    <button type="submit" class="btn" style="background-color:#CCECFF;color:#545454;"
                                        onclick="return validateForm()">สมัครสมาชิก</button>
                                </div>
                            </div>
                        </form>
                        <script>
                        function validateForm() {
                            // รีเซ็ตข้อความแสดงข้อผิดพลาด
                            document.getElementById('FirstnameError').innerText = '';
                            document.getElementById('LastNameError').innerText = '';
                            document.getElementById('emailError').innerText = '';
                            document.getElementById('passwordError').innerText = '';

                            // ดึงค่าจากฟอร์ม
                            var Firstname = document.getElementById('Firstname').value;
                            var LastName = document.getElementById('LastName').value;
                            var email = document.getElementById('email').value.trim();
                            var password = document.getElementById('password').value.trim();

                            // ตรวจสอบความถูกต้องของฟอร์ม
                            var isValid = true;

                            // ตรวจสอบแต่ละฟิลด์
                            if (!Firstname) {
                                document.getElementById('FirstnameError').innerText = 'กรุณากรอกชื่อผู้ใช้';
                                isValid = false;
                            }
                            if (!LastName) {
                                document.getElementById('LastNameError').innerText = 'กรุณากรอกนามสกุล';
                                isValid = false;
                            }
                            if (!email) {
                                document.getElementById('emailError').innerText = 'กรุณากรอกอีเมล'; // ไม่เป็นตัวหนา
                                isValid = false;
                            }
                            // ตรวจสอบรูปแบบอีเมล
                            const existingEmails = @json($existingEmails);
                            var emailPattern = /^[a-zA-Z0-9._-]+@(gmail\.com|msu\.ac\.th)$/;
                            if (!email) {
                                document.getElementById('emailError').innerText = 'กรุณากรอกอีเมล';
                                isValid = false;
                            } else if (!emailPattern.test(email)) {
                                document.getElementById('emailError').innerText = 'กรุณากรอกอีเมลให้ถูกต้อง';
                                isValid = false;
                            } else if (isValid && existingEmails.includes(email)) {
                                document.getElementById('emailError').innerText = 'มีอีเมลในระบบแล้ว กรุณากรอกใหม่';
                                isValid = false;
                            } // ตรวจสอบอีเมลซ้ำ

                            // ตรวจสอบรหัสผ่าน
                            if (!password || password.length < 8) {
                                document.getElementById('passwordError').innerText =
                                    'กรุณากรอกรหัสผ่านให้ครบ 8 ตัว'; // ไม่เป็นตัวหนา
                                isValid = false;
                            } else {
                                // ตรวจสอบว่ารหัสผ่านมีเฉพาะตัวอักษรและตัวเลข
                                var passwordPattern = /^[a-zA-Z0-9._]+$/; // อนุญาตให้ใช้เฉพาะตัวอักษรและตัวเลข
                                if (!passwordPattern.test(password)) {
                                    document.getElementById('passwordError').innerText =
                                        'กรุณากรอกรหัสผ่านให้ถูกต้อง เฉพาะตัวอักษร ตัวเลขหรือสัญลักษ์ ._';
                                    isValid = false;
                                }
                            }

                            // หยุดการส่งฟอร์มหากการตรวจสอบไม่ผ่าน
                            if (!isValid) {
                                return false;
                            }

                            // แสดงข้อความความสำเร็จและเปลี่ยนหน้า
                            if (confirm('ต้องการบันทึกการเปลี่ยนแปลงหรือไม่?')) {
                                alert('สมัครสมาชิกสำเร็จ');
                                setTimeout(function() {
                                    window.location.href = "{{ route('login') }}";
                                }, 1000); // Delay to allow alert message to be shown
                            } else {
                                alert('การบันทึกถูกยกเลิก');
                                return false;
                            }

                            // ส่งฟอร์ม
                            return true;
                        }
                        </script>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AddSetBook</title>
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
    <script>
    function handleFormSubmit(event) {
        event.preventDefault(); // ป้องกันการส่งฟอร์ม

        const form = event.target;
        const formData = new FormData(form);
        const errorMessageDiv = document.getElementById('error-message');

        // ส่งข้อมูลฟอร์มไปยังเซิร์ฟเวอร์
        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json()) // แปลงการตอบกลับเป็น JSON
            .then(data => {
                errorMessageDiv.style.display = 'none';
                if (data.success) {
                    const confirmMessage = 'ข้อมูลถูกบันทึกแล้ว! คุณต้องการเพิ่มหมวดหมู่ใหม่หรือไม่?';
                    if (confirm(confirmMessage)) {
                        form.reset(); // รีเซ็ตฟอร์มเพื่อกรอกข้อมูลใหม่
                        document.getElementById('nameSetBook').focus();
                    } else { // แสดงข้อความเมื่อเลือก "ยกเลิก"
                        window.location.href = '{{ url("/setBook") }}'; // เปลี่ยนหน้าไปยังหน้าแสดงผล
                    }
                } else {
                    errorMessageDiv.textContent = data.message; // แสดงข้อความข้อผิดพลาดจากเซิร์ฟเวอร์
                    errorMessageDiv.style.display = 'block';
                }
            })
            .catch(error => console.error('Error:', error));
    }
    </script>
    <style>
    body {
        font-family: 'Sarabun', sans-serif;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div>
                <h3><a href="{{ url('/setBook') }}" class="btn btn-success mb-3">กลับไปหน้าแรก</a></h3>
            </div>
            <div class="card mb-3" style="max-width: 900px; margin:150px; background-color:#FCFEFF">
                <div style=" margin-top:20px;  text-align: center;">
                    <h1 class="card-title" style="color:#004AAD">เพิ่มหมวดหมู่หนังสือ</h1>
                </div>
                <form action="{{route('addSetBook')}}" method="POST" onsubmit="handleFormSubmit(event)">
                    @csrf
                    <div class="mb-3">
                        <label for="nameSetBook" class="form-label"
                            style="color:#545454 font-size: 18px;"><strong>ชื่อหมวดหมู่หนังสือ</strong></label>
                        <input type="text" name="nameSetBook" class="form-control" id="nameSetBook"
                            placeholder="ชื่อหมวดหมู่" required>
                            <div id="error-message" class="text-danger" style="display:none;"></div>
                    </div>
                    <div class="mb-3">
                        <div class="d-grid">
                            <button class="btn" style="background-color:#CCECFF;color:#545454;">บันทึก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

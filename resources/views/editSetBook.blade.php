<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EditSetBook</title>
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
                    <h1 class="card-title" style="color:#004AAD">แก้ไขหมวดหมู่หนังสือ</h1>
                </div>
                <form id='update-form' action="{{route('editSetBook', $setBook->id_setbook)}}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="nameSetBook" class="form-label"
                            style="color:#545454;font-size: 18px;"><strong>ชื่อหมวดหมู่หนังสือ</strong></label>
                        <input type="text" name="nameSetBook" class="form-control" id="nameSetBook"
                            value="{{ $setBook->nameSetBook }}" placeholder="ชื่อหมวดหมู่" required>
                        @if(session('error'))
                        <div class="text-danger">
                            {{ session('error') }}
                        </div>
                        @endif 
                    </div>
                    <div class="mb-3">
                        <div class="d-grid">
                            <button type="submit" class="btn"
                                style="background-color:#CCECFF;color:#545454;">บันทึก</button>
                        </div>
                    </div>
                </form>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const updateForm = document.getElementById('update-form');

                    updateForm.addEventListener('submit', function(event) {
                        if (confirm('ต้องการบันทึกการเปลี่ยนแปลงหรือไม่?')) {
                            // ถ้าผู้ใช้ยืนยัน
                            this.submit(); // ทำการส่งฟอร์ม
                        } else {
                            event.preventDefault(); // หยุดการส่งฟอร์มถ้าผู้ใช้ไม่ยืนยัน
                        }
                    });
                });

                document.addEventListener('DOMContentLoaded', function() {
                    @if(session('success'))
                    alert('แก้ไขข้อมูลเรียบร้อยแล้ว');
                    window.location.href = '{{ route("setBook") }}';
                    @endif
                });
                </script>
            </div>
        </div>
    </div>
</body>

</html>

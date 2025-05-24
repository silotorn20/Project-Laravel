<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    body {
        font-family: 'Sarabun', sans-serif;
    }
    </style>
      <script>
        window.onload = function() {
            document.getElementById('login').focus();
        };
    </script>
</head>

<body>
    <div class="row justify-content-center mt-5" style="width: 100%;">
        <div class="card mb-3" style="max-width: 900px; margin:150px; background-color:#FCFEFF">
            <div class="row g-0">
                <div class="col-md-4">
                   <img src="{{ asset('storage/image/login.png') }}" class="img-fluid rounded-start">
                </div>
                <div class="col-md-8">
                    <div class="center-text">
                        <h1 class="card-title" style="color:#004AAD">เข้าสู่ระบบ</h1>
                    </div>

                    <div class="card-body">
                        @if(Session::has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('error') }}
                        </div>
                        @endif
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                        @endif

                        <form action="{{route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="login" class="form-label"
                                    style="color:#545454"><strong>อีเมลหรือชื่อผู้ใช้</strong></label>
                                <input type="text" name="login" class="form-control" id="login"
                                    placeholder="อีเมลหรือชื่อผู้ใช้">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label"
                                    style="color:#545454"><strong>รหัสผ่าน</strong></label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="รหัสผ่าน">
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="#">ลืมรหัสผ่าน</a>
                                    </div>
                                    <div>
                                        <button class="btn" type="submit"
                                            style="background-color:#CCECFF;color:#545454;">เข้าสู่ระบบ</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12">
                            <div class="mb-3 d-flex justify-content-center align-items-center">
                                <div class="text-center" style="margin-top: 20px;">
                                    <a href="{{ route('google.redirect') }}">
                                        <button class="btn"
                                            style="background-color:#FFFFFF; color:#545454; border: 1px solid #545454; width: 100%;">
                                            <img src="https://www.gstatic.com/images/branding/product/1x/gsa_64dp.png"
                                                alt="Google icon" style="width:20px;height:20px; margin-right:8px;">
                                            เข้าสู่ระบบด้วย Google
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3 d-flex justify-content-center align-items-center">
                                <div style="margin-right: 10px;">
                                    <label class="form-label" style="color:#737373;">ยังไม่มีบัญชีผู้ใช้</label>
                                    <a href="{{url('/register')}}">สมัครสมาชิก</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>

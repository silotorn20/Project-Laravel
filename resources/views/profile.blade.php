<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    label {
        font-family: 'Sarabun', sans-serif;
        font-size: 22px;
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


    .square {
        width: 400px;
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

    .container-center {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .form-container {
        display: flex;
        margin-top: 10%;
    }

    .form-content {
        display: flex;
        flex-direction: column;
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
                    <i class="material-icons" style="color:#545454">home</i>
                </a>
            </li>
            <li class="nav-item">
                <span class="nav-separator"><i class="material-icons">chevron_right</i></span>
            </li>
            <li class="nav-item">
                <span class="nav-link-current">โปรไฟล์</span>
            </li>
        </ul>
    </nav>
    <div class="container">
        <div class="form-container" style="margin-left:20%">
            <div class="square">
                <img src="{{ $member->profile ? '../../public/profiles/' . $member->profile : asset('public/profiles/default-profile.png') }}" alt="Image"
                    style="width: 500px; height: 300px;">
            </div>
            <div class="form-content">
                <div class="form-group row">
                    <label class="col-sm-3 " style="font-weight: bold;">ชื่อ-สกุล</label>
                </div>
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-6">
                        <label>{{ $member->Firstname }}&nbsp;&nbsp;{{ $member->LastName }}</label>
                    </div>
                    <div class="col-sm-5 d-flex align-items-center">
                        <span>
                            <button type="button" onclick="navigateToEditProfile()"
                                class="btn btn-outline-primary ml-3d-inline-flex align-items-center">
                                แก้ไข
                        </span>
                        <i class="material-icons ml-1" style="vertical-align: middle;">edit</i>
                        </button>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3" style="font-weight: bold;">อีเมล</label>
                </div>
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-6">
                        <label>{{ $member->email }}</label>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3" style="font-weight: bold;">เบอร์โทร</label>
                </div>
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-6">
                        <label>{{ $member->Phone }}</label>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
    function navigateToEditProfile() {
        window.location.href = href = "{{ url('/editProfile/' . Auth::guard('member')->user()->id_member) }}";
    }
    </script>
</body>

</html>

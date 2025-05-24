<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ShowMember</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <style>
    .material-symbols-outlined {
        font-variation-settings:
            'FILL'0,
            'wght'400,
            'GRAD'0,
            'opsz'24
    }

    .img {
        width: 100px;
        height: 100px;
        /* Change height to make it a circle */
        background-color: #CCECFF;
        display: flex;
        align-items: start;
        justify-content: start;
        cursor: pointer;
        border-radius: 50%;
        /* Make it circular */
        position: relative;
        overflow: hidden;
        margin-left: 0;
    }

    body {
        font-family: 'Sarabun', sans-serif;
    }

    .number {
        margin-left: 6%;
        display: flex;
        height: 100%;
    }

    .table-container {
        max-height: 520px;
        overflow-y: auto;
        position: sticky
    }

    thead th {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        background-color: #c0e0f4;
        z-index: 10;
    }
    </style>
</head>

<body>
    @include('navadmin')
    <div class="container">
        <div class="text-center mb-4" style="margin-top:2%">
            <h2>ข้อมูลสมาชิก</h2>
        </div>
        <div class="d-flex justify-content-end">
            <h3><a href="{{ url('/addMember') }}" class="btn btn-success mb-3">เพิ่มข้อมูลสมาชิก</a></h3>
        </div>
        <script>
            // ตรวจสอบการค้นหา
            @if(request()->input('query') && $members->isEmpty())
            alert('ไม่พบข้อมูลที่ค้นหา');
            @endif
        </script>
        <div class="table-container">
            <table class="table">
                <thead class="table-primary">
                    <tr>
                        <th class="text-start">ลำดับ</th>
                        <th class="text-start">โปรไฟล์</th>
                        <th class="text-start">ชื่อ-สกุล</th>
                        <th class="text-start">อีเมล</th>
                        <th class="text-center">เบอร์โทร</th>
                        <th class="text-start"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members->isEmpty() ? $allMembers : $members as $key => $member)
                    <tr>
                        <td>
                            <div class="number">{{ $key + 1 + ($members->currentPage() - 1) * $members->perPage() }}
                            </div>
                        </td>
                        <td class="text-start"><img class="img"
                                src="{{ $member->profile ? '../../public/profiles/' . $member->profile : '' }}" alt="">
                        </td>
                        <td class="text-start">{{ $member->Firstname }} {{ $member->LastName }}</td>
                        <td class="text-start">{{ $member->email }}</td>
                        <td class="text-center">{{ $member->Phone }}</td>
                        <td>
                            <form action="{{route('deleteMember',$member->id_member)}}" method="POST">
                                <a href="{{ route('editmember', ['id_member' => $member->id_member]) }}"
                                title="แก้ไข"><img
                                        src="{{ '../../public/storage/image/edit.png' }}" alt="" width="20px"></a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('ต้องการลบหรือไม่?')"
                                    style="background: none; border: none; padding: 0;margin-left:5%" title="ลบ">
                                    <img src="{{ '../../public/storage/image/delete.png' }}" alt="" width="20px">
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ ($members->isEmpty() && request()->input('query') ? $allMembers : $members)->links('pagination::bootstrap-4') }}
        </div>
    </div>
</body>

</html>

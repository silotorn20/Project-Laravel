<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SetBook</title>
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
    .material-icons {
        vertical-align: -14%
    }

    .material-symbols-outlined {
        font-variation-settings:
            'FILL'0,
            'wght'400,
            'GRAD'0,
            'opsz'24
    }

    table {
        width: 100%;
        table-layout: fixed;
        /* Ensures table takes full width */
    }

    body {
        font-family: 'Sarabun', sans-serif;
    }

    .number {
        margin-left: 6%;
        display: flex;
        height: 100%;
    }
    </style>
</head>

<body>
    @include('navadmin')
    <div class="container">
        <div class="text-center mb-4" style="margin-top:2%">
            <h2>หมวดหมู่หนังสือ</h2>
        </div>

        <div class="d-flex justify-content-end">
            <h3><a href="{{ url('/addSetBook') }}" class="btn btn-success mb-3">เพิ่มหมวดหมู่หนังสือ</a></h3>
        </div>
        <table class="table">
            <thead class="table-primary">
                <tr>
                    <th class="text-start" scope="col">ลำดับที่</th>
                    <th class="text-start" scope="col">ชื่อ</th>
                    <th class="text-start" scope="col">จัดการข้อมูล</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($setBooks as $key => $setBook)
                <tr>
                    <td><div class="number">{{ $key + 1 }}</div></td>
                    <td class="text-start">{{ $setBook->nameSetBook }}</td>
                    <td>
                    <form action="{{route('deleteSetBook',$setBook->id_setbook)}}" method="POST">
                            <a href="{{ url('editSetBook', $setBook->id_setbook) }}" class="btn" title="แก้ไข"><img
                                    src="{{ '../../public/storage/image/edit.png' }}" alt="" width="20px"></a>
                            @csrf
                            @method('delete')
                            <button type="submit" onclick="return confirm('ต้องการลบหรือไม่?')"
                                class="btn " title="ลบ"> <img src="{{ '../../public/storage/image/delete.png' }}" alt="" width="20px"></button>
                        </form>
                        <!-- <a href=""><span class="material-symbols-outlined">delete</span></a> -->
                        <!-- <a href="{{ url('editSetBook', $setBook->id) }}"><span
                                class="material-symbols-outlined">edit_note</span></a> -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>

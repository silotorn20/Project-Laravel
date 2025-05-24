<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
        vertical-align: -14%;
    }

    h1 {
        text-align: center;
        background-color: #EBF8FD;
        padding: 20px;
        border-radius: 10px;
    }

    table {
        margin: auto;
        width: 80%;
    }

    .table {
        margin-top: 10px;
    }

    .thead-dark th {
        background-color: #343a40;
        color: #fff;
    }
    </style>
</head>

<body>
    @include('navHome')
    <h1>รายการคำสั่งซื้อ</h1>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col" class="text-center" >รายการคำสั่งซื้อ</th>
                <th scope="col" class="text-center" >ชื่อสมาชิก</th>
                <th scope="col" class="text-center" >ชื่อหนังสือ</th>
                <th scope="col" class="text-center" >วันที่ทำรายการ</th>
                <th scope="col" class="text-center" >ราคารวม</th>
                <th scope="col" class="text-center" >สถานะ</th>
            </tr>
        </thead>
        <tbody>
            @php
            $count = 1;
            @endphp
            @foreach($books as $order)
            <tr>
                <td class="text-center" >{{ $count }}</td>
                <td>{{ $order->Firstname }}</td>
                <td>{{ $order->name_book }}</td>
                <td>{{ $order->date }}</td>
                <td>{{ $order->total_price }}</td>
                <td>
                    <form action="{{ route('update.status', ['idbuy_book' => $order->idbuy_book]) }}" method="POST">
                        @csrf
                        @method('POST')
                        <select class="form-control" name="status" onchange="this.form.submit()">
                            <option value="1" {{ $order->status == '1' ? 'selected' : '' }}>1-ยังไม่ชำระเงิน</option>
                            <option value="2" {{ $order->status == '2' ? 'selected' : '' }}>2-ชำระเงินแล้ว</option>
                            <option value="3" {{ $order->status == '3' ? 'selected' : '' }}>3-อนุมัติการอ่าน</option>
                        </select>
                    </form>
                </td>
            </tr>
            @php
                $count++; 
            @endphp
            @endforeach
        </tbody>
    </table>
</body>

</html>
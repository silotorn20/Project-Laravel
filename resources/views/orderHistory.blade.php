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
        body {
        font-family: 'Sarabun', sans-serif;
    }
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
        margin-top: 20px;
    }

    .thead-dark th {
        background-color: #343a40;
        color: #fff;
    }
    </style>
</head>

<body>
    @include('navHome')
    <h1>ประวัติการสั่งซื้อ</h1>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">รายการคำสั่งซื้อ</th>
                <th scope="col">วันที่ทำรายการ</th>
                <th scope="col">จำนวน</th>
                <th scope="col">ยอดชำระ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $order)
            <tr>
                <td>{{ $order->name_book }}</td>
                <td>{{ $order->date }}</td>
                <td>1</td>
                <td>{{ $order->total_price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

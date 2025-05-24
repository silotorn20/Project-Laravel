<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Alert -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        h1 {
            text-align: center;
            background-color: #EBF8FD;
            padding: 20px;
            border-radius: 10px;
        }

        .form-group label {
            margin-top: 20%;
        }

        .card {
            margin-top: 20px;
        }
    </style>
    <script>
        // JavaScript สำหรับตรวจสอบการเลือกวิธีชำระเงิน
        function validatePaymentMethod() {
            var cashMethod = document.querySelector("select[name='cashmethod']").value;
            if (cashMethod === "") {
                alert("กรุณาเลือกวิธีการชำระเงิน");
                return false; // หยุดการส่งฟอร์มถ้าไม่มีการเลือก
            }
             // ถ้าเลือกวิธีชำระเงินแล้ว แสดง Alert ชำระเงินเสร็จเรียบร้อย
            alert("ชำระเงินเสร็จเรียบร้อยแล้ว");
            return true; // อนุญาตให้ส่งฟอร์ม
        }
    </script>
</head>

<body>
    @include('navHome')

    <h1>ชำระเงิน</h1>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <form method="POST" action="{{ route('checkpayment.add', $member->id_member) }}" onsubmit="return validatePaymentMethod()">
                    @csrf
                    <div class="form-group row">
                        <label for="cashmethod" style="font-weight: bold;">เลือกวิธีชำระเงิน</label>
                        <select class="form-control" name="cashmethod" required>
                            <option value="">วิธีชำระเงิน</option>
                            <option value="พร้อมเพย์">พร้อมเพย์</option>
                        </select>
                    </div>
    
                </form>
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-3">
                <div class="card" style="width: 30rem; margin-top: 20%">
                    <div class="card-body">
                        @foreach($showpayment as $index => $payment)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>{{ $index + 1 }}. {{ $payment->name_book }}</span>
                            <span>{{ $payment->price }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-7"></div>
            <div class="col-sm-3">
                <div class="card" style="width: 20rem;">
                    <div class="card-body">
                        
                        <h5 class="card-title">
                            ยอดชำระ: {{ $totalPrice }}
                        </h5>
                        <form action="{{ route('checkpayment.add', $member->id_member) }}" method="POST" onsubmit="return validatePaymentMethod()">
                            @csrf
                            <button type="submit" class="btn btn-primary">ยืนยันการชำระเงิน</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

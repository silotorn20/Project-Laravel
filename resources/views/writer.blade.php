<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.5.1/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.5.1/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.5.1/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    .circle-frame {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        overflow: hidden;
        j
    }

    .circle-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .icon-button {
        font-size: 100%;
        cursor: pointer;
        transition: transform 0.1s;
    }

    .text1 {
        position: absolute;
        bottom: 55%;
        margin-left: 10%;
        font-size: 120%;
        width: 100%;
    }

    .text2 {
        position: absolute;
        bottom: 30%;
        margin-left: 10%;
        font-size: 120%;
        width: 100%;
    }

    .text3 {
        position: absolute;
        bottom: 30%;
        margin-left: 62%;
        font-size: 20px;
    }

    .text4 {
        position: absolute;
        bottom: 30%;
        margin-left: 75%;
        font-size: 20px;
    }

    .text5 {
        position: absolute;
        bottom: 30%;
        margin-left: 85%;
        font-size: 20px;
    }

    .scrollable-frame {
        display: flex;
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
        padding-bottom: 20px;
    }

    .scrollable-frame a {
        margin-right: 4%;
    }

    #content-section>div {
        display: none;
    }

    .work {
        margin-bottom: 20px;
        display: flex;
    }

    .work-frame {
        background-color: #fff;
        border: 1px solid #545454;
        border-radius: 4px;
        padding: 10px;
        text-align: center;
        width: fit-content;
    }

    .work-title {
        color: #545454;
        font-size: 16px;
        margin-right: 30px;
        display: flex;
        align-items: center;
    }

    .work-views {
        color: #004AAD;
        font-size: 16px;
        font-weight: bold;
    }

    .icons {
        color: #1877f2;
        font-size: 16px;
        line-height: 0;
        margin-right: 5px;
        display: inline-block;
    }

    .breadcrumb-icon {
        --iconSize: 16px;
        --fillColor: var(--systemGrays03LabelTertiary);
    }

    .breadcrumb-icon svg {
        width: var(--iconSize);
        height: var(--iconSize);
        fill: var(--fillColor);
    }

    .table {
        width: 100%;
        margin-bottom: 1rem;
    }

    .table th,
    .table td {
        padding: 1rem;
        vertical-align: middle;
        width: 1%;
    }

    .navbar-nav {
        display: flex;
        align-items: center;
    }

    .nav-item {
        margin-right: 10px;
    }
    </style>

    <script>
    function navigateToNewPage() {
        window.location.href = href = "{{ url('/addbook') }}"; // ระบุ URL ของหน้าใหม่ที่ต้องการจะไป
    }
    </script>
</head>

<body>
    @include('navHome')
    <nav class="navbar navbar-expand-lg">
        <ul class="navbar-nav" style="margin-left:5%">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="material-icons">home</i>
                </a>
            </li>
            <li class="nav-item">
                <span class="nav-separator"><i class="material-icons">chevron_right</i></span>
            </li>
            <li class="nav-item">
                <span class="nav-link-current">หน้านักเขียน</span>
            </li>
        </ul>
    </nav>
    <div class="container">
        <div style=" margin-top:2%;">
            <h3>หน้านักเขียน</h3>
        </div>
        <div class="card mb-12" style="background-color:#e3f2fd; width: 100% ">
            <div class="circle-frame" style="margin: 2%;">
                <img src="{{ '../../public/profiles/' . $member->profile  }}" alt="Your Image">
                <div class="text1">
                    <span>{{ $member->Firstname }}</span>
                </div>
                <div class="text2">
                    @<span>{{ $member->Firstname }}</span>
                </div>
                <div class="text3">
                    <span style="display: block; text-align: center;">เรื่องที่แต่ง</span>
                    <span style="display: block; text-align: center;">{{ $bookCount }}</span>
                </div>
                <div class="text4">
                    <span style="display: block; text-align: center;">ผู้ติดตาม</span>
                    <span style="display: block; text-align: center;">{{ $followersCount }}</span>
                </div>
                <div class="text5">
                    <span style="display: block; text-align: center;">กำลังติดตาม</span>
                    <span style="display: block; text-align: center;">{{  $followingCount }}</span>
                </div>
            </div>
        </div>
        <div style="margin:1%; margin-left:87%;">
            <button class="btn" style="background-color:#28a745;color:white;" onclick="navigateToNewPage()">
                <i class="fas fa-plus icon-button"> <span>เพิ่มผลงาน</span></i></button>
        </div>
        <div style="display: flex;" class="scrollable-frame">
            <a href="#" id="portfolio-link">
                <h5>ผลงานทั้งหมด</h5>
            </a>
            <a href="#" id="sales-link">
                <h5>ยอดขายทั้งหมด</h5>
            </a>
        </div>
        <div id="content-section">
            <div id="portfolio-content" style="display: none;">
                <!-- เนื้อหาที่เกี่ยวข้องกับ "ผลงานทั้งหมด" -->
                <div class="work">
                    <div class="work-frame">
                        <div style=" display: flex; align-items: center;">
                            <span class="work-title"><i class="fi fi-sr-eye icons"></i>ยอดวิวรวม</span>
                            <span class="work-views">{{$totalViews}}</span>
                        </div>
                    </div>
                    <div class="work-frame" style="margin-left: 30px;">
                        <div style=" display: flex;">
                            <span class="work-title" style="margin-left: 10px;">รีวิว</span>
                            <span class="work-views" style="margin-left: 30px;">{{$reviewCount}}</span>
                        </div>
                        <div style="color: #ffc30f; font-size: 12px; display: flex; align-items: flex-start;">
                            <i class="fi fi-ss-star"></i>
                            <i class="fi fi-ss-star"></i>
                            <i class="fi fi-ss-star"></i>
                            <i class="fi fi-ss-star"></i>
                            <i class="fi fi-ss-star"></i>
                        </div>
                    </div>
                    <div class="work-frame" style="margin-left: 30px;">
                        <div style=" display: flex;">
                            <span class="work-title"><i class="fi fi-ss-book-heart icons"></i>เพิ่มเข้ารายการโปรด</span>
                            <span class="work-views">{{$favoriteCount}}</span>
                        </div>
                    </div>
                    <div class="work-frame" style="margin-left: 30px;">
                        <div style=" display: flex;">
                            <span class="work-title"><i class="fi fi-sr-comment-alt-middle icons"></i>ความคิดเห็น</span>
                            <span class="work-views">{{$reviewCount}}</span>
                        </div>
                    </div>
                </div>
                <table class="table text-center">
                    <tbody>
                        @foreach ($books as $book)
                        <tr>
                            <td>
                                <img src="{{ '../../public/images/' . $book->image_book }}" alt="รูปภาพหนังสือ"
                                    style="width: 100%;">
                            </td>
                            <td style="text-align: start; font-size: 16px;">
                                {{ $book->name_book }}
                            </td>
                            <td>
                                <span style="display: block; text-align: center; font-size: 16px;">ยอดวิว</span>
                                <span style="display: block; text-align: center; font-size: 16px;">
                                    @php
                                    $totalViews = isset( $totalViewsBybook[$book->id_book]) ?
                                    $totalViewsBybook[$book->id_book] : 0;
                                    @endphp
                                    {{$totalViews}}
                                </span>
                            </td>
                            <td>
                                <span style="display: block;text-align: center; font-size: 16px;">รีวิว</span>
                                <span style="display: block; text-align: center; font-size: 16px;">
                                @php
                                    $count = isset($reviewsCountBybook[$book->id_book]) ?
                                    $reviewsCountBybook[$book->id_book] : 0;
                                    @endphp
                                    {{ $count }}
                                </span>
                            </td>
                            <td>
                                <span
                                    style="display: block; text-align: center; font-size: 16px;">เพิ่มเข้ารายการโปรด</span>
                                <span style="display: block;text-align: center; font-size: 16px;">
                                    @php
                                    $count = isset($favoriteCountBybook[$book->id_book]) ?
                                    $favoriteCountBybook[$book->id_book] : 0;
                                    @endphp
                                    {{ $count }}
                                </span>
                            </td>
                            <td>
                                <span style="display: block; text-align: center; font-size: 16px;">ความคิดเห็น</span>
                                <span style="display: block;text-align: center; font-size: 16px;">
                                    @php
                                    $count = isset($reviewsCountBybook[$book->id_book]) ?
                                    $reviewsCountBybook[$book->id_book] : 0;
                                    @endphp
                                    {{ $count }}
                                </span>
                            </td>
                            <td>
                                <span style="display: block; font-size: 16px;">รายละเอียดไฟล์หนังสือ</span>
                                <span style="display: block; font-size: 16px;">
                                    @if($book->file_book)
                                    <a href="{{ '../../public/uploads/' . $book->file_book }}"
                                        target="_blank">ดูไฟล์หนังสือ</a>
                                    @else
                                    ไม่มีข้อมูล
                                    @endif
                                </span>
                            </td>
                            <td>
                                <form action="{{route('deleteBook',$book->id_book)}}" method="POST">
                                    <a href="{{ route('editbook', ['id_book' => $book->id_book]) }}" title="แก้ไข"><img
                                            src="{{ '../../public/storage/image/edit.png' }}" alt="" width="20px"></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('ต้องการลบหรือไม่?')"
                                        style="background: none; border: none; padding: 0; margin-left:5%" title="ลบ">
                                        <img src="{{ '../../public/storage/image/delete.png' }}" alt="" width="20px">
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="sales-content" style="display: none;">
                <!-- เนื้อหาที่เกี่ยวข้องกับ "ยอดขายทั้งหมด" -->
                <div class="work">
                    <div class="work-frame">
                        <div style=" display: flex;">
                            <span class="work-title"><i class="fi fi-rs-shopping-cart icons"></i>จำนวนซื้อทั้งหมด</span>
                            <span class="work-views">{{$buyCount}}</span>
                        </div>
                    </div>
                    <div class="work-frame" style="margin-left: 30px;">
                        <div style=" display: flex;">
                            <span class="work-title"><i class="fi fi-rr-coins icons"></i>จำวนวนเงินทั้งหมด</span>
                            <span class="work-views">{{$totalPrice}}</span>
                        </div>
                    </div>
                </div>
                <table class="table text-center">
                    <tbody>
                        @foreach ($books as $book)
                        <tr>
                            <td>
                                <img src="{{ '../../public/images/' . $book->image_book }}" alt="รูปภาพหนังสือ"
                                    style="width: 50%;">
                            </td>
                            <td>{{ $book->name_book }}</td>
                            <td> <span style="display: block; text-align: center;">จำนวนที่ซื้อ</span>
                                <span style="display: block; text-align: center;">
                                    @php
                                    $count = isset($buyCountBybook[$book->id_book]) ?
                                    $buyCountBybook[$book->id_book] : 0;
                                    @endphp
                                    {{ $count }}
                                </span>
                            </td>
                            <td> <span style="display: block;text-align: center;">จำนวนเงิน</span>
                                <span style="display: block; text-align: center;">
                                    @php
                                    $totalPrice = isset($totalPriceBybook[$book->id_book]) ?
                                    $totalPriceBybook[$book->id_book] : 0;
                                    @endphp
                                    {{$totalPrice}}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <script>
        // เรียกฟังก์ชันเมื่อหน้าเว็บโหลดเสร็จ
        document.addEventListener('DOMContentLoaded', function() {
            // ตรวจสอบสถานะการแสดงเนื้อหาเมื่อหน้าเว็บโหลด
            if (localStorage.getItem('activeContent') === 'portfolio') {
                // ถ้าผลงานทั้งหมดเป็นเนื้อหาที่กำลังแสดง
                document.getElementById('sales-content').style.display = 'none';
                document.getElementById('portfolio-content').style.display = 'block';
            } else {
                // ถ้ายังไม่มีการเลือกเนื้อหาอื่นๆ ให้แสดงเนื้อหายอดขายทั้งหมด
                document.getElementById('sales-content').style.display = 'block';
                document.getElementById('portfolio-content').style.display = 'none';
            }
            // สร้างการตรวจสอบเหตุการณ์การคลิกสำหรับลิงค์ "ผลงานทั้งหมด"
            document.getElementById('portfolio-link').addEventListener('click', function(event) {
                event.preventDefault(); // ป้องกันการโหลดหน้าใหม่

                // ซ่อนเนื้อหาทั้งหมดยอดขายและแสดงเนื้อหาของผลงานทั้งหมด
                document.getElementById('sales-content').style.display = 'none';
                document.getElementById('portfolio-content').style.display = 'block';

                // เก็บสถานะการแสดงเนื้อหาไว้ใน Local Storage
                localStorage.setItem('activeContent', 'portfolio');
            });

            // สร้างการตรวจสอบเหตุการณ์การคลิกสำหรับลิงค์ "ยอดขายทั้งหมด"
            document.getElementById('sales-link').addEventListener('click', function(event) {
                event.preventDefault(); // ป้องกันการโหลดหน้าใหม่

                // ซ่อนเนื้อหาผลงานทั้งหมดและแสดงเนื้อหาของยอดขายทั้งหมด
                document.getElementById('portfolio-content').style.display = 'none';
                document.getElementById('sales-content').style.display = 'block';
            });
        });
        </script>
</body>

</html>
</div>
</body>

</html>

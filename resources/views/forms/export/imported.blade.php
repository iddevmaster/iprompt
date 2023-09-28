<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/css/app.css' , 'resources/js/app.js'])
    @vite(['resources/css/form.css'])

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <!-- (Optional) html2canvas library to convert HTML content to canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }
        body {
        font-family: "THSarabunNew" !important;
        font-size: 18px;
        height: 100%;
      }
  .a4lan-container {
    width: 297mm; /* Width of A4 paper in millimeters */
    min-height: 200mm; /* Height of A4 paper in millimeters */
    margin: 0 auto; /* Center the container horizontally */
    background-color: white;
    position: relative; /* Required for footer positioning */
    padding: 1cm;
}
#a4container {
    min-height: unset !important;
    border:unset !important;
}
.downloadbtn{
    position: absolute;
    top: 0;
    right: 0;
    margin: 50px;
}
@page {
    margin: 0;
    margin-bottom: 1cm;
    margin-top: 1cm;
    size: "A4"; /* Define the paper size, you can use 'A4', 'letter', etc. */
}
@page:first {
    margin-top: 0cm;
}
@media print {
            .downloadbtn {
                visibility: hidden;
            }
            .a4-container {
                visibility: visible;
            }

        }
</style>
</head>
<body>
    <div id="a4container" class="a4-container border mb-5 d-flex align-items-center flex-column">

        <!-- header -->
        <div class="header border-bottom d-flex flex-column justify-content-center text-center align-items-center">
            <div class="mb-2"><img style="" src="{{ asset('dist/img/logoiddrives.png') }}" height="80"></div>
            <h4 class="fw-bold">บริษัท ไอดีไดรฟ์ จำกัด (สำนักงานใหญ่)</h4>
            <p>200/222 หมู่2 ถนนชัยพฤกษ์ อำเภอเมืองขอนแก่น จังหวัดขอนแก่น Tel:043-228-899 <br>
                เลขที่ผู้เสียภาษี 0 4055 36000 53 1  Email: idofficer@iddrives.co.th</p>
        </div> <!-- end header -->

        <!-- content -->
        <div class=" pt-3 w-100 d-flex flex-column text-center">
            <div class="my-3"><p class="fw-bold" style="font-size:20px">รายงานทะเบียนหนังสือรับเข้า</p></div>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">เลขที่หนังสือ</th>
                    <th scope="col">เรื่อง</th>
                    <th scope="col">จาก</th>
                    <th scope="col">ผู้บันทึก</th>
                    <th scope="col">ผู้รับ</th>
                    <th scope="col">ฝ่าย</th>
                    <th scope="col">บันทึกเมื่อ</th>
                    </tr>
                </thead>
                @php
                    $count = 1;
                @endphp
                <tbody class="table-group-divider">
                    @foreach ($gendoc as $row)
                        <tr>
                            <td>{{$count}}</td>
                            <td>{{$row->book_number}}</td>
                            <td title="{{$row->book_subj}}">{{\Illuminate\Support\Str::limit($row->book_subj, 20)}}</td>
                            <td>{{$row->from}}</td>
                            <td>{{$row->recoder}}</td>
                            <td>{{$row->receiver}}</td>
                            <td>
                                @foreach ($dpm as $dpme)
                                    @if ($dpme->id == $row->receiver_dpm)
                                        {{$dpme->name}}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{$row->receive_date}}</td>
                        </tr>
                        <?php $count++ ?>
                    @endforeach
                </tbody>
            </table>
        </div><!-- end content -->

        <!-- footer -->
        <div class="footer">
                <p class="mb-0" style="font-size:8px">Printed By {{ Auth::user()->name }}. Printed On: I-Prompt <?php date_default_timezone_set('Asia/Bangkok');
                                                                                                                        $now = time();
                                                                                                                        $thaiYear = intval(date('Y', $now)) + 543;
                                                                                                                        echo date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s', $now) . " +543 years")); ?>
                </p>
        </div> <!-- end footer -->
    </div>
    @if (auth()->user()->can('download'))
    <div class="d-flex justify-content-center downloadbtn">
        <button class="btn btn-success ms-2" onclick="printDiv()">Print</button>
    </div>
    @endif
    <script>
        function printDiv() {
            window.print();
        }
    </script>
</body>

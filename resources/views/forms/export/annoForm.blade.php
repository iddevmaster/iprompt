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
        font-family: "THSarabunNew";
        font-size: 18px;
        height: 100%;
      }
  .a4lan-container {
    width: 297mm; /* Width of A4 paper in millimeters */
    min-height: 210mm; /* Height of A4 paper in millimeters */
    margin: 0 auto; /* Center the container horizontally */
    background-color: white;
    position: relative; /* Required for footer positioning */
    padding: 1cm;
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
.editorContent2 > .image > img {
    width: -webkit-fill-available;
}
.editorContent2 > .image {
    margin: auto;
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
        <div class="anno-content pt-3 w-100 d-flex flex-column">
            <div class="text-center d-flex flex-column align-items-center">
                <br>
                    <h5 class="fw-bold">ประกาศที่ <span class="fw-normal">{{ $annNo }}</span></h5>
                    <h5 class="text-start mt-3 ms-2 " id="subject"><b>เรื่อง</b> {{$subject}}</h5>
                <br>
            </div>

            <div class="editorContent2" style="padding-left:1cm;padding-right:.5cm"> {!! $editorContent !!} </div>

            <div class="mt-auto w-100 ">
                <div class="ms-5 mt-4">
                        <p class="ms-5">มีผลบังคับใช้ตั้งแต่วันที่ {{ $useDate }}</p>
                        <p class="ms-5">ประกาศ ณ วันที่ {{ $annoDate }}</p>
                </div>
                <div class="mt-5 text-center d-flex flex-column align-items-center">
                    <p>จึงประกาศมาเพื่อทราบโดยทั่วกัน</p>
                    <div class="mb-1" id=""> <br>....................................</div>
                        <p class="mb-0">( {{ $signName }} )</p>
                        <p>{{ $signPosition }}</p>
                    <p class="mb-0">บริษัท ไอดีไดรฟ์ จำกัด</p>
                </div>
            </div>
        </div><!-- end content -->

        <!-- footer -->
        <div class="footer mt-auto">
            <p id="footertext">เอกสารนี้ ฉบับทางการ จะอยู่ในรูปไฟล์อิเล็กทรอนิกส์ อยู่ในระบบเครือข่ายสารสนเทศ เท่านั้น หากปรากฎเอกสารนี้ส่วนหนึ่งส่วนใด หรือทั้งฉบับ
                ในรูปสื่อกระดาษให้ตรวจสอบความทันสมัยกับฉบับทางการในระบบเครือข่ายสารสนเทศ ก่อนใช้อ้างอิง และทำลายทิ้งทันที หากพบว่าเป็นฉบับไม่ทันสมัย <br>
                เอกสารนี้ เป็น สมบัติของบริษัท ไอดีไดรฟ์ จำกัดห้ามแจกจ่ายไปยังภายนอก โดยไม่ได้รับอนุญาตจาก กรรมการผู้จัดการ บริษัท ไอดีไดรฟ์ จำกัด
                <p class="mb-0" style="font-size:8px">Printed By {{ Auth::user()->name }}. Printed On: I-Prompt <?php date_default_timezone_set('Asia/Bangkok');
                                                                                                                        $now = time();
                                                                                                                        $thaiYear = intval(date('Y', $now)) + 543;
                                                                                                                        echo date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s', $now) . " +543 years")); ?>
                </p>
            </p>
        </div> <!-- end footer -->
    </div>
    @if ($dorv !== 'verify' && auth()->user()->can('download'))
        @if ((Auth::user()->id == $submitb) || !(auth()->user()->can('staff')))
        <div class="d-flex justify-content-center downloadbtn">
            <button class="btn btn-success ms-2" onclick="printDiv()">Print</button>
        </div>
        @endif
    @endif
    <script>
    function printDiv() {
                window.print();
            }
    </script>
</body>

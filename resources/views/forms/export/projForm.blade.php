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
    .a4-container {
    width: 210mm; /* Width of A4 paper in millimeters */
    min-height: 297mm; /* Height of A4 paper in millimeters */
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
    <div id="proj-paper" class="a4-container border mb-5 d-flex align-items-center flex-column">
        <div class="header mb-3  text-center ">
            <p class="text-end mb-0">เอกสารโครงการเลขที่ {{$book_num}}</p>
            <p class="text-end">Project Code: {{$projNo}}</p>
            <p class="fw-bold">โครงการ {{$projName}}</p>
        </div>

        <!-- content -->
        <div class="content py-3 w-100 h-100 d-flex flex-column">
                <div class="editorContent2"  style="padding-left:1cm;padding-right:.5cm"> {!! $editorContent !!} </div>
                <input type="hidden" name="editorContent" value="{{$editorContent}}">
        </div><!-- end content -->

        <!-- footer -->
        <div class="footer mt-auto">
            <div class="d-flex justify-content-evenly">
                <div class="p-2 border border-black">
                    <p>ผู้จัดทำ/ผู้เสนอโครงการ</p>
                    <br>
                    @if ( ($sign->proj_subm ?? '' ) === '')
                        <p>(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</p>
                    @else
                        <p>( {{$sign->proj_subm}} )</p>
                    @endif
                </div>
                <div class="p-2 border border-black">
                    <p>ผู้ตรวจสอบโครงการ</p>
                    <br>
                    @if ( ( $sign->proj_ins ?? '' ) === '')
                        <p>(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</p>
                    @else
                        <p>( {{$sign->proj_ins}} )</p>
                    @endif
                </div>
                <div class="p-2 border border-black">
                    <p>ผู้อนุมัติโครงการ</p>
                    <br>
                    @if ( ($sign->proj_app ?? '' ) === '')
                        <p>(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</p>
                    @else
                        <p>( {{$sign->proj_app}} )</p>
                    @endif
                </div>
            </div>
            <p class="mb-0 mt-1" style="font-size:8px">Printed By {{ Auth::user()->name }}. Printed On: I-Prompt <?php echo date('Y-m-d H:i:s') ?></p>
        </div> <!-- end footer -->
    </div>
    @if ($dorv == 'download')
        @if ((Auth::user()->id == $submitb) || !(auth()->user()->can('staff')) || Auth::user()->hasRole(['admin', 'ceo']))
        <div class="d-flex justify-content-center downloadbtn">
            <button class="btn btn-success ms-2" onclick="printDiv()">Print</button>
        </div>
        @endif
    @endif
    <script>
    function printDiv() {
                window.print();
            }
            if (document.querySelector("table")) {
            const tables = document.querySelectorAll("table");
            tables.forEach(table => {
                table.classList.add("table-bordered");
            })
        }
    </script>
</body>

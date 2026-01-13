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
    <link rel="stylesheet" href="https://fastly.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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
        <div class="header">
            <table style="width: 100%">
                <tbody style="width: 100%">
                    <tr>
                        <td style="width: 70%">
                            <div class="d-flex flex-column justify-content-center align-items-center my-1">
                                <h5>ใบคำขอดำเนินการด้านเอกสาร</h5>
                                <h5 class="m-0">Document Action Request (DAR)</h5>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column justify-content-center align-items-center my-1">
                                <p class="m-0">หมายเลข DAR</p>
                                <p class="m-0"><u>{{ $dar_data->book_num }}</u></p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center my-1 gap-2">
                                <p class="m-0">ประเภทเอกสาร:</p>
                                <p class="m-0"><u>{{ implode(',', json_decode($dar_data->doc_type ?? [])) ?? "-" }}</u></p>
                            </div>
                            <div class="d-flex align-items-center my-1 gap-2">
                                <p class="m-0">ขอเพื่อ:</p>
                                <p class="m-0"><u>{{ $dar_data->action_type ?? "-" }}</u></p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div> <!-- end header -->

        <!-- content -->
        <div class="py-2 w-100">
            <table class="w-100">
                    <thead class="text-center">
                        <tr>
                            <th scope="col" rowspan="2">ลำดับที่</th>
                            <th scope="col" rowspan="2">หมายเลขเอกสาร</th>
                            <th scope="col" rowspan="2">ชื่อเอกสาร</th>
                            <th scope="col" colspan="2">สถานะหลังดำเนินการ</th>
                        </tr>
                        <tr>
                            <th scope="col">วันที่เริ่มใช้</th>
                            <th scope="col">แก้ไขครั้งที่</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($docs_list ?? [] as $index => $doc)
                            <tr>
                                <th class="text-center" scope="row">{{ $index + 1 }}</th>
                                <th class="text-center">{{ $doc['book_num'] }}</th>
                                <th>{{ $doc['title'] }}</th>
                                @php
                                    $app_list = json_decode($doc['approve'], true);
                                    $app_date = $app_list ? Carbon\Carbon::parse($app_list['date'] ?? null)->format('d/m/Y') : '-';
                                @endphp
                                <th class="text-center">{{ $app_date }}</th>
                                <th class="text-center">{{ $doc['edit_count'] + 1 }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div><!-- end content -->

        <!-- footer -->
        <div class="footer mt-auto">
            <table style="width: 100%;">
                <tbody style="width: 100%">
                    <tr>
                        <td>ผู้ถือครองเอกสาร &nbsp; <u>{{ $dar_data->doc_owner ?? "-" }}</u></td>
                    </tr>
                    <tr>
                        <td>ผู้ขอ &nbsp; {{ $dar_data->request_by ?? "-" }}</td>
                        <td>วันที่ขอ:</b> &nbsp; {{ $dar_data->request_at ?? "-" }}</td>
                        @php
                            $app = json_decode($dar_data->app);
                            $ins = json_decode($dar_data->ins);
                            $appName = $user->firstWhere('id', $app->appId ?? '') ?? [];
                            $insName = $user->firstWhere('id', $ins->appId ?? '') ?? [];
                            $note = $app->note ?? '-';
                            $insnote = $ins->note ?? '-';
                        @endphp
                        <td>ผู้ตรวจสอบ:</b> &nbsp; {{$insName ? $insName->name : '-'}}</td>
                        <td>วันที่ตรวจสอบ:</b> &nbsp; {{ $ins->date ?? "-" }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="">
                                <p class="m-0 text-start">ตัวแทนฝ่ายบริหาร:</p>
                                <div class="d-flex justify-content-around">
                                    <p class="m-0">ISO 9001</p>
                                    <p class="m-0">ISO 27001</p>
                                </div>
                                <div class="row text-start">
                                    <p class="m-0 col">ลายเซ็น</p>
                                    <p class="m-0 col">วันที่</p>
                                </div>
                            </div>
                        </td>
                        <td colspan="2">
                            <div class="">
                                <div class="row text-start mb-2">
                                    <p class="m-0 col">ผู้อนุมัติ: &nbsp; {{$appName ? $appName->name : '-'}}</p>
                                    <p class="m-0 col">สถานะ: &nbsp; {{ $dar_data->stat ?? "-" }}</p>
                                </div>
                                <div class="row text-start">
                                    <p class="m-0 col">ลายเซ็น
                                        @if ($appName->image ?? false)
                                            <span><img src="/files/signs/{{ $appName->image }}" class="ms-2" alt="sign" style="width: 100px; height: 30px; object-fit: contain;"></span>
                                        @endif
                                    </p>
                                    <p class="m-0 col">วันที่: &nbsp; {{$app ? ($app->date ?? "-") : '-'}}</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="text-start">
                        <td colspan="2">ผู้ลงทะเบียน DAR &nbsp; {{ optional($dar_data->getUser)->name ?? "-" }}</td>
                        <td colspan="2">วันที่ลงทะเบียน &nbsp; {{ $dar_data->created_at ?? "-" }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-between">
                <p class="mb-0" style="font-size:8px">Printed On: I-Prompt <?php echo date('Y-m-d H:i:s') ?></p>
                <p class="mb-0" style="font-size:8px">FD-ID-001 :01 :01-03-2564</p>
            </div>
        </div> <!-- end footer -->
    </div> <!-- end page -->
    <div class="d-flex justify-content-center downloadbtn">
        <button class="btn btn-success ms-2" onclick="printDiv()">Print</button>
    </div>
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

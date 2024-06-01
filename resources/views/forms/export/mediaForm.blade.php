<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config("app.name", "Laravel") }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=Nunito"
            rel="stylesheet"
        />

        <!-- Icon -->
        <link
            rel="stylesheet"
            href="https://fastly.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
        />



        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        <!-- (Optional) html2canvas library to convert HTML content to canvas -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

        <style>
            @font-face {
                font-family: "THSarabunNew";
                font-style: normal;
                font-weight: normal;
                src: url("{{ public_path('fonts/THSarabunNew.ttf') }}")
                    format("truetype");
            }
            @font-face {
                font-family: "THSarabunNew";
                font-style: normal;
                font-weight: bold;
                src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}")
                    format("truetype");
            }
            @font-face {
                font-family: "THSarabunNew";
                font-style: italic;
                font-weight: normal;
                src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}")
                    format("truetype");
            }
            @font-face {
                font-family: "THSarabunNew";
                font-style: italic;
                font-weight: bold;
                src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}")
                    format("truetype");
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
            .downloadbtn {
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


            .editorContent {
                display: flex;
                justify-content: center;
                flex-direction: column;
                align-items: center;
            }
            .editorContent p{
                width: 100%;
                display: block !important;
                padding-left:1cm;
                padding-right:.5cm;

            }

            .editorContent table{
                width:fit-content;
                text-align: center;
                min-width: 30%;
            }
            .editorContent figure{
                display: flex;
                justify-content: center;
                width: -webkit-fill-available;
            }
            .editorContent img{
                width: inherit;
            }
            .editorContent ul, ol{
                text-indent: unset;
                text-align: start;
                width: 100%;
            }
        </style>
    </head>
    <body>
        <div
            id="a4container"
            class="a4lan-container border mb-5 d-flex align-items-center flex-column"
        >
            <!-- header -->
            <div class="header">
                <!-- header row 1 -->
                <div
                    class="row border border-black mx-0 text-center"
                    id="page-header"
                >
                    <div class="col pt-2">
                        <img
                            src="{{ asset('dist/img/logoiddrives.png') }}"
                            height="60"
                        />
                        <p class="mt-1">บริษัท ไอดีไดรฟ์ จำกัด</p>
                    </div>
                    <div class="col-5 border border-black border-top-0 border-bottom-0">
                        <h5 class="mt-3 fw-bold">
                            สื่อการตลาด
                        </h5>
                        <div class="d-flex">
                            <h5 class="text-start mt-2 fw-bold">เรื่อง</h5>
                            <h5 class="text-start mt-2 ms-2" id="subject">
                                {{ $subject }}
                            </h5>
                            <input
                                type="hidden"
                                name="subject"
                                value="{{ $subject }}"
                            />
                        </div>
                    </div>
                    <div class="col pt-2">
                        <?php
                            $datetime = (json_decode($form->app))->date ?? date('Y-m-d');
                            $dated = new DateTime($datetime);
                         ?>
                        <p class="text-start mb-0">
                            เลขที่เอกสาร {{ $bookNo }}
                        </p>
                        <input
                            type="hidden"
                            name="bookNo"
                            value="{{ $bookNo }}"
                        />
                        <p class="text-start mb-0">แก้ไขครั้งที่ 0</p>
                        <p class="text-start mb-0">
                            วันที่บังคับใช้
                            {{$dated->format('Y-m-d') ?? ''}}
                        </p>
                        <p class="text-start mb-1">หน้าที่ 1/1</p>
                    </div>
                </div>
                <!-- end header row 1 -->

                <!-- header row 2 -->
                <div
                    class="row mx-0 w-100 border border-black border-top-0 justify-content-center text-center"
                >
                    @php
                        $app = json_decode($form->app);
                        $ins = json_decode($form->ins);
                        $appName = App\Models\User::find($app->appId);
                        $insName = App\Models\User::find($ins->appId);
                        $submit_id = json_decode($form->submit_by);

                        // check type of submit_id
                        if (is_array($submit_id)) {
                            $owner = App\Models\User::find($submit_id[0]);
                        } else {
                            $owner = App\Models\User::find($submit_id);
                        }
                    @endphp
                    <div class="col py-2 text-start align-items-start">
                        <div class="d-flex">
                            <p class="mb-1">ผู้จัดทำ:</p>
                            @if ($owner->image ?? false)
                                <img src="/files/signs/{{ $owner->image }}" class="ms-2" alt="sign" style="width: 100px; height: 50px;">
                            @endif
                        </div>
                        <p class="text-center mb-0">{{ $creater }}</p>
                        <input type="hidden" name="creater" value="{{ $creater }}">
                    </div>
                    <div class="col-5 py-2 text-start align-items-start border border-black border-top-0 border-bottom-0">
                        <div class="d-flex">
                            <p class="mb-1">ผู้ตรวจสอบ:</p>
                            @if ($form->stat === 'ผ่านการอนุมัติ')
                                @if ($insName->image ?? false)
                                    <img src="/files/signs/{{ $insName->image }}" class="ms-2" alt="sign" style="width: 100px; height: 50px;">
                                @endif
                            @endif
                        </div>
                        <p class="mb-0 text-center">{{ $inspector }}</p>
                        <input type="hidden" name="inspector" value="{{ $inspector }}">
                    </div>
                    <div class="col py-2 text-start align-items-start">
                        <div class="d-flex">
                            <p class="mb-1">ผู้อนุมัติ:</p>
                            @if ($form->stat === 'ผ่านการอนุมัติ')
                                @if ($appName->image ?? false)
                                    <img src="/files/signs/{{ $appName->image }}" class="ms-2" alt="sign" style="width: 100px; height: 50px;">
                                @endif
                            @endif
                        </div>
                        <p class="mb-0 text-center">{{ $approver }}</p>
                        <input type="hidden" name="approver" value="{{ $approver }}">
                    </div>
                </div>
                <!-- end header row 2 -->
            </div>
            <!-- end header -->

            <!-- content -->
            <div class="content pt-3 w-100">
                <div class="editorContent" style="">
                    {!! $editorContent !!}
                </div>
            </div>
            <!-- end content -->

            <!-- footer -->
            <div class="footer mt-auto">
                <p id="footertext">
                    เอกสารนี้ ฉบับทางการ จะอยู่ในรูปไฟล์อิเล็กทรอนิกส์
                    อยู่ในระบบเครือข่ายสารสนเทศ เท่านั้น
                    หากปรากฎเอกสารนี้ส่วนหนึ่งส่วนใด หรือทั้งฉบับ<br />
                    ในรูปสื่อกระดาษให้ตรวจสอบความทันสมัยกับฉบับทางการในระบบเครือข่ายสารสนเทศ
                    ก่อนใช้อ้างอิง และทำลายทิ้งทันที หากพบว่าเป็นฉบับไม่ทันสมัย
                    <br />
                    เอกสารนี้ เป็น สมบัติของบริษัท ไอดีไดรฟ์
                    จำกัดห้ามแจกจ่ายไปยังภายนอก โดยไม่ได้รับอนุญาตจาก
                    กรรมการผู้จัดการ บริษัท ไอดีไดรฟ์ จำกัด
                    <p class="mb-0" style="font-size:8px">Printed On: I-Prompt <?php echo date('Y-m-d H:i:s') ?></p>
                </p>
            </div>
            <!-- end footer -->
        </div>
        <!-- end paper page -->

        @if ($dorv == 'download')
            <div class="d-flex justify-content-center downloadbtn">
                <button class="btn btn-success ms-2" onclick="printDiv()">
                    Print
                </button>
            </div>
        @endif
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/css/app.css' ,
        'resources/js/app.js', 'resources/css/form.css'])
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
</html>

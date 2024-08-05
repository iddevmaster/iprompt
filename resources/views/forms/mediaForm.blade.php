@extends('layouts.app')
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/super-build/ckeditor.js"></script>
@vite(['resources/css/form.css' , 'resources/js/form.js'])
<style>
.a4lan-container {
    width: 297mm; /* Width of A4 paper in millimeters */
    min-height: 210mm; /* Height of A4 paper in millimeters */
    margin: 0 auto; /* Center the container horizontally */
    background-color: white;
    position: relative; /* Required for footer positioning */
    padding: 1cm;
}
.editorContent > figure > img {
    width: -webkit-fill-available;
}
</style>
@section('content')
<head>
    <!-- Import your CSS file here -->
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>
<body onbeforeunload="return myFunction()">
    <div class="text-center my-4">
        <h2>สื่อการตลาด</h2>
    </div>
    <form class="overflow-x-auto" id="myForm" action="{{ route('preview') }}" method="POST" >
        @csrf
        <div class="a4lan-container border mb-5 d-flex align-items-center flex-column">
            <!-- header -->
            <div class="header">
                <!-- header row 1 -->
                <div class="row border border-black mx-0  text-center" id="page-header">
                    <div class="col pt-2">
                        <img src="{{ asset('dist/img/logoiddrives.png') }}" height="60">
                        <p class="mt-1">บริษัท ไอดีไดรฟ์ จำกัด</p>
                    </div>
                    <div class="col-5 border border-black border-top-0 border-bottom-0">
                        <h5 class="mt-3 fw-bold">สื่อการตลาด</h5>
                        <div class="d-flex">
                            <h5 class="text-start mt-2 fw-bold">เรื่อง</h5>
                            @if ($class)
                                <h5 class="text-start mt-2 ms-2 " id="subject">{{$subject}}</h5>
                                <input type="hidden" name="subject" value="{{$subject}}">
                            @else
                                <input class="ms-2 w-100" id="subject" style="overflow-wrap: break-word;" type="text" name="subject" required>
                            @endif
                        </div>

                    </div>
                    <div class="col pt-2">
                        @if ($class)
                            <p class="text-start mb-0">เลขที่เอกสาร {{$bookNo}}</p>
                            <input type="hidden" name="bookNo" value="{{$bookNo}}">
                            <p class="text-start mb-0">แก้ไขครั้งที่ 0</p>
                            <p class="text-start mb-0">วันที่บังคับใช้ </p>
                            <p class="text-start mb-1">หน้าที่ 1/1</p>
                        @else
                            <p class="text-start mb-0">เลขที่เอกสาร <span id="currentYear"></span></p>
                            <input type="hidden" name="bookNo" value="">
                            <p class="text-start mb-0">แก้ไขครั้งที่ 0</p>
                            <p class="text-start mb-0">วันที่บังคับใช้ </p>
                            <p class="text-start">หน้าที่ 1/1</p>

                            @php
                                $formattedLen = str_pad($len, 2, '0', STR_PAD_LEFT);
                            @endphp
                            <script>
                                // Get the current date
                                var currentDate = new Date();
                                var currentYear = currentDate.getFullYear()+543;
                                document.getElementById("currentYear").innerText = "MKT-MD-{{$formattedLen}}";
                                document.getElementsByName('bookNo')[0].value = "MKT-MD-{{$formattedLen}}";
                            </script>
                        @endif
                    </div>
                </div><!-- end header row 1 -->

                <!-- header row 2 -->
                <div class="row mx-0 w-100 border border-black border-top-0 justify-content-center text-center">
                    <div class="col py-2 text-start align-items-start">
                        <p class="mb-1">ผู้จัดทำ:</p>
                        @if ($class)
                            <p class="mt-2 mb-0 text-center">{{ $creater }}</p>
                            <input type="hidden" name="creater" value="{{ $creater }}">
                        @else
                            <input class="w-100" type="text" name="creater" required>
                        @endif
                    </div>
                    <div class="col-5 py-2 text-start align-items-start border border-black border-top-0 border-bottom-0">
                        <p class="mb-1">ผู้ตรวจสอบ:</p>
                        @if ($class)
                            <p class="mt-2 mb-0 text-center">{{ $inspector }}</p>
                            <input type="hidden" name="inspector" value="{{ $inspector }}">
                        @else
                            <input class="w-100" type="text" name="inspector" required>
                        @endif
                    </div>
                    <div class="col py-2 text-start align-items-start">
                        <p class="mb-1">ผู้อนุมัติ:</p>
                        @if ($class)
                            <p class="mt-2 mb-0 text-center">{{ $approver }}</p>
                            <input type="hidden" name="approver" value="{{ $approver }}">
                        @else
                            <input class="w-100" type="text" name="approver" required>
                        @endif
                    </div>
                </div><!-- end header row 2 -->
            </div> <!-- end header -->

            <!-- content -->
            <div class="content py-5 w-100 h-100">
                @if ($class)
                    <div class="editorContent" style="padding-left:1cm;padding-right:.5cm"> {!! $editorContent !!}</div>
                    <input type="hidden" name="editorContent" value="{{ $editorContent }}">
                    <?php
                        session_start();
                        $_SESSION['data'] = $editorContent;
                    ?>
                @else
                    <textarea id="editor" name="myInput">
                        <?php session_start();?>
                            @if ($_SESSION['data'] ?? false)
                                {!! $_SESSION['data'] !!}
                            @endif
                    </textarea>
                @endif
            </div><!-- end content -->
            <div class="mb-2" >
                @if (!$class)
                    <div id="frameContainer"></div>
                    <input type="hidden" id="iframeInput" name="iframeElement">
                    <button type="button" class="btn btn-info" id="addFrame">Iframe</button>
                @endif
            </div>
            <script>
                if (document.querySelector("table")) {
                    const tables = document.querySelectorAll("table");
                    tables.forEach(table => {
                        table.classList.add("table-bordered");
                    })
                }
            </script>
            <!-- footer -->
            <div class="footer mt-auto">
                <p id="footertext">เอกสารนี้ ฉบับทางการ จะอยู่ในรูปไฟล์อิเล็กทรอนิกส์ อยู่ในระบบเครือข่ายสารสนเทศ เท่านั้น หากปรากฎเอกสารนี้ส่วนหนึ่งส่วนใด หรือทั้งฉบับ
                    ในรูปสื่อกระดาษให้ตรวจสอบความทันสมัยกับฉบับทางการในระบบเครือข่ายสารสนเทศ ก่อนใช้อ้างอิง และทำลายทิ้งทันที หากพบว่าเป็นฉบับไม่ทันสมัย <br>
                    เอกสารนี้ เป็น สมบัติของบริษัท ไอดีไดรฟ์ จำกัดห้ามแจกจ่ายไปยังภายนอก โดยไม่ได้รับอนุญาตจาก กรรมการผู้จัดการ บริษัท ไอดีไดรฟ์ จำกัด
                </p>
            </div> <!-- end footer -->

            <!-- send form type for preview -->
            <input type="hidden" name="formtype" id="formtype" value="mediaForm">

        </div> <!-- end paper page -->

        @if ($class)
            @php
                $types = App\Models\type::where('type', 'media')->get();
            @endphp
            <div class="my-2 d-flex justify-content-center">
                <div >
                    <select class="form-select" aria-label="Default select example" name="subtype">
                        <option selected disabled>All</option>
                        @foreach ($types as $type)
                            <option value="{{$type->subtype}}">{{$type->subtype}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

        <div class="d-flex justify-content-center ">
            @if ($class)
                <button type="button" class="btn btn-secondary" id="backButton">Back</button>
                <button type="submit" class="btn btn-success ms-2" name="submit" value="save">Save</button>
            @else
                <a href="{{ route('home') }}"><button type="button" class="btn btn-secondary">cancle</button></a>
                <button type="submit" id="preview-btn" class="btn btn-success ms-2" name="submit" value="preview">Preview</button>
            @endif

            <script>
                function goBack() {
                    window.history.back();
                };
                document.getElementById('backButton').addEventListener('click', goBack);

                function myFunction() {
                    return "ตรวจสอบให้แน่ใจว่าคุณต้องการออกจากหน้านี้";
                }
            </script>
        </div>
    </form>
    <script src="https://fastly.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const addFrameBtn = document.getElementById('addFrame');
        const framContainer = document.getElementById('frameContainer');
        const iframeInput = document.getElementById('iframeInput');
        addFrameBtn.addEventListener('click', () => {
            Swal.fire({
                input: "textarea",
                inputLabel: "Add iframe",
                inputPlaceholder: "Type your iframe here...",
                inputAttributes: {
                    "aria-label": "Type your iframe here"
                },
                showCancelButton: true,
                preConfirm: (inputValue) => {
                    // Perform your validation or processing here
                    if (!inputValue.trim()) {
                        // If validation fails, throw an error message
                        Swal.showValidationMessage('Please entry your iframe!');
                    } else {
                        // If validation passes, you can return the value or do something with it
                        return inputValue; // The resolved value will be passed to the `.then()` chained call
                    }
                }
            }).then((result) => {
                if (result.value) {
                    console.log('Textarea content:', result.value);
                    framContainer.innerHTML += result.value;
                    iframeInput.value += result.value;

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    console.log('Textarea input was cancelled');
                }
            });
        })
    </script>
</body>
<!-- Scripts -->
@endsection

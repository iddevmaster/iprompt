@extends('layouts.app')

@section('content')
<head>
    <!-- Import your CSS file here -->
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>
<body onbeforeunload="return myFunction()">
    <div class="text-center my-4">
        <h2>ใบคำขอดำเนินการด้านเอกสาร (DAR)</h2>
    </div>
    <form id="myForm" class="overflow-x-auto" action="{{ route('preview') }}" method="POST" >
        @csrf
        <div class="a4-container border mb-5 d-flex align-items-center flex-column">

            <!-- header -->
            <div class="header">
                <!-- header row 1 -->
                <div class="row border border-black mx-0  text-center" id="page-header">
                    <div class="col pt-2">
                        <img style="" src="{{ asset('dist/img/logoiddrives.png') }}" height="60">
                        <p class="mt-1">บริษัท ไอดีไดรฟ์ จำกัด</p>
                    </div>
                    <div class="col-5 border border-black border-top-0 border-bottom-0">
                        <h5 class="mt-3 fw-bold">มาตรฐานขั้นตอนการปฏิบัติงาน</h5>
                        <h5 class="fw-bold">JOB DESCRIPTION (JD)</h5>
                        <div class="d-flex ">
                            <h5 class="text-start mt-3 fw-bold">เรื่อง</h5>
                            @if ($class)
                                <h5 class="text-start mt-3 ms-2 " id="subject">{{$subject}}</h5>
                                <input type="hidden" name="subject" value="{{$subject}}">
                            @else
                                <input class="ms-2 w-100" id="subject" style="overflow-wrap: break-word;" type="text" name="subject" required>
                            @endif
                        </div>

                    </div>
                    <div class="col pt-2">
                        @if ($class)
                            <p class="text-start mb-0" style="font-size: 12px;">เลขที่ {{$bookNo}}</p>
                            <input type="hidden" name="bookNo" value="{{$bookNo}}">
                            <p class="text-start mb-0" style="font-size: 12px;">แก้ไขครั้งที่ 0</p>
                            <p class="text-start mb-0" style="font-size: 12px;">วันที่บังคับใช้ </p>
                            <p class="text-start" style="font-size: 12px;">หน้าที่ 1/1</p>
                        @else
                            @php
                                $dpm_prefix = strlen(Auth::user()->getDpm->prefix) > 4 ? 'ID' : Auth::user()->getDpm->prefix;
                            @endphp
                            <p class="text-start mb-0">
                                เลขที่
                                <span id="docArea">
                                    <input type="text" name="bookNo" id="bookNo" required readonly>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#genModal">
                                        Generate
                                    </button>
                                </span>
                            </p>

                            <p class="text-start mb-0">แก้ไขครั้งที่ 0</p>
                            <p class="text-start mb-0">วันที่บังคับใช้</p>
                            <p class="text-start">หน้าที่ 1/1</p>
                        @endif
                    </div>
                </div><!-- end header row 1 -->

                <div class="modal fade" id="genModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">เลือกการใช้งานเลขเอกสาร</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body text-center">
                                <button type="button" class="btn btn-outline-primary w-100 mb-2" onclick="generateDoc('company')">
                                    ใช้ทั้งบริษัท
                                </button>

                                <button type="button" class="btn btn-outline-secondary w-100" onclick="generateDoc('department')">
                                    ใช้ภายในฝ่าย
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- header row 2 -->
                <div class="row mx-0 w-100 border border-black border-top-0 justify-content-center text-center">
                    <div class="col py-2 text-start align-items-start">
                        <p >ผู้จัดทำ:</p>
                        @if ($class)
                            <p class="mt-2 mb-0 text-center ">{{ $creater }}</p>
                            <input type="hidden" name="creater" value="{{ $creater }}">
                        @else
                            <input class="w-100" type="text" id="creater" name="creater" required>
                        @endif
                    </div>
                    <div class="col-5 py-2 text-start align-items-start border border-black border-top-0 border-bottom-0">
                        <p class="">ผู้ตรวจสอบ:</p>
                        @if ($class)
                            <p class=" mt-2 mb-0 text-center">{{ $inspector }}</p>
                            <input type="hidden" name="inspector" value="{{ $inspector }}">
                        @else
                            <input class="w-100" type="text" name="inspector" required>
                        @endif
                    </div>
                    <div class="col py-2 text-start align-items-start">
                        <p class="">ผู้อนุมัติ:</p>
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
            <div class="content py-4 w-100 h-100">
                @if ($class)
                    <?php
                        session_start();
                        $_SESSION['data'] = $editorContent;
                    ?>
                    <div class="editorContent2" style="padding-left:1cm;padding-right:.5cm"> {!! $editorContent !!} </div>
                    <input type="hidden" name="editorContent" value="{{ $editorContent }}">
                @else
                    <textarea id="editor" name="myInput">
                    <?php session_start();?>
                        @if ($_SESSION['data'] ?? false)
                            {!! $_SESSION['data'] !!}
                        @endif
                    </textarea>
                @endif
            </div><!-- end content -->
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
            <input type="hidden" name="formtype" id="formtype" value="jdForm">

        </div>
        <div class="d-flex justify-content-center ">
            @if ($class)
                <button type="button" class="btn btn-secondary" id="backButton">Back</button>
                <button type="submit" class="btn btn-success ms-2" name="submit" value="save">Save</button>
            @else
                <a href="{{ route('home') }}"><button type="button" class="btn btn-secondary">cancle</button></a>
                <button type="submit" on id="preview-btn" class="btn btn-success ms-2" name="submit" value="preview">Preview</button>
            @endif
            <script>
                function goBack() {
                    window.history.back();
                };
                document.getElementById('backButton').addEventListener('click', goBack);
            </script>
        </div>
    </form>
    <!-- Scripts -->
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/super-build/ckeditor.js"></script>
    @vite(['resources/css/form.css' , 'resources/js/form.js'])

    <script>
        const editorData = document.getElementById('editor');
        const textField = document.getElementById('creater');
        textField.addEventListener('input', () => {
            console.log(editor);
        });

        function myFunction() {
            return "ตรวจสอบให้แน่ใจว่าคุณต้องการออกจากหน้านี้";
        }

        function generateDoc(type) {
            const year = new Date().getFullYear() + 543;
            const len = "{{ $len ?? '1' }}";
            const department = "{{ $dpm_prefix ?? 'ID' }}"; // เช่น IT, HR, QA

            let docNo = '';

            if (type === 'company') {
                // JD-ID/ฝ่าย-0x-00-ปี
                docNo = `JD-ID/${department}-0${len}-00-${year}`;
            } else {
                // JD-ฝ่าย-0x-00-ปี
                docNo = `JD-${department}-0${len}-00-${year}`;
            }

            // เปลี่ยนปุ่ม Generate เป็น text
            // document.getElementById('docArea').innerText = docNo;

            // set hidden input
            document.getElementById('bookNo').value = docNo;

            // ปิด modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('genModal'));
            modal.hide();
        }

        document.getElementById('myForm').addEventListener('submit', function (e) {
            const bookNo = document.getElementById('bookNo').value.trim();

            // เช็คว่า bookNo ว่างหรือไม่
            if (bookNo.length === 0) {
                e.preventDefault(); // ❌ หยุด submit
                alert('กรุณากด Generate เพื่อสร้างเลขที่ก่อน');
                return false;
            }
        });
    </script>
</body>
@endsection

@extends('layouts.app')



@section('content')
<body>
    <div class="text-center my-4">
        <h2>ระเบียบการปฏิบัติงาน</h2>
    </div>
    <form id="myForm" action="{{ route('preview') }}" method="POST" >
        @csrf
        <div class="a4-container border mb-5 d-flex align-items-center flex-column">

            <!-- header -->
            <div class="header">
                <!-- header row 1 -->
                <div class="row border border-black mx-0  text-center" id="page-header">
                    <div class="col pt-2">
                        <img style="" src="{{ asset('dist/img/logoiddrives.png') }}" height="100">
                        <p class="mt-1">บริษัท ไอดีไดรฟ์ จำกัด</p>
                    </div>
                    <div class="col-5 border border-black border-top-0 border-bottom-0">
                        <h5 class="mt-3 fw-bold">ระเบียบการปฏิบัติงาน</h5>
                        <h5 class="fw-bold">Standard Operating Procedure (SOP)</h5>
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
                            <p class="text-start mb-0">เลขที่เอกสาร {{$bookNo}}</p>
                            <input type="hidden" name="bookNo" value="{{$bookNo}}">
                            <p class="text-start mb-0">แก้ไขครั้งที่ 0</p>
                            <p class="text-start mb-0">วันที่บังคับใช้ <?php echo date('Y/m/d') ?></p>
                            <p class="text-start">หน้าที่ 1/1</p>
                        @else
                            <p class="text-start mb-0">เลขที่เอกสาร <span id="currentYear"></span></p>
                            <input type="hidden" name="bookNo" value="">
                            <p class="text-start mb-0">แก้ไขครั้งที่ 0</p>
                            <p class="text-start mb-0">วันที่บังคับใช้ <?php echo date('Y/m/d') ?></p>
                            <p class="text-start">หน้าที่ 1/1</p>

                            <script>
                                // Get the current date
                                var currentDate = new Date();
                                var currentYear = currentDate.getFullYear()+543;
                                document.getElementById("currentYear").innerText = "SOP0{{$len}}/"+currentYear;
                                document.getElementsByName('bookNo')[0].value = "SOP0{{$len}}/"+currentYear;
                            </script>
                        @endif
                    </div>
                </div><!-- end header row 1 -->

                <!-- header row 2 -->
                <div class="row mx-0 w-100 border border-black border-top-0 justify-content-center text-center">
                    <div class="col py-2 text-start d-flex align-items-start">
                        <p class="no-wrap">ผู้จัดทำ:</p>
                        @if ($class)
                            <p class="no-wrap mt-4">{{ $creater }}</p>
                            <input type="hidden" name="creater" value="{{ $creater }}">
                        @else
                            <input class="w-100" type="text" id="creater" name="creater" required>
                        @endif
                    </div>
                    <div class="col-5 py-2 text-start d-flex align-items-start border border-black border-top-0 border-bottom-0">
                        <p class="no-wrap">ผู้ตรวจสอบ:</p>
                        @if ($class)
                            <p class="no-wrap mt-4">{{ $inspector }}</p>
                            <input type="hidden" name="inspector" value="{{ $inspector }}">
                        @else
                            <input class="w-100" type="text" name="inspector" required>
                        @endif
                    </div>
                    <div class="col py-2 text-start d-flex align-items-start">
                        <p class="no-wrap">ผู้อนุมัติ:</p>
                        @if ($class)
                            <p class="no-wrap mt-4">{{ $approver }}</p>
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
                    <div style="text-indent: 2.5em;padding-left:1.5cm;padding-right:1cm"> {!! $editorContent !!} </div>
                    <input type="hidden" name="editorContent" value="{{ $editorContent }}">
                @else
                    <textarea id="editor" name="myInput">
                    <?php session_start();?>
                        @if ($_SESSION['data'] ?? false)
                            {!! $_SESSION['data'] !!}
                        @endif
                    <?php session_destroy();?>
                    </textarea> 
                @endif
            </div><!-- end content -->

            <!-- footer -->
            <div class="footer mt-auto">
                <p id="footertext">เอกสารนี้ ฉบับทางการ จะอยู่ในรูปไฟล์อิเล็กทรอนิกส์ อยู่ในระบบเครือข่ายสารสนเทศ เท่านั้น หากปรากฎเอกสารนี้ส่วนหนึ่งส่วนใด หรือทั้งฉบับ
                    ในรูปสื่อกระดาษให้ตรวจสอบความทันสมัยกับฉบับทางการในระบบเครือข่ายสารสนเทศ ก่อนใช้อ้างอิง และทำลายทิ้งทันที หากพบว่าเป็นฉบับไม่ทันสมัย <br>
                    เอกสารนี้ เป็น สมบัติของบริษัท ไอดีไดรฟ์ จำกัดห้ามแจกจ่ายไปยังภายนอก โดยไม่ได้รับอนุญาตจาก กรรมการผู้จัดการ บริษัท ไอดีไดรฟ์ จำกัด
                </p>
            </div> <!-- end footer -->

            <!-- send form type for preview -->
            <input type="hidden" name="formtype" id="formtype" value="sopForm">

        </div>
        <div class="d-flex justify-content-center ">
            @if ($class)
                <a href="javascript:void(0);"><button type="button" class="btn btn-secondary">Back</button></a>
                <button type="submit" class="btn btn-success ms-2" name="submit" value="save">Save</button>
            @else
                <a href="{{ route('home') }}"><button type="button" class="btn btn-secondary">cancle</button></a>
                <button type="submit" on id="preview-btn" class="btn btn-success ms-2" name="submit" value="preview">Preview</button>
            @endif
            <script>
                function goBack() {
                    window.history.go(-1);
                    window.scrollTo(0, 0);
                }
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
    </script>
</body>



@endsection
@extends('layouts.app')

<!-- Scripts -->
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/super-build/ckeditor.js"></script>
@vite(['resources/css/form.css' , 'resources/js/form.js'])

@section('content')
<head>
    <!-- Import your CSS file here -->
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>
<body onbeforeunload="return myFunction()">
    <div class="text-center my-4">
        <h2>ประกาศ</h2>
    </div>
    <form id="myForm" class="overflow-x-auto" action="{{ route('preview') }}" method="POST" >
        @csrf
        <div class="a4-container border mb-5 d-flex align-items-center flex-column">

            <!-- header -->
            <div class="header border-bottom d-flex flex-column justify-content-center text-center align-items-center">
                <div class="mb-2"><img style="" src="{{ asset('dist/img/logoiddrives.png') }}" height="100"></div>
                <h4 class="fw-bold">บริษัท ไอดีไดรฟ์ จำกัด (สำนักงานใหญ่)</h4>
                <p>200/222 หมู่2 ถนนชัยพฤกษ์ อำเภอเมืองขอนแก่น จังหวัดขอนแก่น Tel:043-228-899 <br>
                    เลขที่ผู้เสียภาษี 0 4055 36000 53 1  Email: idofficer@iddrives.co.th</p>
            </div> <!-- end header -->

            <!-- content -->
            <div class="anno-content py-3 w-100 d-flex flex-column">
                <div class="text-center d-flex flex-column align-items-center">
                    <br>
                    @if ($class)
                        <h5 class="fw-bold">ประกาศที่ <span class="fw-normal">{{ $annNo }}</span></h5>
                        <input type="hidden" name="annNo" value="{{$annNo}}">
                    @else
                        <h5 class="fw-bold">ประกาศที่ <input type="text" value="" name="annNo" readonly></h5>
                        <script>
                            // Get the current date
                            var currentDate = new Date();
                            var currentYear = currentDate.getFullYear()+543;
                            document.getElementsByName('annNo')[0].value = "AN0{{$len}}/"+currentYear;
                        </script>
                    @endif


                    @if ($class)
                        <h5 class="text-start mt-3 ms-2 " id="subject"><b>เรื่อง</b> {{$subject}}</h5>
                        <input type="hidden" name="subject" value="{{$subject}}">
                    @else
                        <h5 class="fw-bold">เรื่อง <input type="text" name="subject" required></h5>
                    @endif
                    <br>
                </div>

                @if ($class)
                    <?php
                        session_start();
                        $_SESSION['data'] = $editorContent;
                    ?>
                    <div class="editorContent2" style="padding-left:1cm;padding-right:.5cm"> {!! $editorContent !!} </div>
                    <input type="hidden" name="editorContent" value="{{$editorContent}}">
                @else
                    <textarea id="editor" name="myInput">
                        <?php session_start();?>
                            @if ($_SESSION['data'] ?? false)
                                {!! $_SESSION['data'] !!}
                            @endif
                        <?php session_destroy();?>
                    </textarea>
                @endif

                <div class="mt-auto w-100 ">
                    <div class="ms-5 mt-4">

                        @if ($class)
                            <p class="ms-5">มีผลบังคับใช้ตั้งแต่วันที่ {{ $useDate }}</p>
                            <p class="ms-5">ประกาศ ณ วันที่ {{ $annoDate }}</p>
                            <input type="hidden" name="useDate" value="{{$useDate}}">
                            <input type="hidden" name="annoDate" value="{{$annoDate}}">
                        @else
                            <p class="ms-5">มีผลบังคับใช้ตั้งแต่วันที่  <input class="ms-2" type="text" name="useDate" required></p>
                            <p class="ms-5">ประกาศ ณ วันที่  <input class="ms-2" type="text" name="annoDate" required></p>
                        @endif

                    </div>
                    <div class="mt-5 text-center d-flex flex-column align-items-center">
                        <p>จึงประกาศมาเพื่อทราบโดยทั่วกัน</p>
                        <div class="mb-1" id="sign"> <br></div>
                        @if ($class)
                            <p class="mb-0">( {{ $signName }} )</p>
                            <p>{{ $signPosition }}</p>
                            <input type="hidden" name="signName" value="{{$signName}}">
                            <input type="hidden" name="signPosition" value="{{$signPosition}}">
                        @else
                            <p>( <input name="signName" type="text" placeholder="กรุณากรอกชื่อ" required> )</p>
                            <input class="w-50 mb-2" name="signPosition" type="text" placeholder="กรุณากรอกตำแหน่ง" required>
                        @endif

                        <p class="mb-0">บริษัท ไอดีไดรฟ์ จำกัด</p>
                    </div>
                </div>
            </div><!-- end content -->

            <!-- footer -->
            <div class="footer mt-auto">
                <p id="footertext">เอกสารนี้ ฉบับทางการ จะอยู่ในรูปไฟล์อิเล็กทรอนิกส์ อยู่ในระบบเครือข่ายสารสนเทศ เท่านั้น หากปรากฎเอกสารนี้ส่วนหนึ่งส่วนใด หรือทั้งฉบับ
                    ในรูปสื่อกระดาษให้ตรวจสอบความทันสมัยกับฉบับทางการในระบบเครือข่ายสารสนเทศ ก่อนใช้อ้างอิง และทำลายทิ้งทันที หากพบว่าเป็นฉบับไม่ทันสมัย <br>
                    เอกสารนี้ เป็น สมบัติของบริษัท ไอดีไดรฟ์ จำกัดห้ามแจกจ่ายไปยังภายนอก โดยไม่ได้รับอนุญาตจาก กรรมการผู้จัดการ บริษัท ไอดีไดรฟ์ จำกัด
                </p>
            </div> <!-- end footer -->

            <!-- send form type for preview -->
            <input type="hidden" name="formtype" id="formtype" value="annoForm">
        </div>

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
                    return "Changes you made may not be saved.";
                }
            </script>
        </div>
    </form>
</body>



@endsection

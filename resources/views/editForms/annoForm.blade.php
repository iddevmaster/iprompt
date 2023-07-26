@extends('layouts.app')

<!-- Scripts -->
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/super-build/ckeditor.js"></script>
@vite(['resources/css/form.css' , 'resources/js/form.js'])

@section('content')
<body>
    <div class="text-center my-4">
        <h2>ประกาศ</h2>
    </div>
    <form id="myForm" action="{{ route('update') }}" method="POST" >
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
                        <h5 class="fw-bold">ประกาศที่ <input type="text" value="{{$form->book_num}}" name="annNo" readonly></h5>
                        <h5 class="fw-bold">เรื่อง <input type="text" name="subject" value="{{$form->title}}" required></h5>
                    <br>
                </div>  
                    <textarea id="editor" name="myInput">{{$form->detail}}</textarea>
                <div class="mt-auto w-100 ">
                    <div class="ms-5 mt-4">
                        <p class="ms-5">มีผลบังคับใช้ตั้งแต่วันที่  <input class="ms-2" type="text" name="useDate" value="{{$form->use_date}}" required></p>
                        <p class="ms-5">ประกาศ ณ วันที่  <input class="ms-2" type="text" name="annoDate" value="{{$form->anno_date}}" required></p>
                    </div>
                    <div class="mt-5 text-center d-flex flex-column align-items-center">
                        <p>จึงประกาศมาเพื่อทราบโดยทั่วกัน</p>
                        <div class="mb-1" id="sign"> <br></div>
                            <p>( <input name="signName" type="text" placeholder="กรุณากรอกชื่อ" value="{{$form->sign_name}}" required> )</p>
                            <input class="w-50 mb-2" name="signPosition" type="text" placeholder="กรุณากรอกตำแหน่ง" value="{{$form->sign_position}}" required>
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
            <input type="hidden" name="formtype" id="formtype" value="{{$form->type}}">
            <input type="hidden" name="formid"  value="{{$form->id}}">
        </div>

        <div class="d-flex justify-content-center ">
                <a href="#" onclick="goBack()"><button type="button" class="btn btn-secondary">cancle</button></a>
                <button type="submit" id="preview-btn" class="btn btn-success ms-2" >Save</button>
            <script>
                function goBack() {
                    window.history.go(-1);
                    window.scrollTo(0, 0);
                }
            </script>
        </div>
    </form>
</body>



@endsection
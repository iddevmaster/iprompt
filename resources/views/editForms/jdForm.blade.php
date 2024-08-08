@extends('layouts.app')

<!-- Scripts -->
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/super-build/ckeditor.js"></script>
@vite(['resources/css/form.css' , 'resources/js/form.js'])

@section('content')
<body>
    <div class="text-center my-4">
        <h2>มาตรฐานขั้นตอนการปฏิบัติงาน</h2>
    </div>
    <form id="myForm" action="{{ route('update') }}" method="POST" >
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
                        <h5 class="mt-3 fw-bold">มาตรฐานขั้นตอนการปฏิบัติงาน</h5>
                        <h5 class="fw-bold">JOB DESCRIPTION (JD)</h5>
                        <div class="d-flex ">
                            <h5 class="text-start mt-3 fw-bold">เรื่อง</h5>
                                <input class="ms-2 w-100" id="subject" style="overflow-wrap: break-word;" value="{{$form->title}}" type="text" name="subject" required>
                        </div>

                    </div>
                    <div class="col pt-2">
                        <?php
                            $datetime = (json_decode($form->app))->date ?? date('Y-m-d');
                            $dated = new DateTime($datetime);
                         ?>
                        <p class="text-start mb-0">เลขที่เอกสาร {{$form->book_num}}</p>
                        <p class="text-start mb-0">แก้ไขครั้งที่ {{$form->edit_count}}</p>
                        <p class="text-start mb-0">วันที่บังคับใช้ {{$dated->format('Y-m-d') ?? ''}}</p>
                        <p class="text-start">หน้าที่</p>
                    </div>
                </div><!-- end header row 1 -->

                <!-- header row 2 -->
                <div class="row mx-0 w-100 border border-black border-top-0 justify-content-center text-center">
                    <div class="col py-2 text-start d-flex align-items-start">
                        <p class="no-wrap">ผู้จัดทำ:</p>
                            <input class="w-100" type="text" value="{{$form->bcreater}}" name="creater" required>
                    </div>
                    <div class="col-5 py-2 text-start d-flex align-items-start border border-black border-top-0 border-bottom-0">
                        <p class="no-wrap">ผู้ตรวจสอบ:</p>
                            <input class="w-100" type="text" value="{{$form->binspector}}" name="inspector" required>
                    </div>
                    <div class="col py-2 text-start d-flex align-items-start">
                        <p class="no-wrap">ผู้อนุมัติ:</p>
                            <input class="w-100" type="text" name="approver" value="{{$form->bapprover}}" required>
                    </div>
                </div><!-- end header row 2 -->
            </div> <!-- end header -->

            <!-- content -->
            <div class="content py-5 w-100 h-100">
                    <textarea id="editor" name="myInput">{!! $form->detail !!}</textarea>
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

        @if ($form->stat !== 'ผ่านการอนุมัติ')
        <div class="d-flex justify-content-center ">
                <a href="#" onclick="goBack()"><button type="button" class="btn btn-secondary">cancle</button></a>
                <button type="submit" id="preview-btn" class="btn btn-success ms-2">Save</button>
            <script>
                function goBack() {
                    window.history.go(-1);
                    window.scrollTo(0, 0);
                }
            </script>
        </div>
        @endif
    </form>
</body>



@endsection

@extends('layouts.app')

<!-- Scripts -->
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/super-build/ckeditor.js"></script>
@vite(['resources/css/form.css' , 'resources/js/form.js'])

@section('content')
<body>

    <div class="text-center my-4">
        <h2>โครงการ</h2>
    </div>
    <form id="myForm" action="{{ route('update') }}" method="POST" >
        @csrf
        <div id="proj-paper" class="a4-container border mb-5 d-flex align-items-center flex-column">

            <!-- header -->
            <div class="header mb-5 d-flex flex-row justify-content-end text-center ">
                <div class="flex-grow-1">
                    <p>โครงการ <input class="ms-2" type="text" name="projName" value="{{$form->title}}" required></p>
                </div>
                <div>
                    <p>เอกสารโครงการเลขที่ <input class="ms-2" id="projNo" type="text" name="proj_num" value="{{$form->proj_num}}" readonly></p>
                    <p class="mb-0">Project Code: <input class="ms-2" id="projNo" type="text" name="projNo" value="{{$form->proj_code}}" required></p>
                    <p class="fs-6 text-warning">#กรุณาขอเลข project code จากฝ่ายบัญชี</p>
                </div>
            </div> <!-- end header -->

            <!-- content -->
            <div class="content py-3 w-100 h-100 d-flex flex-column">
                    <textarea id="editor" name="myInput" >{{$form->detail}}</textarea>
            </div><!-- end content -->

            <!-- footer -->
            <div class="footer mt-auto">
                <div class="d-flex justify-content-evenly">
                    <div class="p-2 border border-black">
                        <p>ผู้จัดทำโครงการ</p>
                        <br>
                        <p>(..................................)</p>
                    </div>
                    <div class="p-2 border border-black">
                        <p>ผู้เสนอโครงการ</p>
                        <br>
                        <p>(..................................)</p>
                    </div>
                    <div class="p-2 border border-black">
                        <p>ผู้ตรวจสอบโครงการ</p>
                        <br>
                        <p>(..................................)</p>
                    </div>
                    <div class="p-2 border border-black">
                        <p>ผู้อนุมัติโครงการ</p>
                        <br>
                        <p>(..................................)</p>
                    </div>
                </div>
            </div> <!-- end footer -->

            <!-- send form type for preview -->
            <input type="hidden" name="formtype" id="formtype" value="{{$form->type}}">
            <input type="hidden" name="formid"  value="{{$form->id}}">
        </div>
        <div class="d-flex justify-content-center ">
                <a href="#" onclick="goBack()" ><button type="button" class="btn btn-secondary">cancle</button></a>
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
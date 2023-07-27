@extends('layouts.app')

<!-- Scripts -->
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/super-build/ckeditor.js"></script>
@vite(['resources/css/form.css' , 'resources/js/form.js'])

@section('content')
<body>

    <div class="text-center my-4">
        <h2>โครงการ</h2>
    </div>
    <form id="myForm" action="{{ route('preview') }}" method="POST" >
        @csrf
        <div id="proj-paper" class="a4-container border mb-5 d-flex align-items-center flex-column">

            <!-- header -->
            <div class="header mb-5 d-flex flex-row justify-content-end text-center ">
                <div class="flex-grow-1">
                    @if ($class)
                        <div class="d-flex">
                            <p class="fw-bold">ชื่อโครงการ</p>
                            <div class="text-start ms-2" style="font-size: 16px;">{{$projName}}</div>
                            <input type="hidden" name="projName" value="{{$projName}}">
                        </div>
                        
                    @else
                        <p>ชื่อโครงการ <input class="ms-2" type="text" name="projName" required></p>
                    @endif
                </div>

                <div>
                    @if ($class)
                        <p>เอกสารโครงการเลขที่ {{$proj_num}}</p>
                        <input type="hidden" name="proj_num" value="{{$proj_num}}">
                        <div class="d-flex ms-2">
                            <p class="no-wrap">Project Code: </p>
                            <div class="text-start ms-2" style="font-size: 16px;">{{$projNo}}</div>
                            <input type="hidden" name="projNo" value="{{$projNo}}">
                        </div>
                    @else
                        <p>เอกสารโครงการเลขที่ <input class="w-50" type="text" value="PRO0{{$len ?? 0}}/2566" name="proj_num" readonly></p>
                        <p class="mb-0">Project Code: <input class="ms-2" id="projNo" type="text" name="projNo" required></p>
                        <p class="fs-6 text-warning">#กรุณาขอเลข project code จากฝ่ายบัญชี</p>
                    @endif
                </div>
            </div> <!-- end header -->

            <!-- content -->
            <div class="content py-3 w-100 h-100 d-flex flex-column">
                @if ($class)
                    <div style="text-indent: 2.5em;padding-left:1.5cm;padding-right:1cm"> {!! $editorContent !!} </div>
                    <input type="hidden" name="editorContent" value="{{$editorContent}}">
                @else
                    <textarea id="editor" name="myInput" ></textarea>
                    
                @endif
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
            <input type="hidden" name="formtype" id="formtype" value="projForm">
        </div>
        <div class="d-flex justify-content-center ">
            @if ($class)
                <a href="javascript:void(0);" onclick="goBack();"><button type="button" class="btn btn-secondary">Back</button></a>
                <button type="submit" class="btn btn-success ms-2" name="submit" value="save">Save</button>
            @else
                <a href="{{ route('home') }}"><button type="button" class="btn btn-secondary">cancle</button></a>
                <button type="submit" id="preview-btn" class="btn btn-success ms-2" name="submit" value="preview">Preview</button>
            @endif
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
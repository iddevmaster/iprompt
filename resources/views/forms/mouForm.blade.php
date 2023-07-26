@extends('layouts.app')

<!-- Scripts -->
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/super-build/ckeditor.js"></script>
@vite(['resources/css/form.css' , 'resources/js/form.js'])

@section('content')
<body>
    <div class="text-center my-4">
        <h2>บันทึกข้อตกลงความร่วมมือ</h2>
    </div>
    <form id="myForm" action="{{ route('preview') }}" method="POST" >
        @csrf
        <div class="a4-container border mb-5 d-flex align-items-center flex-column">

            <!-- header -->
            <div class="header d-flex flex-column justify-content-center text-center align-items-center">
                <img src="{{ asset('dist/img/logoiddrives.png') }}" height="60">
                <p class="mb-1 fw-bold">บันทึกข้อตกลงความร่วมมือ</p>
                
                @if ($class)
                <p class="text-end w-100">เลขที่ {{$mou_num}}</p>
                <input type="hidden" name="mou_num" value="{{$mou_num}}">
                    <div class="d-flex">
                        <p class="fw-bold mb-1">เรื่อง</p>
                        <div class="text-start mb-1 ms-2" style="font-size: 16px;">{{$subject}}</div>
                        <input type="hidden" name="subject" value="{{$subject}}">
                    </div>
                @else
                    <p class="text-end w-100">เลขที่ <input class="" type="text" value="MOU0{{$len ?? 0}}/2566" name="mou_num" readonly></p>
                    <p class="no-wrap w-100">เรื่อง <input class="ms-2" type="text" name="subject" id="" required></p>
                @endif


                    <p class="mb-0">ระหว่าง</p>
                @if ($class)
                    <p class="mb-0">{{$party1}}</p>
                    <input type="hidden" name="party1" value="{{$party1}}">
                    @foreach($parties as $party)
                    <p class="mb-0">และ</p>
                    <p class="mb-0">{{$party}}</p>
                    @endforeach
                    <input type="hidden" name="parties" value="{{ json_encode($parties) }}">
                @else
                    <input class="w-50" type="text" id="input1" name="party1" required>
                    <div class="w-100" id="inputContainer"></div>
                    <button type="button" class="my-2 btn btn-info" id="addInputButton">Add Input</button>
                @endif
                
                @if ($class)
                    <p class="my-2 w-100 text-center">บันทึกข้อตกลงฉบับนี้จัดทำขึ้น ณ {{$location}}</p>
                    <input type="hidden" name="location" value="{{$location}}">
                @else
                    <p class="no-wrap my-2 w-100">บันทึกข้อตกลงฉบับนี้จัดทำขึ้น ณ <input class="ms-2 w-100" type="text" name="location" required></p>
                @endif
            </div> <!-- end header -->

            <!-- content -->
            <div class="content my-4 w-100 h-100 d-flex flex-column">
                @if ($class)
                    <div style="text-indent: 2.5em;"> {!! $editorContent !!} </div>
                    <input type="hidden" name="editorContent" value="{{$editorContent}}">
                @else
                    <textarea id="editor" name="myInput" ></textarea>
                    
                @endif
            </div><!-- end content -->

            <!-- footer -->
            <div class="footer mt-auto">
                <div class="d-flex justify-content-evenly">
                    <div class="p-2">
                        <p class="mb-0">.............................................</p>
                        <p>(...........................................)</p>
                        <p>ตำแหน่ง</p>
                    </div>
                    <div class="p-2">
                        <p class="mb-0">.............................................</p>
                        <p>(...........................................)</p>
                        <p>ตำแหน่ง</p>
                    </div>
                </div>
                <div class="d-flex justify-content-evenly">
                    <div class="p-2">
                        <p class="mb-0">.............................................</p>
                        <p>(...........................................)</p>
                        <p>พยาน</p>
                    </div>
                    <div class="p-2">
                        <p class="mb-0">.............................................</p>
                        <p>(...........................................)</p>
                        <p>พยาน</p>
                    </div>
                </div>
                <div class="d-flex justify-content-evenly">
                    <div class="p-2">
                        <p class="mb-0">.............................................</p>
                        <p>(...........................................)</p>
                        <p>ตำแหน่ง</p>
                    </div>
                    <div class="p-2">
                        <p class="mb-0">.............................................</p>
                        <p>(...........................................)</p>
                        <p>ตำแหน่ง</p>
                    </div>
                </div>
            </div> <!-- end footer -->

            <!-- send form type for preview -->
            <input type="hidden" name="formtype" id="formtype" value="mouForm">
        </div>

        <!-- Button -->
        <div class="d-flex justify-content-center ">
            @if ($class)
                <a href="javascript:void(0);"><button type="button" class="btn btn-secondary">Back</button></a>
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
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
        <h2>บันทึกข้อตกลงความร่วมมือ</h2>
    </div>
    <form id="myForm" class="overflow-x-auto" action="{{ route('preview') }}" method="POST" >
        @csrf
        <div class="a4-container border mb-5 d-flex align-items-center flex-column">

            <!-- header -->
            <div class="header d-flex flex-column justify-content-center text-center align-items-center">
                <img src="{{ asset('dist/img/logoiddrives.png') }}" height="60">
                <p class="mb-1 fw-bold">บันทึกข้อตกลงความร่วมมือ</p>

                @if ($class)
                <p class="text-end w-100">เลขที่ {{$book_num}}</p>
                <input type="hidden" name="book_num" value="{{$book_num}}">
                    <div class="d-flex">
                        <p class="fw-bold mb-1">เรื่อง</p>
                        <div class="text-start mb-1 ms-2" style="font-size: 16px;">{{$subject}}</div>
                        <input type="hidden" name="subject" value="{{$subject}}">
                    </div>
                @else
                    <p class="text-end w-100">เลขที่ <input class="" type="text" value="MOU0{{$len ?? 0}}/{{ now()->format('Y') + 543 }}" name="book_num" readonly></p>
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
                    <button type="button" class="my-2 btn btn-info" id="addInputButton">เพิ่มข้อมูล</button>
                    <p class="text-danger">*สามารถเพิ่มได้ไม่เกิน 3 ฝ่าย</p>
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
                    <?php
                        session_start();
                        $_SESSION['data'] = $editorContent;
                    ?>
                    <div class="editorContent2" style="padding-left:1cm;padding-right:.5cm"> {!! $editorContent !!} </div>
                    <input type="hidden" name="editorContent" value="{{$editorContent}}">
                @else
                    <textarea id="editor" name="myInput" >
                        <?php session_start();?>
                            @if ($_SESSION['data'] ?? false)
                                {!! $_SESSION['data'] !!}
                            @endif
                        <?php session_destroy();?>
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
            @if ($class)
                <div class="d-flex justify-content-evenly" id="signcontainer" style="flex-wrap:wrap; padding: 0 50px 0 50px;">
                @foreach ($allSigns as $sign)
                    <div class="p-2">
                        <p class="mb-0">.............................................</p>
                        <p class="mb-0">( {{$sign['signName']}} )</p>
                        <p>{{$sign['signPos']}}</p>
                    </div>
                @endforeach
                    <input type="hidden" name="allSigns" value="{{json_encode($allSigns)}}">
                </div>
            @else
                <div class="d-flex justify-content-evenly" id="signcontainer" style="flex-wrap:wrap; padding: 0 50px 0 50px;"></div>
                <button type="button" class="btn btn-primary" id="addsignButton">เพิ่มผู้ลงนาม</button>
                <input type="hidden" id="signCount" name="signCount" value="0">
            @endif
            </div> <!-- end footer -->

            <!-- send form type for preview -->
            <input type="hidden" name="formtype" id="formtype" value="mouForm">
        </div>

        <!-- Button -->
        <div class="d-flex justify-content-center ">
            @if ($class)
                <button type="button" class="btn btn-secondary" onclick="goBack()">Back</button>
                <button type="submit" class="btn btn-success ms-2" name="submit" value="save">Save</button>
            @else
                <a href="{{ route('home') }}"><button type="button" class="btn btn-secondary">cancle</button></a>
                <button type="submit" id="preview-btn" class="btn btn-success ms-2" name="submit" value="preview">Preview</button>
            @endif
            <script>
                function goBack() {
                    window.history.back();
                };

                // Get references to the button and container elements
                const addButton = document.getElementById('addsignButton');
                const container = document.getElementById('signcontainer');
                const signCount = document.getElementById('signCount');
                let value = 1;
                // Function to add content to the container
                function addContent() {
                    const content = `
                        <div class="p-2">
                            <p class="mb-0">.............................................</p>
                            <p class="mb-0">(<input type="text" name="signname${value}" placeholder="ชื่อ">)</p>
                            <p><input type="text" name="signpos${value}" placeholder="ตำแหน่ง"></p>
                        </div>
                    `;
                    container.innerHTML += content;
                    signCount.value = value;
                    value += 1;
                }

                // Add a click event listener to the button
                addButton.addEventListener('click', addContent);

                function myFunction() {
                    return "ตรวจสอบให้แน่ใจว่าคุณต้องการออกจากหน้านี้";
                }
            </script>
        </div>
    </form>
</body>



@endsection

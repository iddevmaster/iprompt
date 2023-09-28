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
</style>
@section('content')
<head>
    <!-- Import your CSS file here -->
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>
<body onbeforeunload="return myFunction()">
    <div class="text-center my-4">
        <h2>มาตรฐานขั้นตอนการปฏิบัติงาน</h2>
    </div>
    <form class="overflow-x-auto" id="myForm" action="#" method="POST" >
        @csrf
        <div class="a4-container border mb-5 d-flex align-items-center flex-column">
            <!-- header -->
            <div class="header">
                <!-- header row 1 -->

                <table class="table table-bordered">
                    <tbody class="fw-bold">
                        <tr class="text-center">
                            <td><img src="{{ asset('dist/img/logoiddrives.png') }}" height="80"></td>
                            <td colspan="2" class="align-middle"><p class="mt-1 fs-3">JOB DESCRIPTION</p></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="py-3">
                                <div class="row w-100 align-items-center">
                                    <div class="col-auto">
                                        <label for="inputPassword6" class="col-form-label">Issued by Div./Dept./Site : </label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="text" id="inputPassword6" class="form-control w-100">
                                    </div>
                                </div>
                              </td>
                        </tr>
                        <tr>
                            <td>
                                <p>ผู้จัดทำ</p>
                                <p>Date</p>
                            </td>
                            <td>
                                <p>ผู้ตรวจสอบ</p>
                                <p>Date</p>
                            </td>
                            <td>
                                <p>ผู้อนุมัติ</p>
                                <p>Date</p>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div> <!-- end header -->

            <!-- content -->
            <div class="content py-5 w-100 h-100">
                <div>
                    <p>ตำแหน่ง</p>
                </div>
                <div>
                    <p>Layer ( 1 - 6.4 )</p>
                </div>
                <div>
                    <p>Functional Title</p>
                </div>
                <div>
                    <p>สังกัดฝ่าย/แผนก ( Div./Dept. )</p>
                </div>
                <div>
                    <p>ผู้บังคับบัญชา ( Report to )</p>
                </div>
                <div>
                    <p>ผู้ใต้บังคับบัญชา ( Supervisory Role )</p>
                </div>
                <div>
                    <p>วัตถุประสงค์ (Key Objective)</p>
                </div>
                <div>
                    <textarea id="editor" name="myInput"></textarea>
                </div>
                <div>
                    <p>ความรับผิดชอบหลัก (Key Objective)</p>
                </div>
                <div>
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="text-center">
                                <td>กิจกรรมหลัก</td>
                                <td>ดัชนีชี้วัดผลงาน <br> (Key Performance Indicator)</td>
                            </tr>
                            <tr>
                                <td><textarea id="editor" name="myInput2" class="w-100"></textarea></td>
                                <td><textarea id="editor" name="myInput3" class="w-100"></textarea></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <p>คุณสมบัติ (Qualification)</p>
                </div>
                <div>

                </div>


            </div><!-- end content -->

            <!-- send form type for preview -->
            <input type="hidden" name="formtype" id="formtype" value="jdForm">

        </div> <!-- end paper page -->

        <div class="d-flex justify-content-center ">
            @if (true)
                <button type="button" class="btn btn-secondary" id="backButton">Back</button>
                <button type="submit" class="btn btn-success ms-2" name="submit" value="save" disabled>Save</button>
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
<!-- Scripts -->


@endsection

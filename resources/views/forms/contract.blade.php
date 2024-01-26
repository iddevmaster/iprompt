@extends('layouts.app')

@section('content')
<head>
    <!-- Import your CSS file here -->
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">

    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet"/>

</head>
<body>
    <?php $regData = \App\CoreFunction\Helper::regData();?>
    <div class="container">
        <div class="row d-flex justify-content-center text-center">
            <h2 class="my-3">Contract</h2>

            <ul class="nav nav-pills mb-3 justify-content-center mt-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">สัญญา-เจ้าหนี้</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">สัญญา-ลูกหนี้</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Out door</button>
                </li>
            </ul>

            <div class="card p-4">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">

                        <p class="fs-2">สัญญา-เจ้าหนี้</p>

                        <form action="{{ route('contract-store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="contact_type" value="creditor">

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_bnum" class="col-form-label">เลขที่หนังสือ</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_bnum" id="cont_bnum" value="{{ 'CT-CRE' . str_pad($ctcre_count + 1 , 3, '0', STR_PAD_LEFT) . "/" . (now()->year + 543)}}" class="form-control" readonly required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_title" class="col-form-label">เรื่อง</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_title" id="cont_title" class="form-control" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_party" class="col-form-label">คู่สัญญา</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_party" id="cont_party" class="form-control" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="dateRange" class="col-form-label">ระยะเวลาสัญญา</label>
                                </div>
                                <div class="col-8">
                                <input type="text" name="dateRange" id="dateRange" class="form-control dateRangePicker" value="" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="recurring" class="col-form-label">การเกิดซ้ำ</label>
                                </div>
                                <div class="col-8">
                                    <div class="d-flex">
                                        <div class="form-check text-start mx-4">
                                            <input class="form-check-input enableCheck" type="checkbox" name="recur" value="1" id="check1">
                                            <label class="form-check-label" for="check1">
                                                เปิด
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="0" id="check2" disabled>
                                            <label class="form-check-label" for="check8">
                                                อา
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="1" id="check3" disabled>
                                            <label class="form-check-label" for="check2">
                                                จ
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="2" id="check4" disabled>
                                            <label class="form-check-label" for="check3">
                                                อ
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="3" id="check5" disabled>
                                            <label class="form-check-label" for="check4">
                                                พ
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="4" id="check6" disabled>
                                            <label class="form-check-label" for="check5">
                                                พฤ
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="5" id="check7" disabled>
                                            <label class="form-check-label" for="check6">
                                                ศ
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="6" id="check8" disabled>
                                            <label class="form-check-label" for="check7">
                                                ส
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_note" class="col-form-label">หมายเหตุ</label>
                                </div>
                                <div class="col-8">
                                    <textarea class="form-control" name="cont_note" id="cont_note" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="row my-3 g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_files" class="col-form-label">ไฟล์แนบ</label>
                                </div>
                                <div class="col-8">
                                    <input type="file" class="filepond" id="myFile" data-max-file-size="10MB" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="d-flex justify-content-center">
                                    <button id="cancel" type="button" class="btn btn-danger ms-2" >ยกเลิก</button>
                                    <button type="submit" class="btn btn-success ms-2" >บันทึก</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                        <p class="fs-2">สัญญา-ลูกหนี้</p>

                        <form action="{{ route('contract-store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="contact_type" value="debtor">

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_bnum" class="col-form-label">เลขที่หนังสือ</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_bnum" id="cont_bnum" value="{{ 'CT-DEB' . str_pad($ctdeb_count + 1, 3, '0', STR_PAD_LEFT) . "/" . (now()->year + 543)}}" class="form-control" readonly required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_title" class="col-form-label">เรื่อง</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_title" id="cont_title" class="form-control" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_party" class="col-form-label">คู่สัญญา</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_party" id="cont_party" class="form-control" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="dateRange" class="col-form-label">ระยะเวลาสัญญา</label>
                                </div>
                                <div class="col-8">
                                <input type="text" name="dateRange" id="dateRange2" class="form-control dateRangePicker" value="" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="recurring" class="col-form-label">การเกิดซ้ำ</label>
                                </div>
                                <div class="col-8">
                                    <div class="d-flex">
                                        <div class="form-check text-start mx-4">
                                            <input class="form-check-input enableCheck" type="checkbox" name="recur" value="1" id="check1">
                                            <label class="form-check-label" for="check1">
                                                เปิด
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="0" id="check2" disabled>
                                            <label class="form-check-label" for="check8">
                                                อา
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="1" id="check3" disabled>
                                            <label class="form-check-label" for="check2">
                                                จ
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="2" id="check4" disabled>
                                            <label class="form-check-label" for="check3">
                                                อ
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="3" id="check5" disabled>
                                            <label class="form-check-label" for="check4">
                                                พ
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="4" id="check6" disabled>
                                            <label class="form-check-label" for="check5">
                                                พฤ
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="5" id="check7" disabled>
                                            <label class="form-check-label" for="check6">
                                                ศ
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="6" id="check8" disabled>
                                            <label class="form-check-label" for="check7">
                                                ส
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_note" class="col-form-label">หมายเหตุ</label>
                                </div>
                                <div class="col-8">
                                    <textarea class="form-control" name="cont_note" id="cont_note" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="row my-3 g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_files" class="col-form-label">ไฟล์แนบ</label>
                                </div>
                                <div class="col-8">
                                    <input type="file" class="filepond" id="myFile" data-max-file-size="10MB" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="d-flex justify-content-center">
                                    <button id="cancel" type="button" class="btn btn-danger ms-2" >ยกเลิก</button>
                                    <button type="submit" class="btn btn-success ms-2" >บันทึก</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">

                        <p class="fs-2">Out Door</p>

                        <form action="{{ route('contract-store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="contact_type" value="outdoor">

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_bnum" class="col-form-label">เลขที่หนังสือ</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_bnum" id="cont_bnum" value="{{ 'OTD' . str_pad($ctotd_count + 1, 3, '0', STR_PAD_LEFT) . "/" . (now()->year + 543)}}" class="form-control" readonly required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_title" class="col-form-label">เรื่อง</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_title" id="cont_title" class="form-control" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_party" class="col-form-label">คู่สัญญา</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_party" id="cont_party" class="form-control" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="dateRange" class="col-form-label">ระยะเวลาสัญญา</label>
                                </div>
                                <div class="col-8">
                                <input type="text" name="dateRange" id="dateRange3" class="form-control dateRangePicker" value="" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="recurring" class="col-form-label">การเกิดซ้ำ</label>
                                </div>
                                <div class="col-8">
                                    <div class="d-flex">
                                        <div class="form-check text-start mx-4">
                                            <input class="form-check-input enableCheck" type="checkbox" name="recur" value="1" id="check1">
                                            <label class="form-check-label" for="check1">
                                                เปิด
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="0" id="check2" disabled>
                                            <label class="form-check-label" for="check8">
                                                อา
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="1" id="check3" disabled>
                                            <label class="form-check-label" for="check2">
                                                จ
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="2" id="check4" disabled>
                                            <label class="form-check-label" for="check3">
                                                อ
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="3" id="check5" disabled>
                                            <label class="form-check-label" for="check4">
                                                พ
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="4" id="check6" disabled>
                                            <label class="form-check-label" for="check5">
                                                พฤ
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="5" id="check7" disabled>
                                            <label class="form-check-label" for="check6">
                                                ศ
                                            </label>
                                        </div>
                                        <div class="form-check text-start mx-2">
                                            <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="6" id="check8" disabled>
                                            <label class="form-check-label" for="check7">
                                                ส
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_note" class="col-form-label">หมายเหตุ</label>
                                </div>
                                <div class="col-8">
                                    <textarea class="form-control" name="cont_note" id="cont_note" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="row my-3 g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_files" class="col-form-label">ไฟล์แนบ</label>
                                </div>
                                <div class="col-8">
                                    <input type="file" class="filepond" id="myFile" data-max-file-size="10MB" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="d-flex justify-content-center">
                                    <button id="cancel" type="button" class="btn btn-danger ms-2" >ยกเลิก</button>
                                    <button type="submit" class="btn btn-success ms-2" >บันทึก</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://unpkg.com/filepond/dist/filepond.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    @if (session('success'))
        Swal.fire({
            title: "Success!",
            text: "You form has been save!",
            icon: "success"
        });
    @elseif (session('error'))
        Swal.fire({
                title: "Error!",
                text: "Something wrong!",
                icon: "error"
            });
            console.log("{{ session('error') }}");
    @endif

    document.getElementById('cancel').addEventListener('click', function () {
        Swal.fire({
            title: 'ยกเลิกการบันทึกข้อมูล?',
            text: "ข้อมูลของคุณจะถูกลบ!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ตกลง!',
            cancelButtonText: 'ย้อนกลับ'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route('home') }}';
            }
        })
    });

    $(document).ready(function() {
        $('[id^="myFile"]').each(function(index, element) {
            FilePond.create(element, {
                allowMultiple: true,
                name: 'cont_files[]',
            });
        });
    });


    // const inputElement = document.querySelector('#myFile');
    // FilePond.create(inputElement, {
    //     allowMultiple: true,
    //     name: 'cont_files[]',
    // });

    // const inputElement2 = document.querySelector('#myFile2');
    // FilePond.create(inputElement2, {
    //     allowMultiple: true,
    //     name: 'cont_files[]',
    // });

    // const inputElement3 = document.querySelector('#myFile3');
    // FilePond.create(inputElement3, {
    //     allowMultiple: true,
    //     name: 'cont_files[]',
    // });

    FilePond.setOptions({
        server: {
            process: '/contract/file-upload',
            revert: '/contract/file-delete',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
    });

    $(document).ready(function() {
        $('.dateRangePicker').daterangepicker({
            locale: {
                format: 'DD/MM/Y',
                separator: ' - ',
                applyLabel: 'ตกลง',
                cancelLabel: 'ยกเลิก',
                fromLabel: 'จาก',
                toLabel: 'ถึง',
                customRangeLabel: 'กำหนดเอง',
                daysOfWeek: ['อ', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
                monthNames: [
                    'มกราคม',
                    'กุมภาพันธ์',
                    'มีนาคม',
                    'เมษายน',
                    'พฤษภาคม',
                    'มิถุนายน',
                    'กรกฎาคม',
                    'สิงหาคม',
                    'กันยายน',
                    'ตุลาคม',
                    'พฤศจิกายน',
                    'ธันวาคม',
                ],
                firstDay: 1, // Start with Monday
            },
        });
    });

    // Use jQuery for simplicity
    $(document).ready(function() {
        // Add change event listener to check1
        $('.enableCheck').change(function() {
            // Enable or disable checkboxes with class checkdate based on the checked status of check1
            $('.checkdate').prop('disabled', !$(this).prop('checked'));
        });
    });
</script>
</body>

@endsection

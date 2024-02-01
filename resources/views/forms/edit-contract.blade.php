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
            <h2 class="my-3">Edit Contract</h2>
            <div class="card p-4">
                @if ($contract->type === 'creditor')
                    <p class="fs-2">สัญญา-เจ้าหนี้</p>
                @elseif ($contract->type === 'debtor')
                    <p class="fs-2">สัญญา-ลูกหนี้</p>
                @elseif ($contract->type === 'outdoor')
                    <p class="fs-2">Out Door</p>
                @endif

                <form action="{{ route('update-contract', ['cid' => $contract->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    @if ($contract->type === 'creditor')
                        <input type="hidden" name="contact_type" value="creditor">
                    @elseif ($contract->type === 'debtor')
                        <input type="hidden" name="contact_type" value="debtor">
                    @elseif ($contract->type === 'outdoor')
                        <input type="hidden" name="contact_type" value="outdoor">
                    @endif

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="cont_bnum" class="col-form-label">เลขที่หนังสือ</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="cont_bnum" id="cont_bnum" value="{{ $contract->book_num }}" class="form-control" readonly required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="cont_title" class="col-form-label">เรื่อง</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="cont_title" id="cont_title" value="{{ $contract->title }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="cont_party" class="col-form-label">คู่สัญญา</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="cont_party" id="cont_party" value="{{ $contract->party }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="dateRange" class="col-form-label">ระยะเวลาสัญญา</label>
                        </div>
                        <div class="col-8">
                        <input type="text" name="dateRange" id="dateRange" class="form-control dateRangePicker" value="{{ $contract->time_range }}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="recurring" class="col-form-label">การเกิดซ้ำ</label>
                        </div>
                        <div class="col-8">
                            <div class="d-flex">
                                <div class="form-check text-start mx-4">
                                    <input class="form-check-input enableCheck" type="checkbox" name="recur" value="1" id="check1" {{ optional($contract->recurring)['enable'] ? 'checked' : ''}}>
                                    <label class="form-check-label" for="check1">
                                        เปิด
                                    </label>
                                </div>
                                <div class="form-check text-start mx-2">
                                    <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="0" id="check2" {{ str_contains(optional($contract->recurring)['recur_date'], '0') ? 'checked' : ''}} disabled>
                                    <label class="form-check-label" for="check8">
                                        อา
                                    </label>
                                </div>
                                <div class="form-check text-start mx-2">
                                    <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="1" id="check3" {{ str_contains(optional($contract->recurring)['recur_date'], '1') ? 'checked' : ''}} disabled>
                                    <label class="form-check-label" for="check2">
                                        จ
                                    </label>
                                </div>
                                <div class="form-check text-start mx-2">
                                    <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="2" id="check4" {{ str_contains(optional($contract->recurring)['recur_date'], '2') ? 'checked' : ''}} disabled>
                                    <label class="form-check-label" for="check3">
                                        อ
                                    </label>
                                </div>
                                <div class="form-check text-start mx-2">
                                    <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="3" id="check5" {{ str_contains(optional($contract->recurring)['recur_date'], '3') ? 'checked' : ''}} disabled>
                                    <label class="form-check-label" for="check4">
                                        พ
                                    </label>
                                </div>
                                <div class="form-check text-start mx-2">
                                    <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="4" id="check6" {{ str_contains(optional($contract->recurring)['recur_date'], '4') ? 'checked' : ''}} disabled>
                                    <label class="form-check-label" for="check5">
                                        พฤ
                                    </label>
                                </div>
                                <div class="form-check text-start mx-2">
                                    <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="5" id="check7" {{ str_contains(optional($contract->recurring)['recur_date'], '5') ? 'checked' : ''}} disabled>
                                    <label class="form-check-label" for="check6">
                                        ศ
                                    </label>
                                </div>
                                <div class="form-check text-start mx-2">
                                    <input class="form-check-input checkdate" type="checkbox" name="recurring[]" value="6" id="check8" {{ str_contains(optional($contract->recurring)['recur_date'], '6') ? 'checked' : ''}} disabled>
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
                            <textarea class="form-control" name="cont_note" id="cont_note" rows="3">{!! $contract->note !!}</textarea>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        if ($('.enableCheck').is(':checked')) {
            $('.checkdate').prop('disabled', false);
        } else {
            $('.checkdate').prop('disabled', true);
        }

        $('.enableCheck').change(function() {
            // Enable or disable checkboxes with class checkdate based on the checked status of check1
            $('.checkdate').prop('disabled', !$(this).prop('checked'));
        });
    });
</script>
</body>

@endsection

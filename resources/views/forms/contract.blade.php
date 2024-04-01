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

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <p class="mb-0">{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_bnum" class="col-form-label"><span class="text-danger">*</span>เลขที่หนังสือ</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_bnum" id="cont_bnum" value="{{ 'CT-CRE' . str_pad($ctcre_count + 1 , 3, '0', STR_PAD_LEFT) . "/" . (now()->year + 543)}}" class="form-control" readonly required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="proj_code" class="col-form-label">โครงการ</label>
                                </div>
                                <div class="col-8">

                                    <!-- Options -->
                                    <select id="selectprojc" name="proj_code" required>
                                        @foreach ($projCodes as $projCode)
                                            <option value="{{ $projCode->id }}">{{ $projCode->project_code }} : {{ $projCode->project_name }}</option>
                                        @endforeach
                                    </select>
                                    <script>
                                        new SlimSelect({
                                            select: '#selectprojc',
                                            settings: {
                                                closeOnSelect: true,
                                            },
                                        })
                                    </script>
                                </div>
                                @can('addProjCode')
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-success" id="addProjCodebtn" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i></button>

                                    </div>
                                @endcan
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_title" class="col-form-label"><span class="text-danger">*</span>เรื่อง</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_title" id="cont_title" class="form-control bg-white" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_party" class="col-form-label"><span class="text-danger">*</span>คู่สัญญา</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_party" id="cont_party" class="form-control bg-white" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_budget" class="col-form-label">จำนวนเงิน</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_budget" id="cont_budget" oninput="formatNumber(this)" value="0" maxlength="11" class="form-control bg-white" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="dateRange" class="col-form-label"><span class="text-danger">*</span>ระยะเวลาสัญญา</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="dateRange" id="dateRange" class="form-control dateRangePicker bg-white" value="" required>
                                    <p class="text-warning" style="font-size: 15px">*หากบันทึกแล้วจะไม่สามารถแก้ไขได้</p>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <input class="form-check-input" name="recur_toggle" type="checkbox" value="1" id="recurring-cre">
                                    <label for="recurring-cre" class="col-form-label p-0">การเกิดซ้ำ</label>
                                </div>
                                <div class="col-8" >
                                    <p class="recur_text-cre text-start" ><span class="badge text-bg-primary">ไม่มีการเกิดซ้ำ</span></p>
                                    <div class="recur_input-cre" style="display: none;">
                                        <div class="row g-3 mb-3 d-flex justify-content-center">

                                            <div class="col-auto">
                                                <label for="selectday" class="col-form-label"><span class="text-danger">*</span>วันที่</label>
                                            </div>
                                            <div class="col-8">
                                                <!-- Options -->
                                                <select id="selectday" name="recur_d[]" multiple>
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                <script>
                                                    new SlimSelect({
                                                        select: '#selectday',
                                                        settings: {
                                                            minSelected: 0,
                                                            maxSelected: 31,
                                                            hideSelected: true,
                                                            closeOnSelect: false,
                                                            placeholderText: 'เลือกวันที่',
                                                        },
                                                    })
                                                </script>
                                            </div>
                                        </div>

                                        <div class="row g-3 mb-3 d-flex justify-content-center">
                                            <div class="col-auto">
                                                <label for="selectmonth" class="col-form-label"><span class="text-danger">*</span>เดือน</label>
                                            </div>
                                            <div class="col-8">
                                                <!-- Options -->
                                                <select id="selectmonth" name="recur_m[]" multiple>
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        @php
                                                            $date = \Carbon\Carbon::create()->day(1)->month($i)->year(2022); // Replace 2022 with the desired year
                                                            $thaiMonth = $date->locale('th')->monthName;
                                                        @endphp
                                                        <option value="{{ $i }}">{{ $thaiMonth }}</option>
                                                    @endfor
                                                </select>
                                                <script>
                                                    new SlimSelect({
                                                        select: '#selectmonth',
                                                        settings: {
                                                            minSelected: 0,
                                                            maxSelected: 31,
                                                            hideSelected: true,
                                                            closeOnSelect: false,
                                                            placeholderText: 'เลือกเดือน',
                                                        },
                                                    })
                                                </script>
                                            </div>
                                        </div>

                                        <div class="row g-3 mb-3 d-flex justify-content-center">
                                            <div class="col-auto">
                                                <label for="recur_y" class="col-form-label">ทุก</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="number" name="recur_y" id="recur_y" value="1" min="1" max="100" class="form-control bg-white">
                                            </div>
                                            <div class="col-auto">
                                                <p>ปี</p>
                                            </div>
                                        </div>

                                        <div class="row g-3 mb-3 d-flex justify-content-center">
                                            <div class="col-auto">
                                                <label for="recur_count" class="col-form-label">จำนวน</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="number" name="recur_count" id="recur_count" placeholder="ไม่จำเป็นต้องกรอก"  min="1" max="100" class="form-control bg-white">
                                            </div>
                                            <div class="col-auto">
                                                <p>ครั้ง , งวด</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_note" class="col-form-label">หมายเหตุ</label>
                                </div>
                                <div class="col-8">
                                    <textarea class="form-control bg-white" name="cont_note" id="cont_note" rows="3"></textarea>
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
                                    <label for="cont_bnum" class="col-form-label"><span class="text-danger">*</span>เลขที่หนังสือ</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_bnum" id="cont_bnum" value="{{ 'CT-DEB' . str_pad($ctdeb_count + 1, 3, '0', STR_PAD_LEFT) . "/" . (now()->year + 543)}}" class="form-control" readonly required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="proj_code" class="col-form-label">โครงการ</label>
                                </div>
                                <div class="col-8">

                                    <!-- Options -->
                                    <select id="selectprojc2" name="proj_code" required>
                                        @foreach ($projCodes as $projCode)
                                            <option value="{{ $projCode->id }}">{{ $projCode->project_code }} : {{ $projCode->project_name }}</option>
                                        @endforeach
                                    </select>
                                    <script>
                                        new SlimSelect({
                                            select: '#selectprojc2',
                                            settings: {
                                                closeOnSelect: true,
                                            },
                                        })
                                    </script>
                                </div>
                                @can('addProjCode')
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-success" id="addProjCodebtn" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i></button>

                                    </div>
                                @endcan
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_title" class="col-form-label"><span class="text-danger">*</span>เรื่อง</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_title" id="cont_title" class="form-control bg-white" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_party" class="col-form-label"><span class="text-danger">*</span>คู่สัญญา</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_party" id="cont_party" class="form-control bg-white" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_budget" class="col-form-label">จำนวนเงิน</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_budget" id="cont_budget" oninput="formatNumber(this)" value="0" maxlength="11" class="form-control bg-white" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="dateRange" class="col-form-label"><span class="text-danger">*</span>ระยะเวลาสัญญา</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="dateRange" id="dateRange2" class="form-control dateRangePicker bg-white" value="" required>
                                    <p class="text-warning" style="font-size: 15px">*หากบันทึกแล้วจะไม่สามารถแก้ไขได้</p>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <input class="form-check-input" name="recur_toggle" type="checkbox" value="1" id="recurring-deb">
                                    <label for="recurring-deb" class="col-form-label p-0">การเกิดซ้ำ</label>
                                </div>
                                <div class="col-8">
                                    <p class="recur_text-deb text-start" ><span class="badge text-bg-primary">ไม่มีการเกิดซ้ำ</span></p>
                                    <div class="recur_input-deb" style="display: none;">
                                        <div class="row g-3 mb-3 d-flex justify-content-center">
                                            <div class="col-auto">
                                                <label for="selectday2" class="col-form-label"><span class="text-danger">*</span>วันที่</label>
                                            </div>
                                            <div class="col-8">
                                                <!-- Options -->
                                                <select id="selectday2" name="recur_d[]" multiple >
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                <script>
                                                    new SlimSelect({
                                                        select: '#selectday2',
                                                        settings: {
                                                            minSelected: 0,
                                                            maxSelected: 31,
                                                            hideSelected: true,
                                                            closeOnSelect: false,
                                                            placeholderText: 'เลือกวันที่',
                                                        },
                                                    })
                                                </script>
                                            </div>
                                        </div>

                                        <div class="row g-3 mb-3 d-flex justify-content-center">
                                            <div class="col-auto">
                                                <label for="selectmonth2" class="col-form-label"><span class="text-danger">*</span>เดือน</label>
                                            </div>
                                            <div class="col-8">
                                                <!-- Options -->
                                                <select id="selectmonth2" name="recur_m[]" multiple >
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        @php
                                                            $date = \Carbon\Carbon::create()->day(1)->month($i)->year(2022); // Replace 2022 with the desired year
                                                            $thaiMonth = $date->locale('th')->monthName;
                                                        @endphp
                                                        <option value="{{ $i }}">{{ $thaiMonth }}</option>
                                                    @endfor
                                                </select>
                                                <script>
                                                    new SlimSelect({
                                                        select: '#selectmonth2',
                                                        settings: {
                                                            minSelected: 0,
                                                            maxSelected: 31,
                                                            hideSelected: true,
                                                            closeOnSelect: false,
                                                            placeholderText: 'เลือกเดือน',
                                                        },
                                                    })
                                                </script>
                                            </div>
                                        </div>

                                        <div class="row g-3 mb-3 d-flex justify-content-center">
                                            <div class="col-auto">
                                                <label for="recur_y" class="col-form-label">ทุก</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="number" name="recur_y" id="recur_y" value="1" min="1" max="100" class="form-control bg-white">
                                            </div>
                                            <div class="col-auto">
                                                <p>ปี</p>
                                            </div>
                                        </div>

                                        <div class="row g-3 mb-3 d-flex justify-content-center">
                                            <div class="col-auto">
                                                <label for="recur_count" class="col-form-label">จำนวน</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="number" name="recur_count" id="recur_count" placeholder="ไม่จำเป็นต้องกรอก"  min="1" max="100" class="form-control bg-white">
                                            </div>
                                            <div class="col-auto">
                                                <p>ครั้ง , งวด</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_note" class="col-form-label">หมายเหตุ</label>
                                </div>
                                <div class="col-8">
                                    <textarea class="form-control bg-white" name="cont_note" id="cont_note" rows="3"></textarea>
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
                                    <label for="cont_bnum" class="col-form-label"><span class="text-danger">*</span>เลขที่หนังสือ</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_bnum" id="cont_bnum" value="{{ 'OTD' . str_pad($ctotd_count + 1, 3, '0', STR_PAD_LEFT) . "/" . (now()->year + 543)}}" class="form-control" readonly required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="proj_code" class="col-form-label">โครงการ</label>
                                </div>
                                <div class="col-8">

                                    <!-- Options -->
                                    <select id="selectprojc3" name="proj_code" required>
                                        @foreach ($projCodes as $projCode)
                                            <option value="{{ $projCode->id }}">{{ $projCode->project_code }} : {{ $projCode->project_name }}</option>
                                        @endforeach
                                    </select>
                                    <script>
                                        new SlimSelect({
                                            select: '#selectprojc3',
                                            settings: {
                                                closeOnSelect: true,
                                            },
                                        })
                                    </script>
                                </div>
                                @can('addProjCode')
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-success" id="addProjCodebtn" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i></button>

                                    </div>
                                @endcan
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_title" class="col-form-label"><span class="text-danger">*</span>เรื่อง</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_title" id="cont_title" class="form-control bg-white" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_party" class="col-form-label"><span class="text-danger">*</span>คู่สัญญา</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_party" id="cont_party" class="form-control bg-white" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_budget" class="col-form-label">จำนวนเงิน</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cont_budget" id="cont_budget" oninput="formatNumber(this)" value="0" maxlength="11" class="form-control bg-white" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="dateRange" class="col-form-label"><span class="text-danger">*</span>ระยะเวลาสัญญา</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="dateRange" id="dateRange3" class="form-control bg-white dateRangePicker" value="" required>
                                    <p class="text-warning" style="font-size: 15px">*หากบันทึกแล้วจะไม่สามารถแก้ไขได้</p>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <input class="form-check-input" name="recur_toggle" type="checkbox" value="1" id="recurring-otd">
                                    <label for="recurring-otd" class="col-form-label p-0">การเกิดซ้ำ</label>
                                </div>
                                <div class="col-8">
                                    <p class="recur_text-otd text-start" ><span class="badge text-bg-primary">ไม่มีการเกิดซ้ำ</span></p>
                                    <div class="recur_input-otd" style="display: none;">
                                        <div class="row g-3 mb-3 d-flex justify-content-center">
                                            <div class="col-auto">
                                                <label for="selectday3" class="col-form-label"><span class="text-danger">*</span>วันที่</label>
                                            </div>
                                            <div class="col-8">
                                                <!-- Options -->
                                                <select id="selectday3" name="recur_d[]" multiple>
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                <script>
                                                    new SlimSelect({
                                                        select: '#selectday3',
                                                        settings: {
                                                            minSelected: 0,
                                                            maxSelected: 31,
                                                            hideSelected: true,
                                                            closeOnSelect: false,
                                                            placeholderText: 'เลือกวันที่',
                                                        },
                                                    })
                                                </script>
                                            </div>
                                        </div>

                                        <div class="row g-3 mb-3 d-flex justify-content-center">
                                            <div class="col-auto">
                                                <label for="selectmonth3" class="col-form-label"><span class="text-danger">*</span>เดือน</label>
                                            </div>
                                            <div class="col-8">
                                                <!-- Options -->
                                                <select id="selectmonth3" name="recur_m[]" multiple >
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        @php
                                                            $date = \Carbon\Carbon::create()->day(1)->month($i)->year(2022); // Replace 2022 with the desired year
                                                            $thaiMonth = $date->locale('th')->monthName;
                                                        @endphp
                                                        <option value="{{ $i }}">{{ $thaiMonth }}</option>
                                                    @endfor
                                                </select>
                                                <script>
                                                    new SlimSelect({
                                                        select: '#selectmonth3',
                                                        settings: {
                                                            minSelected: 0,
                                                            maxSelected: 31,
                                                            hideSelected: true,
                                                            closeOnSelect: false,
                                                            placeholderText: 'เลือกเดือน',
                                                        },
                                                    })
                                                </script>
                                            </div>
                                        </div>

                                        <div class="row g-3 mb-3 d-flex justify-content-center">
                                            <div class="col-auto">
                                                <label for="recur_y" class="col-form-label">ทุก</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="number" name="recur_y" id="recur_y" value="1" min="1" max="100" class="form-control bg-white">
                                            </div>
                                            <div class="col-auto">
                                                <p>ปี</p>
                                            </div>
                                        </div>

                                        <div class="row g-3 mb-3 d-flex justify-content-center">
                                            <div class="col-auto">
                                                <label for="recur_count" class="col-form-label">จำนวน</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="number" name="recur_count" id="recur_count" placeholder="ไม่จำเป็นต้องกรอก"  min="1" max="100" class="form-control bg-white">
                                            </div>
                                            <div class="col-auto">
                                                <p>ครั้ง , งวด</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-3 d-flex justify-content-center">
                                <div class="col-auto">
                                    <label for="cont_note" class="col-form-label">หมายเหตุ</label>
                                </div>
                                <div class="col-8">
                                    <textarea class="form-control bg-white" name="cont_note" id="cont_note" rows="3"></textarea>
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

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('add-projcode') }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่ม Project Code</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <input type="text" name="projcode" class="form-control mb-2" id="projcode" placeholder="กรอก Project Code ที่ต้องการเพิ่ม" required>
                                            <input type="text" name="projname" class="form-control mb-2" id="projname" placeholder="กรอก Project Name" required>
                                            <p class="text-warning" style="font-size: 12px">*หลังจากบันทึกแล้ว กรุณา roload หน้าเว็บ</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        <button type="submit" class="btn btn-primary">บันทึก</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
    function formatNumber(input) {
        // Remove non-numeric characters
        let cleanedValue = input.value.replace(/[^0-9]/g, '');

        // Convert the cleaned value to a number
        let value = parseFloat(cleanedValue);

        // Set the default or minimum value if empty or NaN
        if (isNaN(value) || cleanedValue === '') {
            value = 0; // Set to default or minimum value
        }

        // Format the number with commas
        input.value = value.toLocaleString('en-US');
    }

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

        $('.dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('.dateRangePicker').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });

    // Use jQuery for simplicity
    $(document).ready(function() {
        // Add change event listener to check1
        $('.enableCheck').change(function() {
            // Enable or disable checkboxes with class checkdate based on the checked status of check1
            $('.checkdate').prop('disabled', !$(this).prop('checked'));
        });

        $('#recurring-cre').change(function() {
            if($(this).is(":checked")) {
                $('.recur_input-cre').show();
                $('.recur_text-cre').hide();
                console.log("Checkbox is checked");
            } else {
                $('.recur_input-cre').hide();
                $('.recur_text-cre').show();
                console.log("Checkbox is unchecked");
            }
        });

        $('#recurring-deb').change(function() {
            if($(this).is(":checked")) {
                $('.recur_input-deb').show();
                $('.recur_text-deb').hide();
                console.log("Checkbox is checked");
            } else {
                $('.recur_input-deb').hide();
                $('.recur_text-deb').show();
                console.log("Checkbox is unchecked");
            }
        });

        $('#recurring-otd').change(function() {
            if($(this).is(":checked")) {
                $('.recur_input-otd').show();
                $('.recur_text-otd').hide();
                console.log("Checkbox is checked");
            } else {
                $('.recur_input-otd').hide();
                $('.recur_text-otd').show();
                console.log("Checkbox is unchecked");
            }
        });
    });
</script>
</body>

@endsection

@extends('layouts.app')

<!-- Scripts -->
@vite(['resources/css/table.css', 'resources/js/table.js'])
@section('content')

    <head>
        <!-- Import your CSS file here -->
        <link rel="stylesheet" href="{{ asset('css/form.css') }}">

        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />

    </head>

    <body>
        <?php
            $permis = Auth::user()->role;
            $dpm = Auth::user()->dpm;
            // $teams = json_decode($contract->submit_by) ? json_decode($contract->submit_by) : '';
        ?>
        <div class="container">
            <div class="text-center mb-4 d-flex justify-content-between">
                <h2>รายละเอียดคำขอดำเนินการ</h2>
                @if (($dar_data->stat ?? "-") === 'ผ่านการอนุมัติ')
                    <a href="{{ route('download-dar', ['darid' => $dar_data->id ]) }}"><button type="button" class="btn btn-primary ">Print</button></a>
                @endif
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card h-100">
                        <div class="card-body fs-5">
                            {{-- <p class="px-2 fs-4"><b>เรื่อง:</b> &nbsp; </p>
                            <p class="px-2 mb-0"><b>โครงการ:</b> &nbsp; </p> --}}
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-sm-6"><b>เลขที่:</b> &nbsp; {{ $dar_data->book_num ?? "-" }}</div>
                                    @php
                                        $doc_types = json_decode($dar_data->doc_type ?? []);
                                        // $date = Carbon\Carbon::createFromFormat('d/m/Y', $installment->date)->thaidate();
                                    @endphp
                                    <div class="col-12 col-sm-6"><b>ประเภทเอกสาร:</b> &nbsp; {{ implode(',', $doc_types) ?? "-" }}</div>
                                    <div class="col-12 col-sm-6"><b>ขอเพื่อ:</b> &nbsp; {{ $dar_data->action_type ?? "-" }}</div>
                                    <div class="col-12 col-sm-6"><b>ผู้ถือครองเอกสาร:</b> &nbsp; {{ $dar_data->doc_owner ?? "-" }}</div>
                                    <div class="col-12 col-sm-6"><b>ผู้ลงทะเบียน DAR:</b> &nbsp; {{ optional($dar_data->getUser)->name ?? "-" }}</div>
                                    <div class="col-12 col-sm-6"><b>วันที่ลงทะเบียน:</b> &nbsp; {{ $dar_data->created_at ?? "-" }}</div>
                                    <div class="col-12 col-sm-6"><b>ผู้ขอ:</b> &nbsp; {{ $dar_data->request_by ?? "-" }}</div>
                                    <div class="col-12 col-sm-6"><b>วันที่ขอ:</b> &nbsp; {{ $dar_data->request_at ?? "-" }}</div>
                                    @php
                                        $app = json_decode($dar_data->app);
                                        $ins = json_decode($dar_data->ins);
                                        $appName = $user->firstWhere('id', $app->appId ?? '') ?? [];
                                        $insName = $user->firstWhere('id', $ins->appId ?? '') ?? [];
                                        $note = $app->note ?? '-';
                                        $insnote = $ins->note ?? '-';
                                    @endphp
                                    <div class="col-12 col-sm-6"><b>ผู้ตรวจสอบ:</b> &nbsp; {{$insName ? $insName->name : '-'}}</div>
                                    <div class="col-12 col-sm-6"><b>วันที่ตรวจสอบ:</b> &nbsp; {{ $ins->date ?? "-" }}</div>
                                    <div class="col-12 col-sm-6"><b>ผู้อนุมัติ:</b> &nbsp; {{$appName ? $appName->name : '-'}}</div>
                                    <div class="col-12 col-sm-6"><b>วันที่อนุมัติ:</b> &nbsp; {{ $app->date ?? "-" }}</div>
                                    <div class="col-12 col-sm-6"><b>สถานะ:</b> &nbsp; {{ $dar_data->stat ?? "-" }}</div>
                                    {{-- @php
                                    $dates = explode(" - ", $contract->time_range);

                                    // Create Carbon instances for the start and end dates
                                    $startDate = Carbon\Carbon::createFromFormat('d/m/Y', $dates[0]);
                                    $endDate = Carbon\Carbon::createFromFormat('d/m/Y', $dates[1]);
                                    $diffDate = $endDate->diff($startDate);
                              @endphp
                              <div class="col-12"><b>ระยะเวลา:</b> &nbsp; <u>{{ $contract->time_range }} ( {{ $diffDate->y ? $diffDate->y . 'ปี' : '' }} {{ $diffDate->m ? $diffDate->m . 'เดือน' : '' }} {{ $diffDate->d ? $diffDate->d . 'วัน' : '' }} )</u></div>
                              <div class="col-12 col-sm-6"><b>จำนวนงวด:</b> &nbsp; <u>{{ count($installments ?? []) }}</u> งวด</div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="p-3">
                <table class="table table-hover">
                    <thead class="table-dark text-center">
                        <tr>
                            <th scope="col" rowspan="2">ลำดับที่</th>
                            <th scope="col" rowspan="2">หมายเลขเอกสาร</th>
                            <th scope="col" rowspan="2">ชื่อเอกสาร</th>
                            <th scope="col" colspan="2">สถานะหลังดำเนินการ</th>
                        </tr>
                        <tr>
                            <th scope="col">วันที่เริ่มใช้</th>
                            <th scope="col">แก้ไขครั้งที่</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($docs_list ?? [] as $index => $doc)
                            <tr>
                                <th class="text-center" scope="row">{{ $index + 1 }}</th>
                                <th class="text-center">{{ $doc['book_num'] }}</th>
                                <th>{{ $doc['title'] }}</th>
                                @php
                                    $app_list = json_decode($doc['approve'], true);
                                    $app_date = $app_list ? Carbon\Carbon::parse($app_list['date'] ?? null)->format('d/m/Y') : '-';
                                @endphp
                                <th class="text-center">{{ $app_date }}</th>
                                <th class="text-center">{{ $doc['edit_count'] + 1 }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
        <script type="text/javascript" src="https://fastly.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <!-- rrule lib -->
        <script src='https://fastly.jsdelivr.net/npm/rrule@2.6.4/dist/es5/rrule.min.js'></script>

        <!-- fullcalendar bundle -->
        <script src='https://fastly.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

        <!-- the rrule-to-fullcalendar connector. must go AFTER the rrule lib -->
        <script src='https://fastly.jsdelivr.net/npm/@fullcalendar/rrule@6.1.11/index.global.min.js'></script>
        <script>

        </script>
        <style>
            .deleteBtn:hover {
                background-color: red;
                color: white;
            }
        </style>
    </body>
@endsection

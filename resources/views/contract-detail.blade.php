@extends('layouts.app')

<!-- Scripts -->
@vite(['resources/css/table.css' , 'resources/js/table.js'])
@section('content')
<head>
    <!-- Import your CSS file here -->
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">

    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet"/>

</head>
<body>
<?php $permis = Auth::user()->role ;
      $dpm = Auth::user()->dpm;
?>
    <div class="container">
        <div class="text-center mb-4"><h2>รายละเอียดสัญญา</h2></div>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card h-100">
                    <div class="card-body fs-5">
                        <p class="px-2 fs-4"><b>เรื่อง:</b> &nbsp; {{ $contract->title }}</p>
                        <p class="px-2 mb-0"><b>โครงการ:</b> &nbsp; <u>{{ optional($contract->getProject)->project_code }}</u> : {{ optional($contract->getProject)->project_name }}</p>
                        <div class="container">
                            <div class="row">
                              <div class="col-12 col-sm-6"><b>เลขที่:</b> &nbsp; <u>{{ $contract->book_num }}</u></div>
                              <div class="col-12 col-sm-6"><b>ประเภท:</b> &nbsp;
                                <u>
                                @switch($contract->type)
                                    @case('creditor')
                                        สัญญา-เจ้าหนี้
                                        @break
                                    @case('debtor')
                                        สัญญา-ลูกหนี้
                                        @break
                                    @case('outdoor')
                                        Out Door
                                        @break
                                    @default
                                        ไม่ทราบ
                                        @break
                                @endswitch
                                </u>
                              </div>
                              <div class="col-12 col-sm-6"><b>คู่สัญญา:</b> &nbsp; <u>{{ $contract->party }}</u></div>
                              <div class="col-12 col-sm-6"><b>จำนวนเงิน:</b> &nbsp; <u>{{ number_format($contract->budget) }}</u> บาท</div>
                              @php
                                    $dates = explode(" - ", $contract->time_range);

                                    // Create Carbon instances for the start and end dates
                                    $startDate = Carbon\Carbon::createFromFormat('d/m/Y', $dates[0]);
                                    $endDate = Carbon\Carbon::createFromFormat('d/m/Y', $dates[1]);
                                    $diffDate = $endDate->diff($startDate);
                              @endphp
                              <div class="col-12"><b>ระยะเวลา:</b> &nbsp; <u>{{ $contract->time_range }} ( {{ $diffDate->y ? $diffDate->y . 'ปี' : '' }} {{ $diffDate->m ? $diffDate->m . 'เดือน' : '' }} {{ $diffDate->d ? $diffDate->d . 'วัน' : '' }} )</u></div>
                              <div class="col-12 col-sm-6"><b>จำนวนงวด:</b> &nbsp; <u>{{ count($installments ?? []) }}</u> งวด</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center">ไฟล์ที่เกี่ยวข้อง</h4>

                        <div class="mb-3">
                            @foreach ($contract->files ?? [] as $index => $file)

                                @php
                                    $file_saved = App\Models\TemporaryFile::find($file);
                                    $teams = json_decode($contract->submit_by) ? json_decode($contract->submit_by) : [];
                                @endphp
                                @if ($file_saved)
                                    <div class="d-flex">
                                        <p class="mb-0">{{ $index + 1 }}. <a href="/files/contract/{{ $file_saved->file }}" target="_BLANK">{{ $file_saved ? $file_saved->originalName : 'Unknow'}} <span style="font-size: 10px">( size: {{ $file_saved ? $file_saved->size_mb : '-' }} MB )</span></a></p>
                                        @if ( Auth::user()->hasRole(['admin', 'ceo']) || ((Auth::user())->id == (is_array($teams) ? $teams[0] : $teams)))
                                            <a href="{{ route('delContFile', ['cid' => $contract->id, 'fid' => $file]) }}" class="btn btn-sm deleteBtn"><i class="bi bi-x-lg" style="font-size: 10px"></i></a>
                                        @endif
                                    </div>
                                @else
                                    <div class="d-flex">
                                        <p class="mb-0">{{ $index + 1 }}. <a href="/files/contract/{{ $file }}" target="_BLANK">{{ $file }} <span style="font-size: 10px">( size: - MB )</span></a></p>
                                        @if ( Auth::user()->hasRole(['admin', 'ceo']) || ((Auth::user())->id == (is_array($teams) ? $teams[0] : $teams)))
                                            <a href="{{ route('delContFile2', ['cid' => $contract->id, 'fname' => $file]) }}" class="btn btn-sm deleteBtn"><i class="bi bi-x-lg" style="font-size: 10px"></i></a>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div>
                            <form action="{{ route('cont-savefile', ['cid' => $contract->id]) }}" method="post">
                                @csrf
                                <div class="d-flex justify-content-between mb-2">
                                    <p class="mb-0 fw-bold">Upload more file</p>
                                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                                </div>
                                <input type="file" class="filepond" id="myFile" data-max-file-size="10MB" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        @if ($contract->recurring)
            <div class="row">
                <div class="text-center my-3"><h2>รายละเอียดงวดงาน</h2></div>
                <livewire:installment :cont="$contract->id" />
            </div>
            <hr>
        @endif
        <div class="row">
            <div class="container">
                <div class="text-center mb-4"><h2>Calendar</h2></div>

                <div class="bg-white p-4" style="position: relative; z-index: 0;">
                    <div id='calendar'></div>
                </div>

            </div>

            <div class="modal fade" id="eventModal" tabindex="-1">
                <div class="modal-dialog ">
                  <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body container " id="eventModalBody"></div>
                  </div>
                </div>
            </div>
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
        $(document).ready(function() {
            $('[id^="myFile"]').each(function(index, element) {
                FilePond.create(element, {
                    allowMultiple: true,
                    name: 'cont_files[]',
                });
            });
        });

        FilePond.setOptions({
            server: {
                process: '/contract/file-upload',
                revert: '/contract/file-delete',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
        });

        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'multiMonthYear,dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: {!! json_encode($events) !!},
                // events: [
                //     {
                //     title: 'The Title',
                //     start: '2024-09-01',
                //     end: '2024-09-02'
                //     }
                // ]
                eventClick: function(info) {
                    // Display event details in a Bootstrap modal
                    $('#eventModalLabel').text(info.event.id);
                    $('#eventModalBody').html(
                    `
                        <h5 class="text-center fw-bold">${info.event.title} (งวดที่ ${info.event.extendedProps.periot})</h5>
                        <div class="col">โครงการ: <u>${info.event.extendedProps.proj}</u></div>
                        <div class="row">
                            <div class="col">คู่สัญญา: <u>${info.event.extendedProps.party}</u></div>
                            <div class="col">ประเภทสัญญา: <u>${info.event.groupId}</u></div>
                        </div>
                        <div class="row">
                            <div class="col">วันที่เริ่ม: <u>${info.event.startStr}</u></div>
                            <div class="col">วันที่สิ้นสุด: <u>${info.event.endStr ? info.event.endStr : info.event.startStr}</u></div>
                        </div>
                        <p>หมายเหตุ: ${info.event.extendedProps.description}</p>
                    `
                    );
                    $('#eventModal').modal('show');
                    console.log(info.event)
                },
            });

            calendar.setOption('locale', 'th');
            calendar.render();
        });
    </script>
    <style>
        .deleteBtn:hover {
            background-color: red;
            color: white;
        }
    </style>
</body>
@endsection

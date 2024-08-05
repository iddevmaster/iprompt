@extends('layouts.app')

<?php $permis = Auth::user()->role ;
      $dpm = Auth::user()->dpm;
?>
@section('content')
<body>
    @can('CONT')
        @php
            $installments = App\Models\Installment::all();
            $currentDate = Carbon\Carbon::now();
            $alert_ins = [];
            foreach ($installments ?? [] as $install) {
                $targetDate = Carbon\Carbon::createFromFormat('d/m/Y', $install->date);
                $diffStatus = $currentDate->diff($targetDate);
                $diff = $currentDate->diffInDays($targetDate);
                if ($diff >= 0 && $diff < 30 && $install->status !== 2) {
                    $alert_ins[] = $install;
                    if ($diffStatus->invert) {
                        $install->status = 3;
                        $install->save();
                    } else {
                        $install->status = 1;
                        $install->save();
                    }
                }
            }
        @endphp
        @if (count($alert_ins ?? []) > 0)
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">การแจ้งเตือน</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>คุณมีสัญญา <span class="badge text-bg-danger">{{ count($alert_ins ?? []) }}</span> ฉบับที่ยังไม่ได้ดำเนินการ</p>
                            @foreach ($alert_ins as $index => $install)
                                @php
                                    $targetDate = Carbon\Carbon::createFromFormat('d/m/Y', $install->date);
                                    $diff = $currentDate->diffInDays($targetDate);
                                @endphp
                                @switch($install->status)
                                    @case(1)
                                        <a class="link-underline link-underline-opacity-0" href="{{ route('contract-detail', ['cid' => $install->getCont->id ?? '-']) }}">
                                            <div class="d-flex justify-content-between alert alert-primary" role="alert">
                                                <div>
                                                    <p class="mb-0 text-wrap text-break border-end px-2 flex-fill border-black">{{ optional($install->getCont)->book_num }} : {{ optional($install->getCont)->title }} <span class="badge text-bg-primary"><i class="bi bi-hourglass-split" style="font-size: 14px"></i> รอดำเนินการ</span></p>
                                                </div>
                                                <p class="mb-0 text-nowrap align-self-center px-2"><i class="bi bi-hourglass-split" style="font-size: 20px"></i> {{ $diff }} วัน</p>
                                            </div>
                                        </a>
                                        @break
                                    @case(3)
                                        <a class="link-underline link-underline-opacity-0" href="{{ route('contract-detail', ['cid' => $install->getCont->id ?? '-']) }}">
                                            <div class="d-flex justify-content-between alert alert-warning" role="alert">
                                                <div>
                                                    <p class="mb-0 text-wrap text-break border-end px-2 flex-fill border-black">{{ optional($install->getCont)->book_num }} : {{ optional($install->getCont)->title }} <span class="badge text-bg-warning"><i class="bi bi-exclamation-circle" style="font-size: 14px"></i> เกินกำหนด</span></p>
                                                </div>
                                                <p class="mb-0 text-nowrap align-self-center px-2"><i class="bi bi-hourglass-split" style="font-size: 20px"></i> {{ $diff }} วัน</p>
                                            </div>
                                        </a>
                                        @break
                                    @default
                                        -
                                @endswitch
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endcan


    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-5 d-flex justify-content-center">
                <div class="head-name my-5">
                    <p>I-Prompt</p>
                </div>
            </div>
            <!-- create doc card -->
            <div class="col-md-8 mb-5">
                <div class="card">
                    <div class="card-header">{{ __('Create Documents - สร้างเอกสาร') }}</div>

                    <div class="card-body text-center">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row row-cols-2 row-cols-sm-3 row-cols-lg-4 row-cols-xxl-6 mb-2 border-bottom">
                            @can('cMOU')
                            <div class="col">
                                <a class="a-tag" href="{{ route('mouForm') }}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/MOU.png') }}" alt="" height="50px">
                                        <p class="icon-title">บันทึกความร่วมมือ</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('cPOL')
                            <div class="col">
                                <a class="a-tag" href="{{ route('policyForm') }}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/Policy.png') }}" alt="" height="50px">
                                        <p class="icon-title">นโยบาย</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('cANNO')
                            <div class="col">
                                <a class="a-tag" href="{{ route('annoForm') }}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/Announce.png') }}" alt="" height="50px">
                                        <p class="icon-title">ประกาศ</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('cPRO')
                            <div class="col">
                                <a class="a-tag" href="{{ route('projForm') }}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/Project.png') }}" alt="" height="50px">
                                        <p class="icon-title">โครงการ</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('cSOP')
                            <div class="col">
                                <a class="a-tag" href="{{ route('sopForm') }}">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-arrow-return-right"></i>
                                        <p class="icon-title">ระเบียบการปฏิบัติงาน</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('cWI')
                            <div class="col">
                                <a class="a-tag" href="{{ route('wiForm') }}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/WI.png') }}" alt="" height="50px">
                                        <p class="icon-title">ขั้นตอนการปฏิบัติงาน</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('ccheck')
                            <div class="col">
                                <a class="a-tag" href="{{ route('checkForm')}}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/sop.png') }}" alt="" height="50px">
                                        <p class="icon-title">CheckList</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('cCOST')
                            <div class="col">
                                <a class="a-tag" href="{{ route('costForm')}}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/sop.png') }}" alt="" height="50px">
                                        <p class="icon-title">ต้นทุนงาน</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('ccourse')
                            <div class="col">
                                <a class="a-tag" href="{{ route('courseForm')}}">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-book"></i>
                                        <p class="icon-title">Course</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('cmedia')
                            <div class="col">
                                <a class="a-tag" href="{{ route('mediaForm') }}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/Brochure.png') }}" alt="" height="50px">
                                        <p class="icon-title">Brochure</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @role('admin')
                            <div class="col">
                                <a class="a-tag" href="">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/card.png') }}" alt="" height="50px">
                                        <p class="icon-title">กฏบัตร</p>
                                    </div>
                                </a>
                            </div>

                            <div class="col">
                                <a class="a-tag" href="">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/member.png') }}" alt="" height="50px">
                                        <p class="icon-title">Member</p>
                                    </div>
                                </a>
                            </div>
                            @endrole

                            @can('cCONT')
                                <div class="col">
                                    <a class="a-tag" href="{{ route('contract') }}">
                                        <div class="w-100 h-100">
                                            <img src="{{ asset('dist/logo/contrac.png') }}" alt="" height="50px">
                                            <p class="icon-title">สัญญา</p>
                                        </div>
                                    </a>
                                </div>
                            @endcan

                            @role('admin')
                                <div class="col">
                                    <a class="a-tag" href="">
                                        <div class="w-100 h-100">
                                            <img src="{{ asset('dist/logo/iso.png') }}" alt="" height="50px">
                                            <p class="icon-title">ISO</p>
                                        </div>
                                    </a>
                                </div>

                                <div class="col">
                                    <a class="a-tag" href="{{ route('jdForm') }}">
                                        <div class="w-100 h-100">
                                            <img src="{{ asset('dist/logo/JD.png') }}" alt="" height="50px">
                                            <p class="icon-title">รายละเอียดงาน</p>
                                        </div>
                                    </a>
                                </div>

                                <div class="col">
                                    <a class="a-tag" href="">
                                        <div class="w-100 h-100">
                                            <img src="{{ asset('dist/logo/manual.png') }}" alt="" height="50px">
                                            <p class="icon-title">คู่มือพนักงาน</p>
                                        </div>
                                    </a>
                                </div>
                            @endrole
                        </div>
                    </div>
                </div>
            </div>
            <!-- end create doc card -->

            <!-- Table card -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Table Documents - ทะเบียนเอกสาร') }}</div>

                    <div class="card-body text-center">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif


                        <div class="row row-cols-2 row-cols-sm-3 row-cols-lg-4 row-cols-xxl-6 mb-2 border-bottom">
                            @can('MOU')
                            <div class="col col-4">
                                <a class="a-tag" href="{{ route('mouTable') }}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/MOU.png') }}" alt="" height="50px">
                                        <p class="icon-title">บันทึกความร่วมมือ</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('POL')
                            <div class="col col-4">
                                <a class="a-tag" href="/tables/policyTable">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/Policy.png') }}" alt="" height="50px">
                                        <p class="icon-title">นโยบาย</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('ANNO')
                            <div class="col col-4">
                                <a class="a-tag" href="{{ route('annoTable') }}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/Announce.png') }}" alt="" height="50px">
                                        <p class="icon-title">ประกาศ</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('PRO')
                            <div class="col col-4">
                                <a class="a-tag" href="{{ route('projTable') }}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/Project.png') }}" alt="" height="50px">
                                        <p class="icon-title">โครงการ</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('SOP')
                            <div class="col col-4">
                                <a class="a-tag" href="/tables/sopTable">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-arrow-return-right"></i>
                                        <p class="icon-title">ระเบียบการปฏิบัติงาน</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('WI')
                            <div class="col col-4">
                                <a class="a-tag" href="/tables/wiTable">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/WI.png') }}" alt="" height="50px">
                                        <p class="icon-title">ขั้นตอนการปฏิบัติงาน</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('media')
                            <div class="col col-4">
                                <a class="a-tag" href="{{ route('mediaTable')}}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/Brochure.png') }}" alt="" height="50px">
                                        <p class="icon-title">Brochure</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('course')
                            <div class="col col-4">
                                <a class="a-tag" href="{{ route('courseTable')}}">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-book"></i>
                                        <p class="icon-title">Course</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('checklist')
                            <div class="col col-4">
                                <a class="a-tag" href="{{ route('checkTable')}}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/sop.png') }}" alt="" height="50px">
                                        <p class="icon-title">CheckList</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('COST')
                            <div class="col col-4">
                                <a class="a-tag" href="{{ route('costTable')}}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/sop.png') }}" alt="" height="50px">
                                        <p class="icon-title">ต้นทุนงาน</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('CONT')
                                <div class="col col-4">
                                    <a class="a-tag" href="{{ route('contTable') }}">
                                        <div class="w-100 h-100">
                                            <img src="{{ asset('dist/logo/contrac.png') }}" alt="" height="50px">
                                            <p class="icon-title">
                                                สัญญา
                                                @if (count($alert_ins ?? []) > 0)
                                                    <span class="badge text-bg-danger">{{ count($alert_ins) }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            <!-- end Table card -->
        </div>
    </div>

    <!-- Scripts -->
    @vite(['resources/css/home.css' , 'resources/js/home.js'])
    <!-- Include jQuery before Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- <script src="https://fastly.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script type="text/javascript">
        $(window).on('load', function() {
            $('#myModal').modal('show');
        });
    </script>
</body>
@endsection

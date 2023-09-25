@extends('layouts.app')

<?php $permis = Auth::user()->role ;
      $dpm = Auth::user()->dpm;
?>
@section('content')
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-5 d-flex justify-content-center">
                <div class="head-name my-5">
                    <p>I-Prompt</p>
                </div>
            </div>

            @can('create')
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

                            <div class="row mb-2 justify-content-around border-bottom">
                                @can('MOU')
                                <div class="col">
                                    <a class="a-tag" href="{{ route('mouForm') }}">
                                        <div class="w-100 h-100">
                                            <img src="{{ asset('dist/logo/MOU.png') }}" alt="" height="50px">
                                            <p class="icon-title">บันทึกความร่วมมือ</p>
                                        </div>
                                    </a>
                                </div>
                                @endcan

                                @can('POL')
                                <div class="col">
                                    <a class="a-tag" href="{{ route('policyForm') }}">
                                        <div class="w-100 h-100">
                                            <img src="{{ asset('dist/logo/Policy.png') }}" alt="" height="50px">
                                            <p class="icon-title">นโยบาย</p>
                                        </div>
                                    </a>
                                </div>
                                @endcan

                                @can('ANNO')
                                <div class="col">
                                    <a class="a-tag" href="{{ route('annoForm') }}">
                                        <div class="w-100 h-100">
                                            <img src="{{ asset('dist/logo/Announce.png') }}" alt="" height="50px">
                                            <p class="icon-title">ประกาศ</p>
                                        </div>
                                    </a>
                                </div>
                                @endcan
                            </div>


                            <div class="row border-bottom">

                                @can('PRO')
                                <div class="col">
                                    <a class="a-tag" href="{{ route('projForm') }}">
                                        <div class="w-100 h-100">
                                            <img src="{{ asset('dist/logo/Project.png') }}" alt="" height="50px">
                                            <p class="icon-title">โครงการ</p>
                                        </div>
                                    </a>
                                </div>
                                @endcan

                                @can('SOP')
                                <div class="col">
                                    <a class="a-tag" href="{{ route('sopForm') }}">
                                        <div class="w-100 h-100">
                                            <i class="bi bi-arrow-return-right"></i>
                                            <p class="icon-title">ระเบียบการปฏิบัติงาน</p>
                                        </div>
                                    </a>
                                </div>
                                @endcan

                                @can('WI')
                                <div class="col">
                                    <a class="a-tag" href="{{ route('wiForm') }}">
                                        <div class="w-100 h-100">
                                            <img src="{{ asset('dist/logo/WI.png') }}" alt="" height="50px">
                                            <p class="icon-title">ขั้นตอนการปฏิบัติงาน</p>
                                        </div>
                                    </a>
                                </div>
                                @endcan
                            </div>

                            <div class="row ">
                                @can('checklist')
                                <div class="col">
                                    <a class="a-tag" href="{{ route('checkForm')}}">
                                        <div class="w-100 h-100">
                                            <img src="{{ asset('dist/logo/sop.png') }}" alt="" height="50px">
                                            <p class="icon-title">CheckList</p>
                                        </div>
                                    </a>
                                </div>
                                @endcan

                                @can('course')
                                <div class="col">
                                    <a class="a-tag" href="{{ route('courseForm')}}">
                                        <div class="w-100 h-100">
                                            <i class="bi bi-book"></i>
                                            <p class="icon-title">Course</p>
                                        </div>
                                    </a>
                                </div>
                                @endcan

                                @can('media')
                                <div class="col">
                                    <a class="a-tag" href="{{ route('mediaForm') }}">
                                        <div class="w-100 h-100">
                                            <img src="{{ asset('dist/logo/Brochure.png') }}" alt="" height="50px">
                                            <p class="icon-title">Brochure</p>
                                        </div>
                                    </a>
                                </div>
                                @endcan
                            </div>

                            @role('admin')
                            <div class="row ">
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

                                <div class="col">
                                    <a class="a-tag" href="">
                                        <div class="w-100 h-100">
                                            <img src="{{ asset('dist/logo/contrac.png') }}" alt="" height="50px">
                                            <p class="icon-title">Contract</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            @endrole

                            @role('admin')
                            <div class="row ">
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
                            </div>
                            @endrole
                        </div>
                    </div>
                </div>
            @endcan
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


                        <div class="row mb-2 justify-content-around border-bottom">
                            @can('MOU')
                            <div class="col">
                                <a class="a-tag" href="{{ route('mouTable') }}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/MOU.png') }}" alt="" height="50px">
                                        <p class="icon-title">บันทึกความร่วมมือ</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('POL')
                            <div class="col">
                                <a class="a-tag" href="/tables/policyTable">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/Policy.png') }}" alt="" height="50px">
                                        <p class="icon-title">นโยบาย</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('ANNO')
                            <div class="col">
                                <a class="a-tag" href="{{ route('annoTable') }}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/Announce.png') }}" alt="" height="50px">
                                        <p class="icon-title">ประกาศ</p>
                                    </div>
                                </a>
                            </div>
                            @endcan
                        </div>

                        <div class="row">

                            @can('PRO')
                            <div class="col">
                                <a class="a-tag" href="{{ route('projTable') }}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/Project.png') }}" alt="" height="50px">
                                        <p class="icon-title">โครงการ</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('SOP')
                            <div class="col">
                                <a class="a-tag" href="/tables/sopTable">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-arrow-return-right"></i>
                                        <p class="icon-title">ระเบียบการปฏิบัติงาน</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('WI')
                            <div class="col">
                                <a class="a-tag" href="/tables/wiTable">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/WI.png') }}" alt="" height="50px">
                                        <p class="icon-title">ขั้นตอนการปฏิบัติงาน</p>
                                    </div>
                                </a>
                            </div>
                            @endcan
                        </div>
                        <div class="row">
                            @can('media')
                            <div class="col">
                                <a class="a-tag" href="{{ route('mediaTable')}}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/Brochure.png') }}" alt="" height="50px">
                                        <p class="icon-title">Brochure</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('course')
                            <div class="col">
                                <a class="a-tag" href="{{ route('courseTable')}}">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-book"></i>
                                        <p class="icon-title">Course</p>
                                    </div>
                                </a>
                            </div>
                            @endcan

                            @can('checklist')
                            <div class="col">
                                <a class="a-tag" href="{{ route('checkTable')}}">
                                    <div class="w-100 h-100">
                                        <img src="{{ asset('dist/logo/sop.png') }}" alt="" height="50px">
                                        <p class="icon-title">CheckList</p>
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
</body>
@endsection

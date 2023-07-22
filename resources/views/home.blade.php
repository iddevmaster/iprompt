@extends('layouts.app')

<!-- Scripts -->
@vite(['resources/css/home.css' , 'resources/js/home.js'])

@section('content')
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-5 d-flex justify-content-center">
                <div class="head-name my-5">
                    <p>Saraban</p>
                </div>
            </div>

            <!-- create doc card -->
            <div class="col-md-8 mb-5">
                <div class="card">
                    <div class="card-header">{{ __('Create Documents') }}</div>

                    <div class="card-body text-center">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row mb-2 justify-content-around">
                            <div class="col">
                                <a class="a-tag" href="{{ route('mouForm') }}">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-pen"></i>
                                        <p class="icon-title">MOU</p>
                                    </div>
                                </a>  
                            </div>
                            <div class="col">
                                <a class="a-tag" href="{{ route('projForm') }}">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-archive"></i>
                                        <p class="icon-title">โครงการ</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a class="a-tag" href="{{ route('annoForm') }}">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-megaphone"></i>
                                        <p class="icon-title">ประกาศ</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a class="a-tag" href="{{ route('policyForm') }}">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-building-check"></i>
                                        <p class="icon-title">Policy</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a class="a-tag" href="{{ route('sopForm') }}">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-briefcase"></i>
                                        <p class="icon-title">SOP</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a class="a-tag" href="{{ route('wiForm') }}">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-clipboard-check"></i>
                                        <p class="icon-title">WI</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- end create doc card -->

            <!-- Table card -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Table Documents') }}</div>

                    <div class="card-body text-center">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row mb-2 justify-content-around">
                            <div class="col">
                                <a class="a-tag" href="{{ route('mouTable') }}">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-pen"></i>
                                        <p class="icon-title">MOU</p> 
                                    </div>
                                </a> 
                            </div>
                            <div class="col">
                                <a class="a-tag" href="{{ route('projTable') }}">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-archive"></i>
                                        <p class="icon-title">โครงการ</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a class="a-tag" href="{{ route('annoTable') }}">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-megaphone"></i>
                                        <p class="icon-title">ประกาศ</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a class="a-tag" href="/tables/policyTable">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-building-check"></i>
                                        <p class="icon-title">Policy</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a class="a-tag" href="/tables/sopTable">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-briefcase"></i>
                                        <p class="icon-title">SOP</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a class="a-tag" href="/tables/wiTable">
                                    <div class="w-100 h-100">
                                        <i class="bi bi-clipboard-check"></i>
                                        <p class="icon-title">WI</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- end Table card -->


        </div>
    </div>
</body>
@endsection

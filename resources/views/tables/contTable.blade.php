@extends('layouts.app')

<!-- Scripts -->
@vite(['resources/css/table.css' , 'resources/js/table.js'])
@section('content')
<body>
<?php $permis = Auth::user()->role ;
      $dpm = Auth::user()->dpm;
?>
    <div class="px-lg-5 px-md-4 px-1">
        <div class="text-center mb-4"><h2>ทะเบียนสัญญา</h2></div>

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all" aria-selected="true">All</button>
                <button class="nav-link" id="nav-cre-tab" data-bs-toggle="tab" data-bs-target="#nav-cre" type="button" role="tab" aria-controls="nav-cre" aria-selected="false">สัญญา-เจ้าหนี้</button>
                <button class="nav-link" id="nav-deb-tab" data-bs-toggle="tab" data-bs-target="#nav-deb" type="button" role="tab" aria-controls="nav-deb" aria-selected="false">สัญญา-ลูกหนี้</button>
                <button class="nav-link" id="nav-otd-tab" data-bs-toggle="tab" data-bs-target="#nav-otd" type="button" role="tab" aria-controls="nav-otd" aria-selected="false">Outdoor</button>
                <a href="{{ route('contract-calendar') }}" class=" ms-auto"><button class="btn btn-success"><i class="bi bi-calendar-range fs-4"></i></button></a>
            </div>
        </nav>

        <div class="tab-content pt-4" id="nav-tabContent">
        <!-- Table -->
            <div class="tab-pane table-responsive fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab" tabindex="0">
                <table class="table table-hover listTable">

                    <!-- Table Header -->
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-nowrap">#</th>
                            <th scope="col" class="text-nowrap">เลขที่</th>
                            <th scope="col" class="text-nowrap">เรื่อง</th>
                            <th scope="col" class="text-nowrap">คู่สัญญา</th>
                            <th scope="col" class="text-nowrap">ระยะเวลา</th>
                            <th scope="col" class="text-nowrap">ผู้สร้าง</th>
                            <th scope="col" class="text-nowrap">วันที่สร้าง</th>
                            <th scope="col" class="text-nowrap">หมายเหตุ</th>
                            <th scope="col" class="text-nowrap">แก้ไข</th>
                            <th scope="col" class="text-nowrap">รายละเอียด</th>
                            {{-- <th scope="col" class="text-nowrap">แนบไฟล์</th> --}}
                            <th scope="col" class="text-nowrap">Share</th>
                            @can('staff')
                                <th scope="col">ShareDpm</th>
                            @endcan
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="table-group-divider" id="tableBody">
                        <!-- Table rows will be dynamically added here -->
                        @foreach ($contracts as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                @php
                                    $shares = json_decode($row->shares) ? json_decode($row->shares) : [];
                                    $teams = json_decode($row->submit_by) ? json_decode($row->submit_by) : [];
                                    $team = $row->submit_by;
                                    $teamArr = json_decode($team);
                                    $teamlist = [];
                                    $permis = Auth::user()->role ;
                                    $dpm = Auth::user()->dpm;
                                    if (is_array($teamArr)) {
                                        foreach ($teamArr as $index => $memb) {
                                            if ($index == 0) continue;
                                            $submitUser = $user->firstWhere('id', $memb);
                                            $teamlist[] = ($submitUser ? $submitUser->name : 'Unknow');
                                        }
                                    }
                                @endphp
                                <td class="text-nowrap">{{ $row->book_num}}</td>
                                <td class="truncate w-25" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $row->title }}">
                                    {{ $row->title }}
                                </td>
                                <td>{{ $row->party}}</td>
                                @php
                                    $dates = explode(" - ", $row->time_range);

                                    // Create Carbon instances for the start and end dates
                                    $startDate = Carbon\Carbon::createFromFormat('d/m/Y', $dates[0]);
                                    $endDate = Carbon\Carbon::createFromFormat('d/m/Y', $dates[1]);
                                    $diffDate = $endDate->diff($startDate);
                                @endphp
                                <td data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $row->time_range }}">{{ $diffDate->y ? $diffDate->y . 'ปี' : '' }} {{ $diffDate->m ? $diffDate->m . 'เดือน' : '' }} {{ $diffDate->d ? $diffDate->d . 'วัน' : '' }}</td>
                                <td>{{ $row->getUser->name ?? ''}}</td>
                                <td>{{ $row->created_at}}</td>
                                <td class="truncate" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $row->note }}">{{ $row->note}}</td>

                                {{-- @if (((App\Models\department::find((Auth::user())->dpm))->prefix) == $row->dpm || Auth::user()->hasRole(['admin', 'ceo']) || (in_array((Auth::user())->dpm, $shares))) --}}
                                @if ( Auth::user()->hasRole(['admin', 'ceo']) || ((Auth::user())->id == (is_array($teams) ? $teams[0] : $teams)))
                                    <td>
                                        @if (($row->stat ?? '') !== 'ผ่านการอนุมัติ')
                                            <a href="{{ route('edit-contract', ['cid' => $row->id]) }}"><button type="button" class="btn btn-warning">Edit</button></a>
                                        @endif
                                    </td>
                                @else
                                    <td></td>
                                @endif

                                <td>
                                    <a href="{{ route('contract-detail', ['cid' => $row->id]) }}"><button type="button" class="btn btn-secondary ">detail</button></a>
                                </td>
                                {{-- @if ( Auth::user()->hasRole(['admin', 'ceo']) || ((Auth::user())->id == (is_array($teams) ? $teams[0] : $teams)))
                                    <td>
                                        <a href="{{ route('contract-detail', ['cid' => $row->id]) }}"><button type="button" class="btn btn-secondary ">detail</button></a>
                                    </td>
                                @else
                                    <td></td>
                                @endif --}}


                                {{-- Share Btn --}}
                                <td><button class="btn btn-success" id="teamBtn" value="{{ $row->submit_by}}" bookid="{{ $row->id}}" bookType="cont" teamlist="{{json_encode($teamlist)}}"
                                    @if (!(((Auth::user())->id == (is_array($teams) ? $teams[0] : $teams)) || Auth::user()->hasRole(['admin', 'ceo']) || (in_array((Auth::user())->dpm, $shares))))
                                        disabled
                                    @endif>
                                    @php
                                        if (is_array($teamArr)) {
                                                $submitUser = $user->firstWhere('id', $teamArr[0]);
                                                echo ($submitUser ? $submitUser->name : 'Unknow');
                                        } else {
                                            $submitUser = $user->firstWhere('id', $row->submit_by);
                                            echo $submitUser ? $submitUser->name : 'Unknow';
                                        }
                                    @endphp
                                    </button>
                                </td>

                                @can('staff')
                                <td><button class="btn btn-success" id="shareBtn" value="{{ $row->share}}" bookid="{{ $row->id}}" fileType="check">
                                    @php
                                        $share = $row->shares;
                                        $teamArr = json_decode($share);
                                        if (is_array($teamArr)) {
                                            foreach ($teamArr as $memb) {
                                                echo ($memb ? (App\Models\department::find($memb))->name : '') . " / ";
                                            }
                                        } else {
                                            echo "share";
                                        }
                                        $permis = Auth::user()->role ;
                                        $dpm = Auth::user()->dpm;
                                    @endphp
                                    </button>
                                </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane table-responsive" id="nav-cre" role="tabpanel" aria-labelledby="nav-cre-tab" tabindex="0">
                <table class="table table-hover listTable-cre">

                    <!-- Table Header -->
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-nowrap">#</th>
                            <th scope="col" class="text-nowrap">เลขที่</th>
                            <th scope="col" class="text-nowrap">เรื่อง</th>
                            <th scope="col" class="text-nowrap">คู่สัญญา</th>
                            <th scope="col" class="text-nowrap">ระยะเวลา</th>
                            <th scope="col" class="text-nowrap">ผู้สร้าง</th>
                            <th scope="col" class="text-nowrap">วันที่สร้าง</th>
                            <th scope="col" class="text-nowrap">หมายเหตุ</th>
                            <th scope="col" class="text-nowrap">แก้ไข</th>
                            <th scope="col" class="text-nowrap">รายละเอียด</th>
                            {{-- <th scope="col" class="text-nowrap">แนบไฟล์</th> --}}
                            <th scope="col" class="text-nowrap">Share</th>
                            @can('staff')
                                <th scope="col">ShareDpm</th>
                            @endcan
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="table-group-divider" id="tableBody">
                        <!-- Table rows will be dynamically added here -->
                        @php
                            $num = 1;
                        @endphp
                        @foreach ($contracts as $index => $row)
                            @if ($row->type === 'creditor')
                                @php
                                    $shares = json_decode($row->shares) ? json_decode($row->shares) : [];
                                    $teams = json_decode($row->submit_by) ?? '';
                                    $team = $row->submit_by;
                                    $teamArr = json_decode($team);
                                    $teamlist = [];
                                    $permis = Auth::user()->role ;
                                    $dpm = Auth::user()->dpm;
                                    if (is_array($teamArr)) {
                                        foreach ($teamArr as $index => $memb) {
                                            if ($index == 0) continue;
                                            $submitUser = $user->firstWhere('id', $memb);
                                            $teamlist[] = ($submitUser ? $submitUser->name : 'Unknow');
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $num }}</td>
                                    <td class="text-nowrap">{{ $row->book_num}}</td>
                                    <td class="truncate w-25" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $row->title }}">
                                        {{ $row->title }}
                                    </td>
                                    <td>{{ $row->party}}</td>
                                    @php
                                        $dates = explode(" - ", $row->time_range);

                                        // Create Carbon instances for the start and end dates
                                        $startDate = Carbon\Carbon::createFromFormat('d/m/Y', $dates[0]);
                                        $endDate = Carbon\Carbon::createFromFormat('d/m/Y', $dates[1]);
                                        $diffDate = $endDate->diff($startDate);
                                    @endphp
                                    <td data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $row->time_range }}">{{ $diffDate->y ? $diffDate->y . 'ปี' : '' }} {{ $diffDate->m ? $diffDate->m . 'เดือน' : '' }} {{ $diffDate->d ? $diffDate->d . 'วัน' : '' }}</td>
                                    <td>{{ $row->getUser->name ?? ''}}</td>
                                    <td>{{ $row->created_at}}</td>
                                    <td class="truncate" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $row->note }}">{{ $row->note}}</td>

                                    {{-- @if (((App\Models\department::find((Auth::user())->dpm))->prefix) == $row->dpm || Auth::user()->hasRole(['admin', 'ceo']) || (in_array((Auth::user())->dpm, $shares))) --}}
                                    @if ( Auth::user()->hasRole(['admin', 'ceo']) || ((Auth::user())->id == (is_array($teams) ? $teams[0] : $team)))
                                        <td>
                                            <a href="{{ route('edit-contract', ['cid' => $row->id]) }}"><button type="button" class="btn btn-warning">Edit</button></a>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif

                                        {{-- Detail btn --}}
                                    <td>
                                        <a href="{{ route('contract-detail', ['cid' => $row->id]) }}"><button type="button" class="btn btn-secondary ">detail</button></a>
                                    </td>
                                    {{-- @if ( Auth::user()->hasRole(['admin', 'ceo']) || ((Auth::user())->id == (is_array($teams) ? $teams[0] : $teams)))
                                        <td>
                                            <a href="{{ route('contract-detail', ['cid' => $row->id]) }}"><button type="button" class="btn btn-secondary ">detail</button></a>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif --}}


                                    {{-- @if (((App\Models\department::find((Auth::user())->dpm))->prefix) == $row->dpm || Auth::user()->hasRole(['admin', 'ceo']) || (in_array((Auth::user())->dpm, $shares)) || (in_array(((Auth::user())->id), (is_array($teams)? $teams : []))))
                                        <td class="text-center">
                                            @if ($row->files != null)
                                                @php
                                                    $fileList = $row->files;
                                                @endphp
                                                @foreach ($fileList as $index => $file)
                                                    <button type="button" data-file-path="{{ asset('files/contract/' . $file) }}" class="btn btn-secondary viewFilebtn mb-1"  value="{{$file}}" fileId="{{$row->id}}"
                                                        candel=
                                                        @if ( ((Auth::user())->id == (is_array($teams) ? $teams[0] : $teams)) || Auth::user()->hasRole(['admin', 'ceo']))
                                                            "1"
                                                        @else
                                                            "0"
                                                        @endif
                                                    data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{$file}}"
                                                    >{{$index + 1}}</button>
                                                @endforeach
                                            @else

                                            @endif
                                            <button type="button" class="btn btn-info uploadBtn" value="{{$row->id}}" fileType="cont">upload</button>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif --}}

                                    {{-- Share Btn --}}
                                    <td><button class="btn btn-success" id="teamBtn" value="{{ $row->submit_by}}" bookid="{{ $row->id}}" bookType="cont" teamlist="{{json_encode($teamlist)}}"
                                        @if (!(((Auth::user())->id == (is_array($teams) ? $teams[0] : $team)) || Auth::user()->hasRole(['admin', 'ceo']) || (in_array((Auth::user())->dpm, $shares))))
                                            disabled
                                        @endif>
                                        @php
                                            if (is_array($teamArr)) {
                                                    $submitUser = $user->firstWhere('id', $teamArr[0]);
                                                    echo ($submitUser ? $submitUser->name : 'Unknow');
                                            } else {
                                                $submitUser = $user->firstWhere('id', $row->submit_by);
                                                echo $submitUser ? $submitUser->name : 'Unknow';
                                            }
                                        @endphp
                                        </button>
                                    </td>

                                    @can('staff')
                                    <td><button class="btn btn-success" id="shareBtn" value="{{ $row->share}}" bookid="{{ $row->id}}" fileType="check">
                                        @php
                                            $share = $row->shares;
                                            $teamArr = json_decode($share);
                                            if (is_array($teamArr)) {
                                                foreach ($teamArr as $memb) {
                                                    echo ($memb ? (App\Models\department::find($memb))->name : '') . " / ";
                                                }
                                            } else {
                                                echo "share";
                                            }
                                            $permis = Auth::user()->role ;
                                            $dpm = Auth::user()->dpm;
                                        @endphp
                                        </button>
                                    </td>
                                    @endcan
                                </tr>
                                @php
                                    $num += 1;
                                @endphp
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane table-responsive" id="nav-deb" role="tabpanel" aria-labelledby="nav-deb-tab" tabindex="0">
                <table class="table table-hover listTable-deb">

                    <!-- Table Header -->
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-nowrap">#</th>
                            <th scope="col" class="text-nowrap">เลขที่</th>
                            <th scope="col" class="text-nowrap">เรื่อง</th>
                            <th scope="col" class="text-nowrap">คู่สัญญา</th>
                            <th scope="col" class="text-nowrap">ระยะเวลา</th>
                            <th scope="col" class="text-nowrap">ผู้สร้าง</th>
                            <th scope="col" class="text-nowrap">วันที่สร้าง</th>
                            <th scope="col" class="text-nowrap">หมายเหตุ</th>
                            <th scope="col" class="text-nowrap">แก้ไข</th>
                            <th scope="col" class="text-nowrap">รายละเอียด</th>
                            {{-- <th scope="col" class="text-nowrap">แนบไฟล์</th> --}}
                            <th scope="col" class="text-nowrap">Share</th>
                            @can('staff')
                                <th scope="col">ShareDpm</th>
                            @endcan
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="table-group-divider" id="tableBody">
                        <!-- Table rows will be dynamically added here -->
                        @php
                            $num2 = 1;
                        @endphp
                        @foreach ($contracts as $index => $row)
                            @if ($row->type === 'debtor')
                                @php
                                    $shares = json_decode($row->shares) ? json_decode($row->shares) : [];
                                    $teams = json_decode($row->submit_by) ? json_decode($row->submit_by) : '';
                                    $team = $row->submit_by;
                                    $teamArr = json_decode($team);
                                    $teamlist = [];
                                    $permis = Auth::user()->role ;
                                    $dpm = Auth::user()->dpm;
                                    if (is_array($teamArr)) {
                                        foreach ($teamArr as $index => $memb) {
                                            if ($index == 0) continue;
                                            $submitUser = $user->firstWhere('id', $memb);
                                            $teamlist[] = ($submitUser ? $submitUser->name : 'Unknow');
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $num2 }}</td>
                                    <td class="text-nowrap">{{ $row->book_num}}</td>
                                    <td class="truncate w-25" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $row->title }}">
                                        {{ $row->title }}
                                    </td>
                                    <td>{{ $row->party}}</td>
                                    @php
                                        $dates = explode(" - ", $row->time_range);

                                        // Create Carbon instances for the start and end dates
                                        $startDate = Carbon\Carbon::createFromFormat('d/m/Y', $dates[0]);
                                        $endDate = Carbon\Carbon::createFromFormat('d/m/Y', $dates[1]);
                                        $diffDate = $endDate->diff($startDate);
                                    @endphp
                                    <td data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $row->time_range }}">{{ $diffDate->y ? $diffDate->y . 'ปี' : '' }} {{ $diffDate->m ? $diffDate->m . 'เดือน' : '' }} {{ $diffDate->d ? $diffDate->d . 'วัน' : '' }}</td>
                                    <td>{{ $row->getUser->name ?? ''}}</td>
                                    <td>{{ $row->created_at}}</td>
                                    <td class="truncate" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $row->note }}">{{ $row->note}}</td>

                                    {{-- @if (((App\Models\department::find((Auth::user())->dpm))->prefix) == $row->dpm || Auth::user()->hasRole(['admin', 'ceo']) || (in_array((Auth::user())->dpm, $shares))) --}}
                                    @if ( Auth::user()->hasRole(['admin', 'ceo']) || ((Auth::user())->id == (is_array($teams) ? $teams[0] : $team)))
                                        <td>
                                            <a href="{{ route('edit-contract', ['cid' => $row->id]) }}"><button type="button" class="btn btn-warning">Edit</button></a>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if ( Auth::user()->hasRole(['admin', 'ceo']) || ((Auth::user())->id == (is_array($teams) ? $teams[0] : $team)))
                                        <td>
                                            <a href="{{ route('contract-detail', ['cid' => $row->id]) }}"><button type="button" class="btn btn-secondary ">detail</button></a>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif


                                    {{-- @if (((App\Models\department::find((Auth::user())->dpm))->prefix) == $row->dpm || Auth::user()->hasRole(['admin', 'ceo']) || (in_array((Auth::user())->dpm, $shares)) || (in_array(((Auth::user())->id), (is_array($teams)? $teams : []))))
                                        <td class="text-center">
                                            @if ($row->files != null)
                                                @php
                                                    $fileList = $row->files;
                                                @endphp
                                                @foreach ($fileList as $index => $file)
                                                    <button type="button" data-file-path="{{ asset('files/contract/' . $file) }}" class="btn btn-secondary viewFilebtn mb-1"  value="{{$file}}" fileId="{{$row->id}}"
                                                        candel=
                                                        @if ( ((Auth::user())->id == (is_array($teams) ? $teams[0] : $teams)) || Auth::user()->hasRole(['admin', 'ceo']))
                                                            "1"
                                                        @else
                                                            "0"
                                                        @endif
                                                    data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{$file}}"
                                                    >{{$index + 1}}</button>
                                                @endforeach
                                            @else

                                            @endif
                                            <button type="button" class="btn btn-info uploadBtn" value="{{$row->id}}" fileType="cont">upload</button>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif --}}

                                    {{-- Share Btn --}}
                                    <td><button class="btn btn-success" id="teamBtn" value="{{ $row->submit_by}}" bookid="{{ $row->id}}" bookType="cont" teamlist="{{json_encode($teamlist)}}"
                                        @if (!(((Auth::user())->id == (is_array($teams) ? $teams[0] : $team)) || Auth::user()->hasRole(['admin', 'ceo']) || (in_array((Auth::user())->dpm, $shares))))
                                            disabled
                                        @endif>
                                        @php
                                            if (is_array($teamArr)) {
                                                    $submitUser = $user->firstWhere('id', $teamArr[0]);
                                                    echo ($submitUser ? $submitUser->name : 'Unknow');
                                            } else {
                                                $submitUser = $user->firstWhere('id', $row->submit_by);
                                                echo $submitUser ? $submitUser->name : 'Unknow';
                                            }
                                        @endphp
                                        </button>
                                    </td>

                                    @can('staff')
                                    <td><button class="btn btn-success" id="shareBtn" value="{{ $row->share}}" bookid="{{ $row->id}}" fileType="check">
                                        @php
                                            $share = $row->shares;
                                            $teamArr = json_decode($share);
                                            if (is_array($teamArr)) {
                                                foreach ($teamArr as $memb) {
                                                    echo ($memb ? (App\Models\department::find($memb))->name : '') . " / ";
                                                }
                                            } else {
                                                echo "share";
                                            }
                                            $permis = Auth::user()->role ;
                                            $dpm = Auth::user()->dpm;
                                        @endphp
                                        </button>
                                    </td>
                                    @endcan
                                </tr>
                                @php
                                    $num2 += 1;
                                @endphp
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane table-responsive" id="nav-otd" role="tabpanel" aria-labelledby="nav-otd-tab" tabindex="0">
                <table class="table table-hover listTable-otd">

                    <!-- Table Header -->
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-nowrap">#</th>
                            <th scope="col" class="text-nowrap">เลขที่</th>
                            <th scope="col" class="text-nowrap">เรื่อง</th>
                            <th scope="col" class="text-nowrap">คู่สัญญา</th>
                            <th scope="col" class="text-nowrap">ระยะเวลา</th>
                            <th scope="col" class="text-nowrap">ผู้สร้าง</th>
                            <th scope="col" class="text-nowrap">วันที่สร้าง</th>
                            <th scope="col" class="text-nowrap">หมายเหตุ</th>
                            <th scope="col" class="text-nowrap">แก้ไข</th>
                            <th scope="col" class="text-nowrap">รายละเอียด</th>
                            {{-- <th scope="col" class="text-nowrap">แนบไฟล์</th> --}}
                            <th scope="col" class="text-nowrap">Share</th>
                            @can('staff')
                                <th scope="col">ShareDpm</th>
                            @endcan
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="table-group-divider" id="tableBody">
                        <!-- Table rows will be dynamically added here -->
                        @php
                            $num3 = 1;
                        @endphp
                        @foreach ($contracts as $index => $row)
                            @if ($row->type === 'outdoor')
                                @php
                                    $shares = json_decode($row->shares) ? json_decode($row->shares) : [];
                                    $teams = json_decode($row->submit_by) ? json_decode($row->submit_by) : "";
                                    $team = $row->submit_by;
                                    $teamArr = json_decode($team);
                                    $teamlist = [];
                                    $permis = Auth::user()->role ;
                                    $dpm = Auth::user()->dpm;
                                    if (is_array($teamArr)) {
                                        foreach ($teamArr as $index => $memb) {
                                            if ($index == 0) continue;
                                            $submitUser = $user->firstWhere('id', $memb);
                                            $teamlist[] = ($submitUser ? $submitUser->name : 'Unknow');
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $num3 }}</td>
                                    <td class="text-nowrap">{{ $row->book_num}}</td>
                                    <td class="truncate w-25" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $row->title }}">
                                        {{ $row->title }}
                                    </td>
                                    <td>{{ $row->party}}</td>
                                    @php
                                        $dates = explode(" - ", $row->time_range);

                                        // Create Carbon instances for the start and end dates
                                        $startDate = Carbon\Carbon::createFromFormat('d/m/Y', $dates[0]);
                                        $endDate = Carbon\Carbon::createFromFormat('d/m/Y', $dates[1]);
                                        $diffDate = $endDate->diff($startDate);
                                    @endphp
                                    <td data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $row->time_range }}">{{ $diffDate->y ? $diffDate->y . 'ปี' : '' }} {{ $diffDate->m ? $diffDate->m . 'เดือน' : '' }} {{ $diffDate->d ? $diffDate->d . 'วัน' : '' }}</td>
                                    <td>{{ $row->getUser->name ?? ''}}</td>
                                    <td>{{ $row->created_at}}</td>
                                    <td class="truncate" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{ $row->note }}">{{ $row->note}}</td>

                                    {{-- @if (((App\Models\department::find((Auth::user())->dpm))->prefix) == $row->dpm || Auth::user()->hasRole(['admin', 'ceo']) || (in_array((Auth::user())->dpm, $shares))) --}}
                                    @if ( Auth::user()->hasRole(['admin', 'ceo']) || ((Auth::user())->id == (is_array($teams) ? $teams[0] : $team)))
                                        <td>
                                            <a href="{{ route('edit-contract', ['cid' => $row->id]) }}"><button type="button" class="btn btn-warning">Edit</button></a>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if ( Auth::user()->hasRole(['admin', 'ceo']) || ((Auth::user())->id == (is_array($teams) ? $teams[0] : $team)))
                                        <td>
                                            <a href="{{ route('contract-detail', ['cid' => $row->id]) }}"><button type="button" class="btn btn-secondary ">detail</button></a>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif


                                    {{-- @if (((App\Models\department::find((Auth::user())->dpm))->prefix) == $row->dpm || Auth::user()->hasRole(['admin', 'ceo']) || (in_array((Auth::user())->dpm, $shares)) || (in_array(((Auth::user())->id), (is_array($teams)? $teams : []))))
                                        <td class="text-center">
                                            @if ($row->files != null)
                                                @php
                                                    $fileList = $row->files;
                                                @endphp
                                                @foreach ($fileList as $index => $file)
                                                    <button type="button" data-file-path="{{ asset('files/contract/' . $file) }}" class="btn btn-secondary viewFilebtn mb-1"  value="{{$file}}" fileId="{{$row->id}}"
                                                        candel=
                                                        @if ( ((Auth::user())->id == (is_array($teams) ? $teams[0] : $teams)) || Auth::user()->hasRole(['admin', 'ceo']))
                                                            "1"
                                                        @else
                                                            "0"
                                                        @endif
                                                    data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="{{$file}}"
                                                    >{{$index + 1}}</button>
                                                @endforeach
                                            @else

                                            @endif
                                            <button type="button" class="btn btn-info uploadBtn" value="{{$row->id}}" fileType="cont">upload</button>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif --}}

                                    {{-- Share Btn --}}
                                    <td><button class="btn btn-success" id="teamBtn" value="{{ $row->submit_by}}" bookid="{{ $row->id}}" bookType="cont" teamlist="{{json_encode($teamlist)}}"
                                        @if (!(((Auth::user())->id == (is_array($teams) ? $teams[0] : $team)) || Auth::user()->hasRole(['admin', 'ceo']) || (in_array((Auth::user())->dpm, $shares))))
                                            disabled
                                        @endif>
                                        @php
                                            if (is_array($teamArr)) {
                                                    $submitUser = $user->firstWhere('id', $teamArr[0]);
                                                    echo ($submitUser ? $submitUser->name : 'Unknow');
                                            } else {
                                                $submitUser = $user->firstWhere('id', $row->submit_by);
                                                echo $submitUser ? $submitUser->name : 'Unknow';
                                            }
                                        @endphp
                                        </button>
                                    </td>

                                    @can('staff')
                                    <td><button class="btn btn-success" id="shareBtn" value="{{ $row->share}}" bookid="{{ $row->id}}" fileType="check">
                                        @php
                                            $share = $row->shares;
                                            $teamArr = json_decode($share);
                                            if (is_array($teamArr)) {
                                                foreach ($teamArr as $memb) {
                                                    echo ($memb ? (App\Models\department::find($memb))->name : '') . " / ";
                                                }
                                            } else {
                                                echo "share";
                                            }
                                            $permis = Auth::user()->role ;
                                            $dpm = Auth::user()->dpm;
                                        @endphp
                                        </button>
                                    </td>
                                    @endcan
                                </tr>
                                @php
                                    $num3 += 1;
                                @endphp
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div> {{-- close tab content --}}
    </div>
    <script src="https://fastly.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.listTable').DataTable({
                "paging": true,
                "pageLength": 10,
                "searching": true,
                "bLengthChange": false,
                language: {
                    search: "ค้นหา:"
                },
                drawCallback: function() {
                    $('[data-bs-toggle="tooltip"]').tooltip();
                }
            });
        });
        $(document).ready(function() {
            $('.listTable-cre').DataTable({
                "paging": true,
                "pageLength": 10,
                "searching": true,
                "bLengthChange": false,
                language: {
                    search: "ค้นหา:"
                },
                drawCallback: function() {
                    $('[data-bs-toggle="tooltip"]').tooltip();
                }
            });
        });
        $(document).ready(function() {
            $('.listTable-deb').DataTable({
                "paging": true,
                "pageLength": 10,
                "searching": true,
                "bLengthChange": false,
                language: {
                    search: "ค้นหา:"
                },
                drawCallback: function() {
                    $('[data-bs-toggle="tooltip"]').tooltip();
                }
            });
        });
        $(document).ready(function() {
            $('.listTable-otd').DataTable({
                "paging": true,
                "pageLength": 10,
                "searching": true,
                "bLengthChange": false,
                language: {
                    search: "ค้นหา:"
                },
                drawCallback: function() {
                    $('[data-bs-toggle="tooltip"]').tooltip();
                }
            });
        });

        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });

        const pdfButtons = document.querySelectorAll('.viewFilebtn');
        pdfButtons.forEach((pdfbtn) => {
            const fileNameValue = pdfbtn.value;
            const formId = pdfbtn.getAttribute('fileId');
            const fileType = document.querySelector('.uploadBtn').getAttribute('fileType');
            const canDel = pdfbtn.getAttribute('candel');
            pdfbtn.addEventListener('click', function () {
                const pdfUrl = this.getAttribute('data-file-path');
                Swal.fire({
                    showConfirmButton: false,
                    width: '70%',
                    html: '<div style="height: 600px;">' +
                        '<iframe src="' + pdfUrl + '" style="width: 100%; height: 100%;" frameborder="0"></iframe>' +
                        '</div>',
                    showDenyButton: (canDel != 0 ? true : false),
                    denyButtonText: 'Delete',
                }).then((result) => {
                    if (result.isDenied) {
                        console.log(result + fileNameValue + formId);
                        fetch('/table/deleteFile', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                            },
                            body: JSON.stringify({
                                fileName: fileNameValue,
                                id: formId,
                                type: fileType,
                            }),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            // Handle the response if needed
                            console.log(data);
                            // You can also reload the page to see the changes, if required
                            window.location.reload();
                        })
                        .catch((error) => {
                            // Handle errors if any
                            Swal.fire('Error!', 'An error occurred while saving the data.', 'error');
                        });
                    }
                });
            });
        });

        const checkbtn = document.querySelectorAll('.uploadBtn');
        let statusValue;
        checkbtn.forEach((ckbtn) => {
            const type = ckbtn.getAttribute('fileType');
            ckbtn.addEventListener('click', function () {
                Swal.fire({
                    title: 'Select file',
                    text: 'ไฟล์ที่รองรับ: pdf, jpg, jpeg, png, docx, doc, txt ไม่เกิน 128MB',
                    input: 'file',
                    inputAttributes: {
                        'aria-label': 'Upload your file'
                    }
                }).then((result) => {
                    const file = result.value; // Get the selected file from the result object
                    statusValue = ckbtn.value;
                    if (file) {
                        saveData(file,type);
                    }
                });
            });
        });

        const alertEditBtn = document.querySelectorAll('.alertEdit');
        alertEditBtn.forEach((ckbtn) => {
            ckbtn.addEventListener('click', function () {
                Swal.fire({
                    title: "สัญญาไม่พร้อม!",
                    text: "กรุณาแก้ไขสัญญาของท่านเพื่ออัพเดทข้อมูล เนื่องจากระบบมีการเปลี่ยนแปลงบางส่วน",
                    icon: "warning"
                });
            });
        });

        function saveData(file, type) {
            const formData = new FormData();
            formData.append('file', file);
            formData.append('type', type);
            formData.append('valueid', statusValue);

            // Send data to Laravel controller using fetch API
            fetch('/table/uploadFile', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                },
                body: formData,
            })
            .then((response) => response.json())
            .then((data) => {
                // Handle the response if needed
                console.log(data);
                // You can also reload the page to see the changes, if required
                window.location.reload();
            })
            .catch((error) => {
                // Handle errors if any
                Swal.fire('Error!', 'An error occurred while saving the data.', 'error');
            });
        }

        const ptbtns = document.querySelectorAll('#shareBtn');
        ptbtns.forEach((ckbtn) => {
            const bookid = ckbtn.getAttribute('bookid');
            const type = ckbtn.getAttribute('fileType');
            const team = ckbtn.value;
            ckbtn.addEventListener('click', function () {
                Swal.fire({
                    title: 'เพิ่มฝ่ายที่เข้าถึงเอกสาร',
                    html: `
                        <select class="form-select mb-2" id="usrt" >
                            <option value="" selected disabled>กรุณาเลือกฝ่ายที่สามารถเข้าถึงเอกสารนี้ได้</option>
                            @foreach ($dpms as $dpm)
                                <option value="{{$dpm->id}}">{{$dpm->name}}</option>
                            @endforeach
                        </select>
                        `,
                    showCancelButton: true,
                    showDenyButton: true,
                    denyButtonText: 'ล้างรายชื่อทั้งหมด',
                    confirmButtonText: 'บันทึก',
                    cancelButtonText: 'ยกเลิก',
                    preConfirm: () => {
                        const usrtValue = document.getElementById('usrt').value;
                        if (!usrtValue) {
                            return Promise.reject('โปรดเลือกฝ่าย');
                        }

                        return [usrtValue];
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(result);
                        fetch('/table/form/addShare', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                            },
                            body: JSON.stringify({
                                memb: result.value[0],
                                bid: bookid,
                                oldT: team,
                                type: type,
                            }),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            // Handle the response if needed
                            console.log(data);
                            // You can also reload the page to see the changes,
                            window.location.reload();
                        })
                        .catch((error) => {
                            // Handle errors if any
                            Swal.fire('Error!', error.message, 'error');
                        });
                    } else if (result.isDenied) {
                        console.log(result);
                        fetch('/table/form/clearShare', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                            },
                            body: JSON.stringify({
                                bid: bookid,
                                type: type,
                            }),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            // Handle the response if needed
                            console.log("res= " + data);
                            // You can also reload the page to see the changes,
                            window.location.reload();
                        })
                        .catch((error) => {
                            // Handle errors if any
                            Swal.fire('Error!', error.message, 'error');
                        });
                    }
                }).catch((error) => {
                    Swal.fire('Error!', error, 'error'); // Display error to user
                });
            });
        });

        const teambtns = document.querySelectorAll('#teamBtn');
        teambtns.forEach((ckbtn) => {
            const bookid = ckbtn.getAttribute('bookid');
            const team = ckbtn.value;
            const teamlistData = JSON.parse(ckbtn.getAttribute('teamlist'));
            const displayTeamlist = teamlistData.join(', ');
            const bookty = ckbtn.getAttribute('bookType');
            ckbtn.addEventListener('click', function () {
                Swal.fire({
                    title: 'สิทธ์การเข้าถึงเอกสาร',
                    html: `<div ><b>รายชื่อ:</b> ${displayTeamlist}</div>
                        <hr>
                        <select class="form-select mb-2" id="usrt" >
                            <option value="" selected disabled>กรุณาเลือกผู้มีสิทธ์เข้าถึงเอกสาร</option>
                            @foreach ($user as $usr)
                                <option value="{{$usr->id}}">{{$usr->name}}</option>
                            @endforeach
                        </select>
                        `,
                    showCancelButton: true,
                    showDenyButton: true,
                    denyButtonText: 'ล้างรายชื่อทั้งหมด',
                    confirmButtonText: 'บันทึก',
                    cancelButtonText: 'ยกเลิก',
                    preConfirm: () => {
                        const usrtValue = document.getElementById('usrt').value;
                        if (!usrtValue) {
                            return Promise.reject('โปรดเลือกรายชื่อ');
                        }

                        return [usrtValue];
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(result);
                        fetch('/table/form/addTeam', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                            },
                            body: JSON.stringify({
                                memb: result.value[0],
                                bid: bookid,
                                oldT: team,
                                type: bookty,
                            }),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            // Handle the response if needed
                            console.log("res= " + data);
                            // You can also reload the page to see the changes,
                            window.location.reload();
                        })
                        .catch((error) => {
                            // Handle errors if any
                            Swal.fire('Error!', error.message, 'error');
                        });
                    } else if (result.isDenied) {
                        console.log(result);
                        fetch('/table/form/clearTeam', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                            },
                            body: JSON.stringify({
                                bid: bookid,
                                oldT: team,
                                type: bookty,
                            }),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            // Handle the response if needed
                            console.log("res= " + data);
                            // You can also reload the page to see the changes,
                            window.location.reload();
                        })
                        .catch((error) => {
                            // Handle errors if any
                            Swal.fire('Error!', error.message, 'error');
                        });
                    }
                }).catch((error) => {
                    Swal.fire('Error!', error, 'error'); // Display error to user
                });
            });
        });
    </script>
</body>
@endsection

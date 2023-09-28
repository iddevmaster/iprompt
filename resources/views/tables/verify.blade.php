@extends('layouts.app')

<!-- Scripts -->
@vite(['resources/css/table.css' , 'resources/js/table.js'])
@section('content')
<body>
<?php $permis = Auth::user()->role ;
      $dpm = Auth::user()->dpm;
?>
    <div class="container">
        <div class="text-center mb-4"><h2>ตรวจสอบ / อนุมัติ หนังสือ</h2></div>
        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover listTable">

                <!-- Table Header -->
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">เลขที่หนังสือ</th>
                        <th scope="col">ประเภทหนังสือ</th>
                        <th scope="col">เรื่อง</th>
                        <th scope="col">วันที่สร้าง</th>
                        <th scope="col">ผู้บันทึก</th>
                        <th scope="col">สถานะ</th>
                        <th scope="col">หนังสือ</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="table-group-divider" id="tableBody">
                    <!-- Table rows will be dynamically added here -->
                    <?php  $counter = 1 ?>
                    @foreach ($form as $row)
                        @php
                            $app = json_decode($row->app);
                            $ins = json_decode($row->ins);
                            $type = explode('.', $row->type);
                        @endphp
                        @if (($row->stat === 'รออนุมัติ' && $app->appId == Auth::user()->id) || ($row->stat === 'รอตรวจสอบ' && $ins->appId == Auth::user()->id))
                            <tr>
                                <td>{{$counter}}</td>
                                <td>{{ $row->book_num}}</td>
                                <td>{{ $type ? $type[0] : $row->type}}</td>
                                <td class="truncate">{{ $row->title}}</td>
                                <td>{{ $row->created_date}}</td>
                                <td>
                                    @php
                                        $submitUser = $user->firstWhere('id', $row->submit_by);
                                        echo $submitUser ? $submitUser->name : 'Unknown';
                                    @endphp
                                </td>

                                <td>
                                    <button class="btn btn-secondary" name="{{$row->id}}" id="{{$row->stat}}" docType="{{$row->type}}">{{$row->stat}}</button>
                                </td>

                                <td>
                                    @if ($row->type === 'wiForm')
                                        <a href="{{url('/form/downloadwi/verify/'.$row->id)}}" target="_blank"><button type="button" class="btn btn-primary">View</button></a>
                                    @elseif ($row->type === 'sopForm')
                                        <a href="{{url('/form/downloadsop/verify/'.$row->id)}}" target="_blank"><button type="button" class="btn btn-primary">View</button></a>
                                    @elseif ($row->type === 'policyForm')
                                        <a href="{{url('/form/downloadpol/verify/'.$row->id)}}" target="_blank"><button type="button" class="btn btn-primary">View</button></a>
                                    @elseif ($row->type === 'annoForm')
                                        <a href="{{url('/form/downloadanno/verify/'.$row->id)}}" target="_blank"><button type="button" class="btn btn-primary">View</button></a>
                                    @elseif ($row->type === 'mouForm')
                                        <a href="{{url('/form/downloadmou/verify/'.$row->id)}}" target="_blank"><button type="button" class="btn btn-primary">View</button></a>
                                    @elseif ($row->type === 'projForm')
                                        <a href="{{url('/form/downloadproj/verify/'.$row->id)}}" target="_blank"><button type="button" class="btn btn-primary">View</button></a>
                                    @elseif ($type[0] === 'courseForm')
                                        <a href="{{url('/form/downloadcourse/verify/'.$row->id)}}" target="_blank"><button type="button" class="btn btn-primary">View</button></a>
                                    @elseif ($type[0] === 'mediaForm')
                                        <a href="{{url('/form/downloadmedia/verify/'.$row->id)}}" target="_blank"><button type="button" class="btn btn-primary">View</button></a>
                                    @elseif ($type[0] === 'checkForm')
                                        <a href="{{url('/form/downloadcheck/verify/'.$row->id)}}" target="_blank"><button type="button" class="btn btn-primary">View</button></a>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    <?php $counter++ ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.listTable').DataTable({
                "paging": true,
                "pageLength": 10,
                "searching": true,
                "bLengthChange": false,
            });
        });
        const statbtns = document.querySelectorAll('#รอตรวจสอบ');
        const appbtns = document.querySelectorAll('#รออนุมัติ');
        statbtns.forEach((ckbtn) => {
            let status = ckbtn.getAttribute('id');
            let docid = ckbtn.getAttribute('name');
            let type = ckbtn.getAttribute('docType');
            ckbtn.addEventListener('click', function () {
                Swal.fire({
                title: 'ผลการตรวจสอบ',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'ผ่าน',
                denyButtonText: 'ไม่ผ่าน',
                cancelButtonText: 'Cancel'
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                    input: 'textarea',
                    inputLabel: 'ผ่านการตรวจสอบ',
                    inputPlaceholder: 'หมายเหตุ',
                    inputAttributes: {
                        'aria-label': 'Type your message here'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Cancel'
                    }).then((confirmationResult) => {
                    if (confirmationResult.isConfirmed) {
                        fetch('/table/form/verify', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                            },
                            body: JSON.stringify({
                                docId: docid,
                                status: status,
                                type: type,
                                note: confirmationResult.value,
                                res : true,
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
                    }
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                    input: 'textarea',
                    inputLabel: 'ไม่ผ่านการตรวจสอบ',
                    inputPlaceholder: 'หมายเหตุ',
                    inputAttributes: {
                        'aria-label': 'Type your message here'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Cancel'
                    }).then((denialResult) => {
                    if (denialResult.isConfirmed) {
                        fetch('/table/form/verify', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                            },
                            body: JSON.stringify({
                                docId: docid,
                                status: status,
                                type: type,
                                note: denialResult.value,
                                res : false,
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
                    }
                    });
                }
                });

            });
        });


        appbtns.forEach((ckbtn) => {
            let status = ckbtn.getAttribute('id');
            let docid = ckbtn.getAttribute('name');
            let type = ckbtn.getAttribute('docType');
            ckbtn.addEventListener('click', function () {
                Swal.fire({
                title: 'ผลการอนุมัติ',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'ผ่าน',
                denyButtonText: 'ไม่ผ่าน',
                cancelButtonText: 'Cancel'
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                    input: 'textarea',
                    inputLabel: 'ผ่านการอนุมัติ',
                    inputPlaceholder: 'หมายเหตุ',
                    inputAttributes: {
                        'aria-label': 'Type your message here'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Cancel'
                    }).then((confirmationResult) => {
                    if (confirmationResult.isConfirmed) {
                        fetch('/table/form/verify', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                            },
                            body: JSON.stringify({
                                docId: docid,
                                status: status,
                                type: type,
                                note: confirmationResult.value,
                                res : true,
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
                    }
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                    input: 'textarea',
                    inputLabel: 'ไม่ผ่านการอนุมัติ',
                    inputPlaceholder: 'หมายเหตุ',
                    inputAttributes: {
                        'aria-label': 'Type your message here'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Cancel'
                    }).then((denialResult) => {
                    if (denialResult.isConfirmed) {
                        fetch('/table/form/verify', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                            },
                            body: JSON.stringify({
                                docId: docid,
                                status: status,
                                type: type,
                                note: denialResult.value,
                                res : false,
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
                    }
                    });
                }
                });
            });
        });
    </script>
</body>
@endsection

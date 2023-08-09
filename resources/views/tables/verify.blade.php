@extends('layouts.app')

<!-- Scripts -->
@vite(['resources/css/table.css' , 'resources/js/table.js'])
@section('content')
<body>
<?php $permis = Auth::user()->role ;
      $dpm = Auth::user()->dpm;
?>
    <div class="container">
        <div class="text-center mb-4"><h2>Verify Doc Table</h2></div>
        <div class="d-flex">
            <div class="flex-grow-1"><input type="text" id="searchInput" class="form-control mb-2" placeholder="Search..."></div>
            <div class="p-1 ms-2 export"><a class="a-tag" href="#"><i class="bi bi-file-earmark-arrow-down"></i></a></div>
        </div>
        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover ">

                <!-- Table Header -->
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Book_num</th>
                        <th scope="col">Type</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Created_date</th>
                        <th scope="col">Submit_by</th>
                        <th scope="col">Status</th>
                        <th scope="col">Book</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="table-group-divider" id="tableBody">
                    <!-- Table rows will be dynamically added here -->
                    <?php  $counter = 1 ?>
                    @foreach ($form as $row)
                    <tr>
                        <td>{{$counter}}</td>
                        <td>{{ $row->book_num}}</td>
                        <td>{{ $row->type}}</td>
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
                            @endif
                        </td>
                    </tr>
                    <?php $counter++ ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const statbtns = document.querySelectorAll('#รอตรวจสอบ');
        const appbtns = document.querySelectorAll('#รออนุมัติ');
        statbtns.forEach((ckbtn) => {
            let status = ckbtn.getAttribute('id');
            let docid = ckbtn.getAttribute('name');
            let type = ckbtn.getAttribute('docType');
            ckbtn.addEventListener('click', function () {
                Swal.fire({
                    input: 'textarea',
                    inputLabel: 'ผลการประเมิน',
                    inputPlaceholder: 'หมายเหตุ',
                    inputAttributes: {
                        'aria-label': 'Type your message here'
                    },
                    showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'ผ่าน',
                    denyButtonText: `ไม่ผ่าน`,
                    cancelButtonText: `ยกเลิก`,
                }).then((result) => {
                    if (result.isConfirmed) {
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
                                note: result.value,
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
                    } else if (result.isDenied) {
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
                                note: result.value,
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
                })
            });
        });


        appbtns.forEach((ckbtn) => {
            let status = ckbtn.getAttribute('id');
            let docid = ckbtn.getAttribute('name');
            let type = ckbtn.getAttribute('docType');
            ckbtn.addEventListener('click', function () {
                Swal.fire({
                    input: 'textarea',
                    inputLabel: 'ผลการประเมิน',
                    inputPlaceholder: 'หมายเหตุ',
                    inputAttributes: {
                        'aria-label': 'Type your message here'
                    },
                    showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'ผ่าน',
                    denyButtonText: `ไม่ผ่าน`,
                    cancelButtonText: `ยกเลิก`,
                }).then((result) => {
                    if (result.isConfirmed) {
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
                                note: result.value,
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
                    } else if (result.isDenied) {
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
                                note: result.value,
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
                })
            });
        });
    </script>
</body>
@endsection
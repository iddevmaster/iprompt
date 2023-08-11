@extends('layouts.app')

<!-- Scripts -->
@vite(['resources/css/table.css' , 'resources/js/table.js'])

@section('content')
<body>
    <div class="container">
        <div class="text-center mb-4"><h2>ทะเบียนประกาศ</h2></div>
        <div class="d-flex">
            <div class="flex-grow-1"><input type="text" id="searchInput" class="form-control mb-2" placeholder="Search..."></div>
            <div class="p-1 ms-2 export"><a class="a-tag" href=""><i class="bi bi-file-earmark-arrow-down"></i></a></div>
        </div>
        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover ">

                <!-- Table Header -->
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">เลขที่หนังสือ</th>
                        <th scope="col">เรื่อง</th>
                        <th scope="col">วันที่สร้าง</th>
                        <th scope="col">ผู้บันทึก</th>
                        <th scope="col">สถานะ</th>
                        <th scope="col">แก้ไข</th>
                        <th scope="col">Download</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="table-group-divider" id="tableBody">
                    <!-- Table rows will be dynamically added here -->
                    <?php  $counter = 1 ?>
                    @foreach ($gendoc as $row)
                        <tr>
                            <td>{{$counter}}</td>
                            <td>{{ $row->book_num}}</td>
                            <td class="truncate">{{ $row->title}}</td>
                            <td>{{ $row->created_date}}</td>
                            <td>
                                @php
                                    $submitUser = $user->firstWhere('id', $row->submit_by);
                                    echo $submitUser ? $submitUser->name : 'Unknown';
                                    $permis = Auth::user()->role ;
                                    $dpm = Auth::user()->dpm;
                                @endphp
                            </td>

                            <td>
                                @if ($row->stat === 'ยังไม่ได้ตรวจสอบ')
                                    <button class="btn btn-info" name="{{$row->stat}}" docType="{{$row->type}}" id="status" value="{{$row->id}}">{{$row->stat}}</button>
                                @elseif ($row->stat === 'ผ่านการอนุมัติ')
                                    <button class="btn btn-success" name="{{$row->stat}}" docType="{{$row->type}}" value="{{$row->id}}">{{$row->stat}}</button>
                                @elseif ($row->stat === 'ไม่ผ่านการตรวจสอบ' || $row->stat === 'ไม่ผ่านการอนุมัติ')
                                    <button class="btn btn-danger" name="{{$row->stat}}" docType="{{$row->type}}" value="{{$row->id}}">{{$row->stat}}</button>
                                @else
                                    <button class="btn btn-secondary" name="{{$row->stat}}" docType="{{$row->type}}" value="{{$row->id}}">{{$row->stat}}</button>
                                @endif
                            </td>

                            @can('create')
                                <td>
                                    <a href="{{url('/form/editanno/'.$row->id)}}"><button type="button" class="btn btn-warning">Edit</button></a>
                                </td>
                            @else
                                <td></td>
                            @endcan


                            @can('download')
                                <td>
                                    <a href="{{url('/form/downloadanno/download/'.$row->id)}}" target="_blank"><button type="button" class="btn btn-primary">Download</button></a>
                                </td>
                            @else
                                <td>
                                    <a href="{{url('/form/downloadanno/download/'.$row->id)}}" target="_blank"><button type="button" class="btn btn-primary">View</button></a>
                                </td>
                            @endcan
                        </tr>
                        <?php $counter++ ?>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-end pagination">
                {{ $gendoc->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const statbtns = document.querySelectorAll('#status');
        statbtns.forEach((ckbtn) => {
            let status = ckbtn.getAttribute('name');
            let docid = ckbtn.value;
            let type = ckbtn.getAttribute('docType');
            ckbtn.addEventListener('click', function () {
                Swal.fire({
                    title: 'Verification',
                    html: `
                        <select class="form-select mb-2" id="ins" >
                            <option value="" selected disabled>กรุณาเลือกผู้ตรวจสอบ</option>
                            @foreach ($inspectors as $ins)
                                <option value="{{$ins->id}}">{{$ins->name}}</option>
                            @endforeach
                        </select>
                        <select class="form-select mb-2" id="appr" >
                            <option value="" selected disabled>กรุณาเลือกผู้อนุมัติ</option>
                            @foreach ($approvers as $appr)
                                <option value="{{$appr->id}}">{{$appr->name}}</option>
                            @endforeach
                        </select>
                        `,
                    showCancelButton: true,
                    preConfirm: () => {
                        const insValue = document.getElementById('ins').value;
                        const appValue = document.getElementById('appr').value;
                        if (!insValue || !appValue) {
                            return Promise.reject('Please select both inspector and approver.');
                        }
                        
                        return [insValue, appValue];
                    }
                }).then((result) => {
                    if (result.isConfirmed) {

                        fetch('/table/form/verify', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                            },
                            body: JSON.stringify({
                                ins: result.value[0],
                                app: result.value[1],
                                docId: docid,
                                status: status,
                                type: type,
                            }),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            // Handle the response if needed
                            console.log(data);
                            // You can also reload the page to see the changes,
                            // Swal.fire('Success!', '', 'success');
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
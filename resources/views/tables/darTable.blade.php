@extends('layouts.app')

<!-- Scripts -->
@vite(['resources/css/table.css' , 'resources/js/table.js'])
@section('content')
<body>
<?php $permis = Auth::user()->role ;
      $dpm = Auth::user()->dpm;
?>
    <div class="px-lg-5 px-md-4 px-1">
        <div class="text-center mb-4"><h2>ทะเบียนคำขอดำเนินการเอกสาร</h2></div>

        <!-- Table -->
        <div class="table-responsive fade show active pt-4" id="nav-all">
            <table class="table table-hover listTable">

                <!-- Table Header -->
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="text-nowrap">#</th>
                        <th scope="col" class="text-nowrap">เลขที่</th>
                        <th scope="col" class="text-nowrap">ประเภทของเอกสาร</th>
                        <th scope="col" class="text-nowrap">ขอเพื่อ</th>
                        <th scope="col" class="text-nowrap">ผู้ขอ</th>
                        <th scope="col" class="text-nowrap">วันที่ขอ</th>
                        {{-- <th scope="col" class="text-nowrap">แก้ไข</th> --}}
                        <th scope="col">สถานะ</th>
                        <th scope="col" class="text-nowrap">รายละเอียด</th>
                        {{-- <th scope="col" class="text-nowrap">แนบไฟล์</th> --}}
                        {{-- <th scope="col" class="text-nowrap">Share</th>
                        @can('staff')
                            <th scope="col">ShareDpm</th>
                        @endcan --}}
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="table-group-divider" id="tableBody">
                    <!-- Table rows will be dynamically added here -->
                    @foreach ($dars ?? [] as $index => $row)
                        @php
                            $doc_types = json_decode($row->doc_type);
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-nowrap">{{ $row->book_num}}</td>
                            <td class="text-nowrap">{{ implode(',', $doc_types) }}</td>
                            <td class="text-nowrap">{{ $row->action_type}}</td>
                            <td>{{ $row->request_by}}</td>
                            <td>{{ $row->request_at}}</td>
                            <td>
                                @php
                                    $app = json_decode($row->app);
                                    $ins = json_decode($row->ins);
                                    $appName = $user->firstWhere('id', $app->appId ?? '') ?? [];
                                    $insName = $user->firstWhere('id', $ins->appId ?? '') ?? [];
                                    $note = $app->note ?? '-';
                                    $insnote = $ins->note ?? '-';
                                @endphp
                                @if ($row->stat === 'ยังไม่ได้ตรวจสอบ')
                                    <button class="btn btn-info" name="{{$row->stat}}" docType="darForm" id="status" value="{{$row->id}}"
                                        @if (!(((App\Models\department::find((Auth::user())->dpm))->prefix) == $row->dpm || Auth::user()->hasRole(['admin', 'ceo']) || (in_array((Auth::user())->dpm, $shares))))
                                            disabled
                                        @endif
                                    >{{$row->stat}}</button>
                                @elseif ($row->stat === 'ผ่านการอนุมัติ')
                                    <button class="btn btn-success"
                                            name="{{$row->stat}}"
                                            docType="darForm"
                                            id="passbtn"
                                            note="{{$note}}"
                                            insnote="{{$insnote}}"
                                            appName="{{$appName ? $appName->name : 'Unknow'}}"
                                            insName="{{$insName ? $insName->name : 'Unknow'}}"
                                            appSign="{{ $appName ? $appName->image : ''}}"
                                            insSign="{{ $insName ? $insName->image : ''}}"
                                            value="{{$row->id}}">{{$row->stat}}</button>
                                @elseif ($row->stat === 'ไม่ผ่านการตรวจสอบ' || $row->stat === 'ไม่ผ่านการอนุมัติ')

                                    <button class="btn btn-danger"
                                            name="{{$row->stat}}"
                                            id="notpass"
                                            note="{{$note}}"
                                            insnote="{{$insnote}}"
                                            appName="{{$appName ? $appName->name : 'Unknow'}}"
                                            insName="{{$insName ? $insName->name : 'Unknow'}}"
                                            docType="darForm"
                                            value="{{$row->id}}">{{$row->stat}}</button>
                                @else
                                    {{-- <button class="btn btn-secondary" name="{{$row->stat}}" docType="{{$row->type}}" value="{{$row->id}}">{{$row->stat}}</button> --}}
                                    <button class="btn btn-secondary"
                                        name="{{$row->stat}}"
                                        docType="darForm"
                                        id="passbtn"
                                        note="{{$note}}"
                                        insnote="{{$insnote}}"
                                        appName="{{$appName ? $appName->name : 'Unknow'}}"
                                        insName="{{$insName ? $insName->name : 'Unknow'}}"
                                        appSign="{{ $appName ? $appName->image : ''}}"
                                        insSign="{{ $insName ? $insName->image : ''}}"
                                        value="{{$row->id}}">{{$row->stat}}</button>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('dar-detail', ['darid' => $row->id]) }}"><button type="button" class="btn btn-secondary ">detail</button></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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

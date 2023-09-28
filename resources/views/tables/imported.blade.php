@extends('layouts.app')

<!-- Scripts -->
@vite(['resources/css/table.css' , 'resources/js/table.js'])

@section('content')
<body>
<?php $regData = \App\CoreFunction\Helper::regData();?>
    <div class="container">
        <div class="text-center mb-4"><h2>ทะเบียนหนังสือรับเข้า</h2></div>

        <!-- Table -->
        <div class="mt-3">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all" aria-selected="true">All</button>
                    <button class="nav-link" id="nav-cont-tab" data-bs-toggle="tab" data-bs-target="#nav-cont" type="button" role="tab" aria-controls="nav-cont" aria-selected="false">สัญญา</button>
                    <button class="nav-link" id="nav-mou-tab" data-bs-toggle="tab" data-bs-target="#nav-mou" type="button" role="tab" aria-controls="nav-mou" aria-selected="false">MoU</button>
                    <button class="nav-link" id="nav-anno-tab" data-bs-toggle="tab" data-bs-target="#nav-anno" type="button" role="tab" aria-controls="nav-anno" aria-selected="false">ประกาศ</button>
                    <button class="nav-link" id="nav-proj-tab" data-bs-toggle="tab" data-bs-target="#nav-proj" type="button" role="tab" aria-controls="nav-proj" aria-selected="false">โครงการ</button>
                </div>
            </nav>

            <div class="tab-content pt-3" id="nav-tabContent">
                <div class="tab-pane table-responsive fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab" tabindex="0">

                    <!-- All imported table -->
                    <table class="table table-hover mt-2 listTable">
                        <!-- Table Header -->
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">เลขที่หนังสือ</th><?php $regData = \App\CoreFunction\Helper::regData();?>
                                <th scope="col">เรื่อง</th>
                                <th scope="col">ประเภทหนังสือ</th>
                                <th scope="col">ผู้ส่งหนังสือ</th>
                                <th scope="col">ผู้รับ</th>
                                <th scope="col">ฝ่ายผู้รับ</th>
                                <th scope="col">วันที่รับ</th>
                                <th scope="col">สถานะ</th>
                                <th scope="col">หนังสือ</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody class="table-group-divider" id="tableBody">
                            <?php  $counter = 1 ?>
                            @foreach ($imported as $row)
                                <?php $dpm = App\Models\department::find($row->receiver_dpm);
                                        $brn = App\Models\branche::find($row->receiver_brn);
                                        $sts = App\Models\statu::find($row->status);?>
                                <tr>
                                    <td>{{$counter}}</td>
                                    <td>{{$row->book_number}}</td>
                                    <td>{{$row->book_subj}}</td>
                                    <td>{{$row->type}}</td>
                                    <td>{{$row->from}}</td>
                                    <td>{{$row->receiver}}</td>
                                    <td>{{$dpm->name}}/{{$brn->name}}</td>
                                    <td>{{$row->receive_date}}</td>
                                    <td>
                                        @if ($row->status === '1')
                                            <button type="button" class="btn btn-outline-primary" disabled>{{$sts->name}}</button>
                                        @elseif ($row->status === '2')
                                            <button type="button" class="btn btn-success" disabled>{{$sts->name}}</button>
                                        @elseif ($row->status === '3')
                                            <button type="button" class="btn btn-danger" disabled>{{$sts->name}}</button>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" data-file-path="{{ asset('storage/uploads/' . $row->file) }}" class="btn btn-info viewPdfBtn">Book</button>
                                    </td>
                                    @if ($row->status === '1')
                                        @hasanyrole('employee|leader_dpm|ceo|admin')
                                            <td>
                                                <button type="button" class="btn btn-secondary" id="checkbtn" value="{{$row->id}}"><i class="bi bi-check2-square"></i></button>
                                            </td>
                                        @endhasanyrole
                                    @endif
                                </tr>
                                <?php $counter++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="tab-pane fade table-responsive" id="nav-cont" role="tabpanel" aria-labelledby="nav-cont-tab" tabindex="0">
                    <!-- Contract imported table -->
                    <table class="table table-hover mt-2 listTable">
                        <!-- Table Header -->
                        <thead class="table-dark">
                            <tr>
                            <th scope="col">#</th>
                                <th scope="col">เลขที่หนังสือ</th><?php $regData = \App\CoreFunction\Helper::regData();?>
                                <th scope="col">เรื่อง</th>
                                <th scope="col">ประเภทหนังสือ</th>
                                <th scope="col">ผู้ส่งหนังสือ</th>
                                <th scope="col">ผู้รับ</th>
                                <th scope="col">ฝ่ายผู้รับ</th>
                                <th scope="col">วันที่รับ</th>
                                <th scope="col">สถานะ</th>
                                <th scope="col">หนังสือ</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody class="table-group-divider" id="tableBody">
                            <?php  $counter = 1 ?>
                            @foreach ($imp_cont as $row)
                                <?php $dpm = App\Models\department::find($row->receiver_dpm);
                                        $brn = App\Models\branche::find($row->receiver_brn);
                                        $sts = App\Models\statu::find($row->status);?>
                                <tr>
                                    <td>{{$counter}}</td>
                                    <td>{{$row->book_number}}</td>
                                    <td>{{$row->book_subj}}</td>
                                    <td>{{$row->type}}</td>
                                    <td>{{$row->from}}</td>
                                    <td>{{$row->receiver}}</td>
                                    <td>{{$dpm->name}}/{{$brn->name}}</td>
                                    <td>{{$row->receive_date}}</td>
                                    <td>
                                        @if ($row->status === '1')
                                            <button type="button" class="btn btn-outline-primary" disabled>{{$sts->name}}</button>
                                        @elseif ($row->status === '2')
                                            <button type="button" class="btn btn-success" disabled>{{$sts->name}}</button>
                                        @elseif ($row->status === '3')
                                            <button type="button" class="btn btn-danger" disabled>{{$sts->name}}</button>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" data-file-path="{{ asset('storage/uploads/' . $row->file) }}" class="btn btn-info viewPdfBtn">Book</button>
                                    </td>
                                    @if ($row->status === '1')
                                        @hasanyrole('employee|leader_dpm|ceo|admin')
                                            <td>
                                                <button type="button" class="btn btn-secondary" id="checkbtn" value="{{$row->id}}"><i class="bi bi-check2-square"></i></button>
                                            </td>
                                        @endhasanyrole
                                    @endif
                                </tr>
                                <?php $counter++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="tab-pane fade table-responsive" id="nav-mou" role="tabpanel" aria-labelledby="nav-mou-tab" tabindex="0">
                    <!-- MOU imported table -->
                    <table class="table table-hover mt-2 listTable">
                        <!-- Table Header -->
                        <thead class="table-dark">
                            <tr>
                            <th scope="col">#</th>
                                <th scope="col">เลขที่หนังสือ</th><?php $regData = \App\CoreFunction\Helper::regData();?>
                                <th scope="col">เรื่อง</th>
                                <th scope="col">ประเภทหนังสือ</th>
                                <th scope="col">ผู้ส่งหนังสือ</th>
                                <th scope="col">ผู้รับ</th>
                                <th scope="col">ฝ่ายผู้รับ</th>
                                <th scope="col">วันที่รับ</th>
                                <th scope="col">สถานะ</th>
                                <th scope="col">หนังสือ</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody class="table-group-divider" id="tableBody">
                            <?php  $counter = 1 ?>
                            @foreach ($imp_mou as $row)
                                <?php $dpm = App\Models\department::find($row->receiver_dpm);
                                        $brn = App\Models\branche::find($row->receiver_brn);
                                        $sts = App\Models\statu::find($row->status);?>
                                <tr>
                                    <td>{{$counter}}</td>
                                    <td>{{$row->book_number}}</td>
                                    <td>{{$row->book_subj}}</td>
                                    <td>{{$row->type}}</td>
                                    <td>{{$row->from}}</td>
                                    <td>{{$row->receiver}}</td>
                                    <td>{{$dpm->name}}/{{$brn->name}}</td>
                                    <td>{{$row->receive_date}}</td>
                                    <td>
                                        @if ($row->status === '1')
                                            <button type="button" class="btn btn-outline-primary" disabled>{{$sts->name}}</button>
                                        @elseif ($row->status === '2')
                                            <button type="button" class="btn btn-success" disabled>{{$sts->name}}</button>
                                        @elseif ($row->status === '3')
                                            <button type="button" class="btn btn-danger" disabled>{{$sts->name}}</button>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" data-file-path="{{ asset('storage/uploads/' . $row->file) }}" class="btn btn-info viewPdfBtn">Book</button>
                                    </td>
                                    @if ($row->status === '1')
                                        @hasanyrole('employee|leader_dpm|ceo|admin')
                                            <td>
                                                <button type="button" class="btn btn-secondary" id="checkbtn" value="{{$row->id}}"><i class="bi bi-check2-square"></i></button>
                                            </td>
                                        @endhasanyrole
                                    @endif
                                </tr>
                                <?php $counter++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="tab-pane fade table-responsive" id="nav-anno" role="tabpanel" aria-labelledby="nav-anno-tab" tabindex="0">
                    <!-- Announce imported table -->
                    <table class="table table-hover mt-2 listTable">
                        <!-- Table Header -->
                        <thead class="table-dark">
                            <tr>
                            <th scope="col">#</th>
                                <th scope="col">เลขที่หนังสือ</th><?php $regData = \App\CoreFunction\Helper::regData();?>
                                <th scope="col">เรื่อง</th>
                                <th scope="col">ประเภทหนังสือ</th>
                                <th scope="col">ผู้ส่งหนังสือ</th>
                                <th scope="col">ผู้รับ</th>
                                <th scope="col">ฝ่ายผู้รับ</th>
                                <th scope="col">วันที่รับ</th>
                                <th scope="col">สถานะ</th>
                                <th scope="col">หนังสือ</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody class="table-group-divider" id="tableBody">
                            <?php  $counter = 1 ?>
                            @foreach ($imp_anno as $row)
                                <?php $dpm = App\Models\department::find($row->receiver_dpm);
                                        $brn = App\Models\branche::find($row->receiver_brn);
                                        $sts = App\Models\statu::find($row->status);?>
                                <tr>
                                    <td>{{$counter}}</td>
                                    <td>{{$row->book_number}}</td>
                                    <td>{{$row->book_subj}}</td>
                                    <td>{{$row->type}}</td>
                                    <td>{{$row->from}}</td>
                                    <td>{{$row->receiver}}</td>
                                    <td>{{$dpm->name}}/{{$brn->name}}</td>
                                    <td>{{$row->receive_date}}</td>
                                    <td>
                                        @if ($row->status === '1')
                                            <button type="button" class="btn btn-outline-primary" disabled>{{$sts->name}}</button>
                                        @elseif ($row->status === '2')
                                            <button type="button" class="btn btn-success" disabled>{{$sts->name}}</button>
                                        @elseif ($row->status === '3')
                                            <button type="button" class="btn btn-danger" disabled>{{$sts->name}}</button>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" data-file-path="{{ asset('storage/uploads/' . $row->file) }}" class="btn btn-info viewPdfBtn">Book</button>
                                    </td>
                                    @if ($row->status === '1')
                                        @hasanyrole('employee|leader_dpm|ceo|admin')
                                            <td>
                                                <button type="button" class="btn btn-secondary" id="checkbtn" value="{{$row->id}}"><i class="bi bi-check2-square"></i></button>
                                            </td>
                                        @endhasanyrole
                                    @endif
                                </tr>
                                <?php $counter++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="tab-pane fade table-responsive" id="nav-proj" role="tabpanel" aria-labelledby="nav-proj-tab" tabindex="0">
                    <!-- project imported table -->
                    <table class="table table-hover mt-2 listTable">
                        <!-- Table Header -->
                        <thead class="table-dark">
                            <tr>
                            <th scope="col">#</th>
                                <th scope="col">เลขที่หนังสือ</th><?php $regData = \App\CoreFunction\Helper::regData();?>
                                <th scope="col">เรื่อง</th>
                                <th scope="col">ประเภทหนังสือ</th>
                                <th scope="col">ผู้ส่งหนังสือ</th>
                                <th scope="col">ผู้รับ</th>
                                <th scope="col">ฝ่ายผู้รับ</th>
                                <th scope="col">วันที่รับ</th>
                                <th scope="col">สถานะ</th>
                                <th scope="col">หนังสือ</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody class="table-group-divider" id="tableBody">
                            <?php  $counter = 1 ?>
                            @foreach ($imp_proj as $row)
                                <?php $dpm = App\Models\department::find($row->receiver_dpm);
                                        $brn = App\Models\branche::find($row->receiver_brn);
                                        $sts = App\Models\statu::find($row->status);?>
                                <tr>
                                    <td>{{$counter}}</td>
                                    <td>{{$row->book_number}}</td>
                                    <td>{{$row->book_subj}}</td>
                                    <td>{{$row->type}}</td>
                                    <td>{{$row->from}}</td>
                                    <td>{{$row->receiver}}</td>
                                    <td>{{$dpm->name}}/{{$brn->name}}</td>
                                    <td>{{$row->receive_date}}</td>
                                    <td>
                                        @if ($row->status === '1')
                                            <button type="button" class="btn btn-outline-primary" disabled>{{$sts->name}}</button>
                                        @elseif ($row->status === '2')
                                            <button type="button" class="btn btn-success" disabled>{{$sts->name}}</button>
                                        @elseif ($row->status === '3')
                                            <button type="button" class="btn btn-danger" disabled>{{$sts->name}}</button>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" data-file-path="{{ asset('storage/uploads/' . $row->file) }}" class="btn btn-info viewPdfBtn">Book</button>
                                    </td>
                                    @if ($row->status === '1')
                                        @hasanyrole('employee|leader_dpm|ceo|admin')
                                            <td>
                                                <button type="button" class="btn btn-secondary" id="checkbtn" value="{{$row->id}}"><i class="bi bi-check2-square"></i></button>
                                            </td>
                                        @endhasanyrole
                                    @endif
                                </tr>
                                <?php $counter++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div> <!-- end tab-content -->
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
                language: {
                    search: "ค้นหา:"
                }
            });
        });
        const pdfButtons = document.querySelectorAll('.viewPdfBtn');
        pdfButtons.forEach((pdfbtn) => {
            pdfbtn.addEventListener('click', function () {
                const pdfUrl = this.getAttribute('data-file-path');

                Swal.fire({
                    showConfirmButton: false,
                    width: '70%',
                    html: '<div style="height: 600px;">' +
                        '<iframe src="' + pdfUrl + '" style="width: 100%; height: 100%;" frameborder="0"></iframe>' +
                        '</div>'
                });
            });
        });

        const checkbtn = document.querySelectorAll('#checkbtn');
        let statusValue;
        checkbtn.forEach((ckbtn) => {
            ckbtn.addEventListener('click', function () {
                Swal.fire({
                    title: 'ตอบรับหนังสือ',
                    html:
                        '<label for="swal-input1">ชื่อผู้ตอบรับ:</label>' +
                        '<input id="swal-input1" class="swal2-input">' +
                        '<label for="swal-input2">หมายเหตุ:</label>' +
                        '<input id="swal-input2" class="swal2-input">',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'ยอมรับ',
                    denyButtonText: 'ปฏิเสธ',
                    cancelButtonText: 'ยกเลิก',
                    preConfirm: () => {
                        const swalInput1Value = document.getElementById('swal-input1').value;
                        const swalInput2Value = document.getElementById('swal-input2').value;
                        return {
                            swalInput1: swalInput1Value,
                            swalInput2: swalInput2Value,
                        };
                    },
                    didOpen: () => {
                        // Disable the "Accept" and "Deny" buttons initially
                        const confirmButton = Swal.getConfirmButton();
                        const denyButton = Swal.getDenyButton();
                        confirmButton.disabled = true;
                        denyButton.disabled = true;

                        // Listen for changes in the input fields
                        const input1 = document.getElementById('swal-input1');

                        input1.addEventListener('input', () => {
                            confirmButton.disabled = input1.value.trim() === '';
                            denyButton.disabled = input1.value.trim() === '';
                        });
                    },
                }).then((result) => {
                    statusValue = ckbtn.value;
                    if (result.isConfirmed) {
                        saveData(1);
                    } else if (result.isDenied) {
                        saveData(0);
                    }
                });
            });
        });


        function saveData(res) {
            const swalInput1Value = document.getElementById('swal-input1').value;
            const swalInput2Value = document.getElementById('swal-input2').value;

            // Send data to Laravel controller using fetch API
            fetch('/form/import/upStatus', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                },
                body: JSON.stringify({
                    swalInput1: swalInput1Value,
                    swalInput2: swalInput2Value,
                    swalInput3: statusValue,
                    res: res,
                }),
            })
            .then((response) => response.json())
            .then((data) => {
                // Handle the response if needed
                // You can also reload the page to see the changes, if required
                window.location.reload();
            })
            .catch((error) => {
                // Handle errors if any
                Swal.fire('Error!', 'An error occurred while saving the data.', 'error');
            });
        }
    </script>
</body>
@endsection

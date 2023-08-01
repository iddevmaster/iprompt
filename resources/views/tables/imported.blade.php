@extends('layouts.app')

<!-- Scripts -->
@vite(['resources/css/table.css' , 'resources/js/table.js'])

@section('content')
<body>
<?php $regData = \App\CoreFunction\Helper::regData();?>
    <div class="container">
        <div class="text-center"><h2>Imported Document Table</h2></div>
        <div class="d-flex">
            <div class="flex-grow-1"><input type="text" id="searchInput" class="form-control mb-2" placeholder="Search..."></div>
            <div class="p-1 ms-2 export"><a class="a-tag" href=""><i class="bi bi-file-earmark-arrow-down"></i></a></div>
        </div>

        <!-- Table -->
        <div class="table-responsive mt-3">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all" aria-selected="true">All</button>
                    <button class="nav-link" id="nav-cont-tab" data-bs-toggle="tab" data-bs-target="#nav-cont" type="button" role="tab" aria-controls="nav-cont" aria-selected="false">Contract</button>
                    <button class="nav-link" id="nav-mou-tab" data-bs-toggle="tab" data-bs-target="#nav-mou" type="button" role="tab" aria-controls="nav-mou" aria-selected="false">MoU</button>
                    <button class="nav-link" id="nav-anno-tab" data-bs-toggle="tab" data-bs-target="#nav-anno" type="button" role="tab" aria-controls="nav-anno" aria-selected="false">Announcement</button>
                    <button class="nav-link" id="nav-proj-tab" data-bs-toggle="tab" data-bs-target="#nav-proj" type="button" role="tab" aria-controls="nav-proj" aria-selected="false">Project</button>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab" tabindex="0">

                    <!-- All imported table -->
                    <table class="table table-hover mt-2">
                        <!-- Table Header -->
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Book_num</th><?php $regData = \App\CoreFunction\Helper::regData();?>
                                <th scope="col">Subject</th>
                                <th scope="col">Type</th>
                                <th scope="col">Source</th>
                                <th scope="col">Receiver</th>
                                <th scope="col">Receiver_dpm</th>
                                <th scope="col">Receive_date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Book_file</th>
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
                                    <td>
                                        <button type="button" class="btn btn-secondary" id="checkbtn" value="{{$row->id}}"><i class="bi bi-check2-square"></i></button>
                                    </td>
                                    @endif
                                </tr>
                                <?php $counter++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="tab-pane fade" id="nav-cont" role="tabpanel" aria-labelledby="nav-cont-tab" tabindex="0">
                    <!-- Contract imported table -->
                    <table class="table table-hover mt-2">
                        <!-- Table Header -->
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Book_num</th><?php $regData = \App\CoreFunction\Helper::regData();?>
                                <th scope="col">Subject</th>
                                <th scope="col">Type</th>
                                <th scope="col">Source</th>
                                <th scope="col">Receiver</th>
                                <th scope="col">Receiver_dpm</th>
                                <th scope="col">Receive_date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Book_file</th>
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
                                    <td>
                                        <button type="button" class="btn btn-secondary" id="checkbtn" value="{{$row->id}}"><i class="bi bi-check2-square"></i></button>
                                    </td>
                                    @endif
                                </tr>
                                <?php $counter++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="tab-pane fade" id="nav-mou" role="tabpanel" aria-labelledby="nav-mou-tab" tabindex="0">
                    <!-- MOU imported table -->
                    <table class="table table-hover mt-2">
                        <!-- Table Header -->
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Book_num</th><?php $regData = \App\CoreFunction\Helper::regData();?>
                                <th scope="col">Subject</th>
                                <th scope="col">Type</th>
                                <th scope="col">Source</th>
                                <th scope="col">Receiver</th>
                                <th scope="col">Receiver_dpm</th>
                                <th scope="col">Receive_date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Book_file</th>
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
                                    <td>
                                        <button type="button" class="btn btn-secondary" id="checkbtn" value="{{$row->id}}"><i class="bi bi-check2-square"></i></button>
                                    </td>
                                    @endif
                                </tr>
                                <?php $counter++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="tab-pane fade" id="nav-anno" role="tabpanel" aria-labelledby="nav-anno-tab" tabindex="0">
                    <!-- Announce imported table -->
                    <table class="table table-hover mt-2">
                        <!-- Table Header -->
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Book_num</th><?php $regData = \App\CoreFunction\Helper::regData();?>
                                <th scope="col">Subject</th>
                                <th scope="col">Type</th>
                                <th scope="col">Source</th>
                                <th scope="col">Receiver</th>
                                <th scope="col">Receiver_dpm</th>
                                <th scope="col">Receive_date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Book_file</th>
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
                                    <td>
                                        <button type="button" class="btn btn-secondary" id="checkbtn" value="{{$row->id}}"><i class="bi bi-check2-square"></i></button>
                                    </td>
                                    @endif
                                </tr>
                                <?php $counter++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="tab-pane fade" id="nav-proj" role="tabpanel" aria-labelledby="nav-proj-tab" tabindex="0">
                    <!-- project imported table -->
                    <table class="table table-hover mt-2">
                        <!-- Table Header -->
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Book_num</th><?php $regData = \App\CoreFunction\Helper::regData();?>
                                <th scope="col">Subject</th>
                                <th scope="col">Type</th>
                                <th scope="col">Source</th>
                                <th scope="col">Receiver</th>
                                <th scope="col">Receiver_dpm</th>
                                <th scope="col">Receive_date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Book_file</th>
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
                                    <td>
                                        <button type="button" class="btn btn-secondary" id="checkbtn" value="{{$row->id}}"><i class="bi bi-check2-square"></i></button>
                                    </td>
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
    <script>
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
                    title: 'Accept or Deny?',
                    html:
                        '<input id="swal-input1" class="swal2-input">' +
                        '<input id="swal-input2" class="swal2-input">',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    denyButtonText: 'Deny',
                    preConfirm: () => {
                        const swalInput1Value = document.getElementById('swal-input1').value;
                        const swalInput2Value = document.getElementById('swal-input2').value;

                        return {
                            swalInput1: swalInput1Value,
                            swalInput2: swalInput2Value,
                        };
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
                    Swal.fire('Saved!', '', 'success');
                    // You can also reload the page to see the changes, if required
                    // window.location.reload();
                })
                .catch((error) => {
                    // Handle errors if any
                    Swal.fire('Error!', 'An error occurred while saving the data.', 'error');
                });
        }
    </script>
</body>
@endsection
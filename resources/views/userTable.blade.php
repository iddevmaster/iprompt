@extends('layouts.app')

<!-- Scripts -->
@vite(['resources/css/table.css' , 'resources/js/table.js'])
@section('content')

<body>
    <div class="container">
        <div class="text-center"><h2>User Table</h2></div>
        <div class="d-flex my-4 justify-content-end">
            <div class="p-1 ms-2 export"><a class="a-tag" href="#"><i class="bi bi-file-earmark-arrow-down"></i></a></div>
            <a href="{{ route('users.create') }}"><button type="button" class="btn btn-success"><i class="bi bi-person-plus"></i></button></a>
        </div>
        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover listTable">

                <!-- Table Header -->
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">name</th>
                        <th scope="col">username</th>
                        <th scope="col">role</th>
                        <th scope="col">agency</th>
                        <th scope="col">branch</th>
                        <th scope="col">Dpm</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="table-group-divider" id="tableBody">
                    <!-- Table rows will be dynamically added here -->
                    <?php  $counter = 1 ?>
                    @foreach ($user as $row)
                        {{-- <tr onclick="navigateToUserDetails('{{ $row->id }}')"> --}}
                        <tr>
                            <td>{{$counter}}</td>
                            <td>{{ $row->name}}</td>
                            <td>{{ $row->email}}</td>
                            <td>
                                @foreach ($row->getRoleNames() as $role)
                                    {{ $role }}
                                @endforeach
                            </td>
                            <td>
                                <?php echo $agn->firstWhere('id', $row->agency)->name ?? '-Unknow-'; ?>
                            </td>
                            <td>
                                <?php echo $brn->firstWhere('id', $row->branch)->name ?? '-Unknow-'; ?>
                            </td>
                            <td class="truncate">
                                <?php echo $dpm->firstWhere('id', $row->dpm)->name ?? '-Unknow-'; ?>
                            </td>
                            <td>
                                <a href="{{ route('userProfile', ['id'=> $row->id]) }}" class="btn btn-primary"><i class="bi bi-list-ul"></i></a>
                                <button class="btn btn-danger btn-sm deleteUserBtn"  user_id="{{ $row->id }}"><i class="bi bi-trash"></i></button>
                            </td>

                        </tr>
                        <?php $counter++ ?>
                    @endforeach
                </tbody>
                <script>
                    function navigateToUserDetails(userId) {
                        window.location.href = '/userProfile/' + userId;
                    }
                </script>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://fastly.jsdelivr.net/npm/sweetalert2@11"></script>
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

            $(document).on('click', '.deleteUserBtn', function() {
                var userId = $(this).attr('user_id');
                Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: "คุณจะไม่สามารถย้อนกลับได้!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ลบเลย!',
                    cancelButtonText: 'ยกเลิก',
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/user/delete/` + userId, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                        })
                        .then(response => {
                            if (response.ok) {
                                // Handle success
                                Swal.fire(
                                    'ลบสำเร็จ!',
                                    'ข้อมูลถูกลบเรียบร้อยแล้ว',
                                    'success'
                                ).then(() => {
                                    location.reload(); // Reload the page after deletion
                                });
                            } else {
                                // Handle error
                                Swal.fire(
                                    'เกิดข้อผิดพลาด!',
                                    'เกิดข้อผิดพลาดในการลบข้อมูล',
                                    'error'
                                );
                            }
                        })
                    }
                })
            });
        });
    </script>
</body>
@endsection

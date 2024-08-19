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
                        <th scope="col">Phone</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="table-group-divider" id="tableBody">
                    <!-- Table rows will be dynamically added here -->
                    <?php  $counter = 1 ?>
                    @foreach ($user as $row)
                        <tr onclick="navigateToUserDetails('{{ $row->id }}')">
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
                            <td>{{ $row->phone}}</td>

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
    </script>
</body>
@endsection

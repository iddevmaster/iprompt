@extends('layouts.app')

<!-- Scripts -->
@vite(['resources/css/table.css' , 'resources/js/table.js'])
@section('content')
<body>
    <div class="container">
        <div class="card mb-4">
            <h5 class="card-header">
                User problem report
            </h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover listTable">
                        <!-- Table Header -->
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th class="col-8">problem</th>
                                <th>User</th>
                                <th>date</th>
                                <th>status</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody class="table-group-divider" id="tableBody">
                            <!-- Table rows will be dynamically added here -->
                            <?php  $counter = 1 ?>
                            @foreach ($wait_issues as $row)
                                <tr>
                                    <td>{{$counter}}</td>
                                    <td style="overflow-wrap: anywhere">{{ $row->prob_datail }}</td>
                                    <td>
                                        @php
                                            $submitUser = App\Models\User::find($row->user_id);
                                            echo $submitUser ? $submitUser->name : 'Unknown';
                                        @endphp
                                    </td>
                                    <td>{{ $row->created_at }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info" id="statusbtn" value="{{$row->id}}">{{$row->status}}</button>
                                    </td>
                                </tr>
                                <?php $counter++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <h5 class="card-header">
                Finish problem
            </h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover listTable">
                        <!-- Table Header -->
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th class="col-8">problem</th>
                                <th>User</th>
                                <th>date</th>
                                <th>status</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody class="table-group-divider" id="tableBody">
                            <!-- Table rows will be dynamically added here -->
                            <?php  $counter = 1 ?>
                            @foreach ($success_issue as $row)
                                <tr>
                                    <td>{{$counter}}</td>
                                    <td style="overflow-wrap: anywhere">{{ $row->prob_datail }}</td>
                                    <td>
                                        @php
                                            $submitUser = App\Models\User::find($row->user_id);
                                            echo $submitUser ? $submitUser->name : 'Unknown';
                                        @endphp
                                    </td>
                                    <td>{{ $row->created_at }}</td>
                                    <td>
                                        <button type="button" class="btn btn-secondary" disabled>{{$row->status}}</button>
                                    </td>
                                </tr>
                                <?php $counter++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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


        const issuebtns2 = document.querySelectorAll('#statusbtn');
        issuebtns2.forEach((ckbtn) => {
            const issueId = ckbtn.value;
            ckbtn.addEventListener('click', function () {
                    fetch('/issue/report/fixed', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                        },
                        body: JSON.stringify({
                            value: issueId
                        }),
                    }).then((response) => response.json())
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
            });
        });
    </script>
</body>
@endsection

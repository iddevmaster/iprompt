@extends('layouts.app')

<!-- Scripts -->
@vite(['resources/css/table.css' , 'resources/js/table.js'])

@section('content')
<body>
    <div class="container">
        <div class="text-center"><h2>Wi Table</h2></div>
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
                        <th scope="col">Creater</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Created_date</th>
                        <th scope="col">Submit_by</th>
                        <th scope="col">Edit</th>
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
                            <td>{{ $row->bcreater}}</td>
                            <td class="truncate">{{ $row->title}}</td>
                            <td>{{ $row->created_date}}</td>
                            <td>
                                @php
                                    $submitUser = $user->firstWhere('id', $row->submit_by);
                                    echo $submitUser ? $submitUser->name : 'Unknown';
                                @endphp
                            </td>
                            <td>
                                <a href="{{url('/form/editwi/'.$row->id)}}"><button type="button" class="btn btn-warning">Edit</button></a>
                            </td>
                            <td>
                                <a href="{{url('/form/downloadwi/'.$row->id)}}" target="_blank"><button type="button" class="btn btn-primary">Download</button></a>
                            </td>
                        </tr>
                        <?php $counter++ ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
@endsection
@extends('layouts.app')

<!-- Scripts -->
@vite(['resources/css/table.css' , 'resources/js/table.js'])
@section('content')
<body>
    <div class="container">
        <div class="card mb-4">
            <h5 class="card-header">
                Permission
            </h5>
            <div class="card-body">
                <label for="perData" class="form-label">Add</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Entry permission" aria-label="Recipient's username" aria-describedby="basic-addon2" id="perData">
                    <button class="btn btn-success" onclick="addBtn()" id="addPer"><i class="bi bi-plus-lg"></i></button>
                </div>

                <label for="perFetch" class="form-label">Delete</label>
                <div class="input-group mb-3">
                    <select class="form-select" aria-label="Default select example" id="perFetch">
                        <option selected disabled>Select permission</option>
                        @foreach ($permis as $per)
                            <option value="{{$per->name}}">{{$per->name}}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-danger" onclick="deleteBtn()" id="delPer"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        </div>

        <div class="card">
            <h5 class="card-header">
                Type
            </h5>
            <div class="card-body">
                <label for="perFetch" class="form-label">Delete</label>
                <div class="input-group mb-3">
                    <select class="form-select" aria-label="Default select example" id="typeSel">
                        <option selected disabled>Select Type</option>
                        @foreach (App\Models\type::all() as $per)
                            <option value="{{$per->id}}">{{$per->type}} / {{$per->subtype}}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-danger" onclick="deleteType()" id="delType"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        </div>

    </div>

    <script>
        const perData = document.querySelector('#perData');
        const delData = document.querySelector('#perFetch');
        const delTypeData = document.querySelector('#typeSel');
        function addBtn() {
            fetch('permission/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                },
                body: JSON.stringify({
                    value: perData.value,
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
        };

        function deleteBtn() {
            fetch('permission/del', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                },
                body: JSON.stringify({
                    value: delData.value,
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

        function deleteType() {
            fetch('type/del', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                },
                body: JSON.stringify({
                    value: delTypeData.value,
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
    </script>
</body>
@endsection

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

        <div class="card mb-4">
            <h5 class="card-header">
                Role
            </h5>
            <div class="card-body">
                <label for="rolData" class="form-label">Add</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Entry role" aria-label="Recipient's username" aria-describedby="basic-addon2" id="rolData">
                    <button class="btn btn-success" onclick="addrBtn()" id="addRol"><i class="bi bi-plus-lg"></i></button>
                </div>

                <label for="rolFetch" class="form-label">Delete</label>
                <div class="input-group mb-3">
                    <select class="form-select" aria-label="Default select example" id="rolFetch">
                        <option selected disabled>Select permission</option>
                        @foreach ($roles as $role)
                            <option value="{{$role->name}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-danger" onclick="deleterBtn()" id="delRol"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        </div>

        <div class="card mb-4">
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

        <div class="card mb-4">
            <h5 class="card-header">
                Agencie
            </h5>
            <div class="card-body">
                <label for="agnData" class="form-label">Add</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Entry Agencie" aria-label="Recipient's username" aria-describedby="basic-addon2" id="agnData">
                    <button class="btn btn-success" onclick="addAgn()" id="addAgn"><i class="bi bi-plus-lg"></i></button>
                </div>

                <label for="agnFetch" class="form-label">Delete</label>
                <div class="input-group mb-3">
                    <select class="form-select" aria-label="Default select example" id="agnFetch">
                        <option selected disabled>Select Agencie</option>
                        @foreach ($agen as $role)
                            <option value="{{$role->name}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-danger" onclick="deleteAgn()" id="delAgn"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">
                Branch
            </h5>
            <div class="card-body">
                <label for="brnData" class="form-label">Add</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Entry Branch" aria-label="Recipient's username" aria-describedby="basic-addon2" id="brnData">
                    <select class="form-select" aria-label="Default select example" id="brnAgn">
                        <option selected disabled>Select Agencie</option>
                        @foreach ($agen as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-success" onclick="addBrn()" id="addBrn"><i class="bi bi-plus-lg"></i></button>
                </div>

                <label for="brnFetch" class="form-label">Delete</label>
                <div class="input-group mb-3">
                    <select class="form-select" aria-label="Default select example" id="brnFetch">
                        <option selected disabled>Select Branch</option>
                        @foreach ($branch as $role)
                            <option value="{{$role->name}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-danger" onclick="deleteBrn()" id="delBrn"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">
                Department
            </h5>
            <div class="card-body">
                <label for="dpmData" class="form-label">Add</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Department name" aria-label="Recipient's username" aria-describedby="basic-addon2" id="dpmData">
                    <input type="text" class="form-control" placeholder="Department prefix" aria-label="Recipient's username" aria-describedby="basic-addon2" id="dpmPrefix">
                    <select class="form-select" aria-label="Default select example" id="dpmBrn">
                        <option selected disabled>Select Branch</option>
                        @foreach ($branch as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-success" onclick="addDpm()" id="addDpm"><i class="bi bi-plus-lg"></i></button>
                </div>

                <label for="dpmFetch" class="form-label">Delete</label>
                <div class="input-group mb-3">
                    <select class="form-select" aria-label="Default select example" id="dpmFetch">
                        <option selected disabled>Select Department</option>
                        @foreach ($dpms as $role)
                            <option value="{{$role->name}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-danger" onclick="deleteDpm()" id="delDpm"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const perData = document.querySelector('#perData');
        const delData = document.querySelector('#perFetch');
        const rolData = document.querySelector('#rolData');
        const delrData = document.querySelector('#rolFetch');
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

        function addrBtn() {
            fetch('role/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                },
                body: JSON.stringify({
                    value: rolData.value,
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

        function deleterBtn() {
            fetch('role/del', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                },
                body: JSON.stringify({
                    value: delrData.value,
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

        const agnData = document.querySelector('#agnData');
        function addAgn() {
            fetch('agn/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                },
                body: JSON.stringify({
                    value: agnData.value,
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

        const agnDel = document.querySelector('#agnFetch');
        function deleteAgn() {
            fetch('agn/del', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                },
                body: JSON.stringify({
                    value: agnDel.value,
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

        const brnData = document.querySelector('#brnData');
        const brnAgn = document.querySelector('#brnAgn');
        function addBrn() {
            fetch('brn/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                },
                body: JSON.stringify({
                    value: brnData.value,
                    brnagn: brnAgn.value,
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

        const brnDel = document.querySelector('#brnFetch');
        function deleteBrn() {
            fetch('brn/del', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                },
                body: JSON.stringify({
                    value: brnDel.value,
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

        const dpmData = document.querySelector('#dpmData');
        const dpmPre = document.querySelector('#dpmPrefix');
        const dpmBrn = document.querySelector('#dpmBrn');
        function addDpm() {
            fetch('dpm/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                },
                body: JSON.stringify({
                    value: dpmData.value,
                    prefix: dpmPre.value,
                    brnagn: dpmBrn.value,
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

        const dpmDel = document.querySelector('#dpmFetch');
        function deleteDpm() {
            fetch('dpm/del', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                },
                body: JSON.stringify({
                    value: dpmDel.value,
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
    </script>
</body>
@endsection

@extends('layouts.app')

<!-- Scripts -->
<style>
    label{
        min-width: 200px;
    }
</style>

@section('content')
<body>
    <?php $regData = \App\CoreFunction\Helper::regData();?>
    <div class="container">
        <div class="row d-flex justify-content-center text-center">
            <h2 class="my-3">Imported Document</h2>

            <div class="card p-4 ">
                <form action="{{route('storeImported')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="docType" class="col-form-label">Doc Type</label>
                        </div>
                        <div class="col-8">
                            <select class="form-select" aria-label="Default select example" name="doctype" required>
                                <option selected disabled>Open this select type</option>
                                <option value="proj">Project</option>
                                <option value="cont">Contract</option>
                                <option value="mou">MoU</option>
                                <option value="anno">Announcement</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="recorder" class="col-form-label">Recorder</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="recorder" id="recorder" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="recivedate" class="col-form-label">Recived Date</label>
                        </div>
                        <div class="col-8">
                        <input type="date" name="recivedate" id="recivedate" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="receiver" class="col-form-label">Receiver Name</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="receiver" id="receiver" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="receiver_dpm" class="col-form-label">Receiver Dpm</label>
                        </div>
                        <div class="col-8">
                            <select class="form-select" aria-label="Default select example" name="recive_dpm" required>
                                <option selected disabled>Open this select Department</option>
                                @foreach ($regData['department'] as $dpm)
                                    <option value="{{$dpm->id}}">{{$dpm->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="receiver_agn" class="col-form-label">Receiver Agency</label>
                        </div>
                        <div class="col-8">
                            <select class="form-select" aria-label="Default select example" name="recive_agn" required>
                                <option selected disabled>Open this select Agency</option>
                                @foreach ($regData['agencie'] as $agn)
                                    <option value="{{$agn->id}}">{{$agn->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="receiver_brn" class="col-form-label">Receiver branch</label>
                        </div>
                        <div class="col-8">
                            <select class="form-select" aria-label="Default select example" name="recive_brn" required>
                                <option selected disabled>Open this select Branch</option>
                                @foreach ($regData['branche'] as $brn)
                                    <option value="{{$brn->id}}">{{$brn->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="source" class="col-form-label">Source</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="source" id="source" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="book_num" class="col-form-label">Book Number</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="book_num" id="book_num" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="book_subj" class="col-form-label">Book Subject</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="book_subj" id="book_subj" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="book_file" class="col-form-label">File</label>
                        </div>
                        <div class="col-8">
                            <input class="form-control mb-2" type="file" id="book_file" name="file">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <button id="cancel" type="button" class="btn btn-danger ms-2" >Cancel</button>
                            <button type="submit" class="btn btn-success ms-2" >Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('cancel').addEventListener('click', function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route('home') }}';
            }
        })
    });
</script>

@endsection
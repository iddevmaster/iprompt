@extends('layouts.app')

<!-- Scripts -->
@vite(['resources/css/imported.css' , 'resources/js/imported.js'])

@section('content')

<body>
    <?php $regData = \App\CoreFunction\Helper::regData();?>
    <div class="container">
        <div class="row d-flex justify-content-center text-center">
            <h2 class="my-3">Imported Document</h2>

            <div class="card p-4 ">
                <form action="" method="post">
                    @csrf
                    
                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="docType" class="col-form-label">Doc Type</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="docType" id="docType" class="form-control">
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="recorder" class="col-form-label">Recorder</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="recorder" id="recorder" class="form-control">
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="recivedate" class="col-form-label">Recived Date</label>
                        </div>
                        <div class="col-8">
                            <input type="date" name="recivedate" id="recivedate" class="form-control">
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="book_num" class="col-form-label">Book Number</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="book_num" id="book_num" class="form-control">
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="receiver" class="col-form-label">Receiver Name</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="receiver" id="receiver" class="form-control">
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="receiver_dpm" class="col-form-label">Receiver Dpm</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="receiver_dpm" id="receiver_dpm" class="form-control">
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="receiver_brn" class="col-form-label">Receiver branch</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="receiver_brn" id="receiver_brn" class="form-control">
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="receiver_agn" class="col-form-label">Receiver Agency</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="receiver_agn" id="receiver_agn" class="form-control">
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="source" class="col-form-label">Source</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="source" id="source" class="form-control">
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="book_subj" class="col-form-label">Book Subject</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="book_subj" id="book_subj" class="form-control">
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="book_file" class="col-form-label">File</label>
                        </div>
                        <div class="col-8">
                            <input class="form-control mb-2" type="file" id="book_file" multiple>
                            <p class="text-success" for="book_file" id="file_label"></p>
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
<script>
    document.getElementById('cancel').addEventListener('click', function () {
        Swal.fire({
            title
        });
    });
</script>

@endsection
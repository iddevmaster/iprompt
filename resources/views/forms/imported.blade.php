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
            <h2 class="my-3">ลงทะเบียนรับเข้าหนังสือ</h2>

            <div class="card p-4 ">
                <form action="{{route('storeImported')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="docType" class="col-form-label">ประเภทหนังสือ</label>
                        </div>
                        <div class="col-8 d-flex">
                            <select class="form-select" aria-label="Default select example" name="doctype" required>
                                <option selected disabled>เลือกประเภทหนังสือรับเข้า</option>
                                @foreach ($impd as $imp)
                                    <option value="{{$imp->val}}">{{$imp->name}}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-success ms-2" style="width:40px;height:35px" id="addTypebtn"><i class="bi bi-plus-square"></i></button>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="recorder" class="col-form-label">ผู้ลงทะเบียน</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="recorder" id="recorder" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="recivedate" class="col-form-label">วันที่รับเข้า</label>
                        </div>
                        <div class="col-8">
                        <input type="date" name="recivedate" id="recivedate" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="receiver" class="col-form-label">ชื่อผู้รับ</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="receiver" id="receiver" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="receiver_dpm" class="col-form-label">ฝ่ายผู้รับ</label>
                        </div>
                        <div class="col-8">
                            <select class="form-select" aria-label="Default select example" name="recive_dpm" required>
                                <option selected disabled>กรุณาเลือกฝ่าย</option>
                                @foreach ($regData['department'] as $dpm)
                                    <option value="{{$dpm->id}}">{{$dpm->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="receiver_agn" class="col-form-label">หน่วยงานผู้รับ</label>
                        </div>
                        <div class="col-8">
                            <select class="form-select" aria-label="Default select example" name="recive_agn" required>
                                <option selected disabled>กรุณาเลือกหน่วยงานผู้รับ</option>
                                @foreach ($regData['agencie'] as $agn)
                                    <option value="{{$agn->id}}">{{$agn->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="receiver_brn" class="col-form-label">สาขาผู้รับ</label>
                        </div>
                        <div class="col-8">
                            <select class="form-select" aria-label="Default select example" name="recive_brn" required>
                                <option selected disabled>กรุณาเลือกสาขาผู้รับ</option>
                                @foreach ($regData['branche'] as $brn)
                                    <option value="{{$brn->id}}">{{$brn->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="source" class="col-form-label">แหล่งที่มา</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="source" id="source" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="book_num" class="col-form-label">เลขที่หนังสือ</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="book_num" id="book_num" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="book_subj" class="col-form-label">เรื่อง</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="book_subj" id="book_subj" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 d-flex justify-content-center">
                        <div class="col-auto">
                            <label for="book_file" class="col-form-label">ไฟล์หนังสือ</label>
                        </div>
                        <div class="col-8">
                            <input class="form-control mb-2" type="file" id="book_file" name="file">
                        </div>
                    </div>

                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <button id="cancel" type="button" class="btn btn-danger ms-2" >ยกเลิก</button>
                            <button type="submit" class="btn btn-success ms-2" >บันทึก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('cancel').addEventListener('click', function () {
        Swal.fire({
            title: 'ยกเลิกการบันทึกข้อมูล?',
            text: "ข้อมูลของคุณจะถูกลบ!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ตกลง!',
            cancelButtonText: 'ย้อนกลับ'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route('home') }}';
            }
        })
    });

    document.getElementById('addTypebtn').addEventListener('click', () => {
        Swal.fire({
            title: 'เพิ่มประเภทหนังสือรับเข้า',
            input: 'text',
            inputLabel: 'ประเภทหนังสือรับเข้า',
            showCancelButton: true,
            confirmButtonText: 'บันทึก',
            cancelButtonText: 'ยกเลิก',
            inputValidator: (value) => {
                if (!value) {
                return 'กรุณากรอกประเภทหนังสือ!'
                }
            }
        }).then( async (result) => {
            if (result.isConfirmed) {
                await saveData(result.value);
            }
        })
    })

    function saveData (docType) {
        console.log(docType);
        fetch('/imported/addtype', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
            },
            body: JSON.stringify({
                doct: docType,
            }),
        }).then((response) => response.json())
        .then((data) => {
            window.location.reload();
        })
        .catch((error) => {
            console.log('error: ' + error);
        });
    }
</script>
</body>

@endsection

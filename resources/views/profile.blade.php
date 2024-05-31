@extends('layouts.app')
@section('content')
<style>
    .col {
    min-width: 300px;
    flex-wrap: wrap;
}
.gapp {
    gap: 20px;
}
</style>
<body>
    <script> let editper = 0; </script>
    <div class="container">
        <form action="">
            @csrf
            <div class="row gapp">
                <div class="col card border  p-4 d-flex flex-column mb-3">
                    <div class="text-center fw-bold fs-5 mb-3"><p>User Information</p></div>
                    <input type="hidden" id="userid" value="{{$user->id ?? '00'}}">
                    <div class="mb-3 d-flex">
                        <label for="name" class="form-label">Name:</label>
                        <input class="form-control ms-2" id="name" type="text" value="{{$user->name ?? '-Unknow-'}}" disabled>
                    </div>
                    <div class="d-flex mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input class="form-control ms-2" id="username" type="text" value="{{$user->email ?? '-Unknow-'}}" disabled>
                    </div>
                    <div class="d-flex mb-3">
                        <label for="dpm" class="form-label">Department:</label>
                        <select class="form-select ms-2" aria-label="dpm" id="dpm" disabled>
                            @foreach ($dpm as $dpm)
                                @if ($dpm->id == $user->dpm)
                                    <option value="{{$dpm->id}}" selected>{{$dpm->name}}</option>
                                @else
                                    <option value="{{$dpm->id}}">{{$dpm->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex mb-3">
                        <label for="agn" class="form-label">Agency:</label>
                        <select class="form-select ms-2" aria-label="agn" id="agn" disabled>
                            @foreach ($agn as $agn)
                                @if ($agn->id == $user->agency)
                                    <option value="{{$agn->id}}" selected>{{$agn->name}}</option>
                                @else
                                    <option value="{{$agn->id}}">{{$agn->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex mb-3">
                        <label for="brn" class="form-label">Branch:</label>
                        <select class="form-select ms-2" aria-label="brn" id="brn" disabled>
                            @foreach ($brn as $brn)
                                @if ($brn->id == $user->branch)
                                    <option value="{{$brn->id}}" selected>{{$brn->name}}</option>
                                @else
                                    <option value="{{$brn->id}}">{{$brn->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    @hasrole('admin')
                        <div class="d-flex mb-3">
                            <label for="role" class="form-label">Role:</label>
                            <select class="form-select ms-2" aria-label="role" id="role" disabled>
                                @foreach ($role as $role)
                                    @if ($role->name === $user->role)
                                        <option value="{{$role->name}}" selected>{{$role->name}}</option>
                                    @else
                                        <option value="{{$role->name}}">{{$role->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    @endhasrole
                    <div class="d-flex mb-4">
                        <label for="phone" class="form-label">Phone:</label>
                        <input class="form-control ms-2" id="phone" type="text" value="{{$user->phone ?? '-Unknow-'}}" disabled>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex">
                            <label for="formFile" class="form-label">Sign:</label>
                            <input class="form-control ms-2" type="file" id="sign" accept="image/png, image/jpeg" disabled>
                        </div>
                        <p style="font-size: 10px; color:rgb(148, 148, 0)">ขนาดที่แนะนำ 5MB ความกว้าง 100px, ความสูง 50px (26*13 mm), ประเภทไฟล์ png, jpeg</p>
                    </div>
                    <div class="mb-4">
                        <label for="formFile" class="form-label">Sign example:</label>
                        @if ($user->image)
                            <img src="/files/signs/{{$user->image}}" alt="sign" class="img-thumbnail" style="width: 100px; height: 50px;">
                        @else
                            <p class="badge text-bg-secondary">Sign not found</p>
                        @endif
                    </div>
                    <div class="d-flex justify-content-center mt-auto">
                        <a href="{{url('/change-password/'.$user->id)}}"><button type="button" class="btn btn-secondary">เปลี่ยนรหัสผ่าน</button></a>
                        <button type="button" id="editbtn" class="btn btn-primary ms-2" data-bs-toggle="button">Edit</button>
                    </div>
                </div>


                <div class="col border card p-4" id="permCard">
                    <div class="text-center fs-5 fw-bold mb-3"><p>Permissions</p></div>
                    <div class="d-flex border-bottom">
                        <p class="ms-3 fw-bold">Download : </p>
                        <div class="form-check mx-3">
                            <input class="form-check-input" type="radio" name="download" value="1" id="down_yes" disabled>
                            <label class="form-check-label" for="down_yes">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="download" value="0" id="down_no" disabled>
                            <label class="form-check-label" for="down_no">No</label>
                        </div>
                    </div>
                    @if($user->can('download'))
                        <script>
                            document.getElementById('down_yes').checked = true;
                            document.getElementById('down_no').checked = false;
                        </script>
                    @else
                        <script>
                            document.getElementById('down_yes').checked = false;
                            document.getElementById('down_no').checked = true;
                        </script>
                    @endif


                    <div class="d-flex mt-4 border-bottom">
                        <p class="ms-3 fw-bold">Confirmable : </p>
                        <div class="form-check mx-3">
                            <input class="form-check-input" type="checkbox" value="" id="approver" disabled>
                            <label class="form-check-label" for="approver">
                            Approver
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="inspector" disabled>
                            <label class="form-check-label" for="inspector">
                            Inspector
                            </label>
                        </div>
                    </div>
                    @if($user->can('approve'))
                        <script>document.getElementById('approver').checked = true;</script>
                    @else
                        <script>document.getElementById('approver').checked = false;</script>
                    @endif
                    @if($user->can('inspect'))
                        <script>document.getElementById('inspector').checked = true;</script>
                    @else
                        <script>document.getElementById('inspector').checked = false;</script>
                    @endif

                    <p class="mt-4 ms-3 fw-bold text-center">Accessability</p>

                    <p class="mt-4 ms-3 fw-bold">Table :</p>
                    <div class="d-flex ms-4">
                        <div class="row">
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="WI" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    WI
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="SOP" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    SOP
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="POL" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Policy
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="PRO" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Project
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="MOU" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    MOU
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="ANNO" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Announcement
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="CONT" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Contract
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="checklist" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    CheckList
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="course" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Course
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="media" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Media
                                </label>
                            </div>
                        </div>
                    </div>

                    <p class="mt-4 ms-3 fw-bold">Create :</p>
                    <div class="d-flex ms-4">
                        <div class="row">
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="cWI" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    WI
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="cSOP" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    SOP
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="cPOL" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Policy
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="cPRO" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Project
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="cMOU" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    MOU
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="cANNO" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Announcement
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="cCONT" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Contract
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="ccheck" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    CheckList
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="ccourse" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Course
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="cmedia" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Media
                                </label>
                            </div>
                        </div>
                    </div>

                    <p class="mt-4 ms-3 fw-bold">Other :</p>
                    <div class="d-flex ms-4">
                        <div class="row">
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="staff" disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Staff
                                </label>
                            </div>
                            <div class="form-check mx-3 col-lg-3 col-md-6">
                                <input class="form-check-input" type="checkbox" value="" id="addProjCode" disabled>
                                <label class="form-check-label" for="addProjCode">
                                    AddProjectcode
                                </label>
                            </div>
                        </div>
                    </div>
                    @foreach ($permissions as $perm)
                        @if($user->can($perm->name))
                            <script>document.getElementById('{{ $perm->name }}').checked = true;</script>
                        @else
                            <script>document.getElementById('{{ $perm->name }}').checked = false;</script>
                        @endif
                    @endforeach
                </div>
                <script src="https://fastly.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        const editbtn = document.getElementById('editbtn');
                        const name = document.getElementById('name');
                        const username = document.getElementById('username');
                        const dpm = document.getElementById('dpm');
                        const agn = document.getElementById('agn');
                        const brn = document.getElementById('brn');
                        const phone = document.getElementById('phone');
                        const sign = document.getElementById('sign');
                        const  down_yes = document.getElementById('down_yes');
                        const down_no = document.getElementById('down_no');
                        // const create_yes = document.getElementById('create_yes');
                        // const create_no = document.getElementById('create_no');
                        const approver = document.getElementById('approver');
                        const inspector = document.getElementById('inspector');

                        const wi = document.getElementById('WI');
                        const sop = document.getElementById('SOP');
                        const check = document.getElementById('checklist');
                        const course = document.getElementById('course');
                        const media = document.getElementById('media');
                        const pol = document.getElementById('POL');
                        const pro = document.getElementById('PRO');
                        const mou = document.getElementById('MOU');
                        const anno = document.getElementById('ANNO');
                        const cont = document.getElementById('CONT');

                        const cwi = document.getElementById('cWI');
                        const csop = document.getElementById('cSOP');
                        const ccheck = document.getElementById('ccheck');
                        const ccourse = document.getElementById('ccourse');
                        const cmedia = document.getElementById('cmedia');
                        const cpol = document.getElementById('cPOL');
                        const cpro = document.getElementById('cPRO');
                        const cmou = document.getElementById('cMOU');
                        const canno = document.getElementById('cANNO');
                        const ccont = document.getElementById('cCONT');

                        const staff = document.getElementById('staff');
                        const addProjCode = document.getElementById('addProjCode');

                        const userid = document.getElementById('userid');
                        const role = document.getElementById('role');
                        let userRole = "{{ Auth::user()->role }}";
                        const permCard = document.querySelector('#permCard');
                        if (!(userRole === 'admin' || userRole === 'ceo')) {
                            permCard.style.cssText += 'display: none';
                        }

                        editbtn.addEventListener('click', () => {
                            if (editbtn.textContent === 'Edit') {
                                name.disabled = false;
                                username.disabled = false;
                                phone.disabled = false;
                                sign.disabled = false;

                                if ( userRole == 'admin') {
                                    role.disabled = false;
                                    dpm.disabled = false;
                                    agn.disabled = false;
                                    brn.disabled = false;

                                    // Download
                                    down_yes.disabled = false;
                                    down_no.disabled = false;

                                    // Create
                                    // create_yes.disabled = false;
                                    // create_no.disabled = false;

                                    // Confirmable
                                    approver.disabled = false;
                                    inspector.disabled = false;


                                    // Access
                                    wi.disabled = false;
                                    sop.disabled = false;
                                    pol.disabled = false;
                                    pro.disabled = false;
                                    mou.disabled = false;
                                    anno.disabled = false;
                                    cont.disabled = false;
                                    check.disabled = false;
                                    course.disabled = false;
                                    media.disabled = false;

                                    cwi.disabled = false;
                                    csop.disabled = false;
                                    cpol.disabled = false;
                                    cpro.disabled = false;
                                    cmou.disabled = false;
                                    canno.disabled = false;
                                    ccont.disabled = false;
                                    ccheck.disabled = false;
                                    ccourse.disabled = false;
                                    cmedia.disabled = false;

                                    staff.disabled = false;
                                    addProjCode.disabled = false;
                                };
                                editbtn.textContent = 'Save';
                            } else {
                                const download = document.querySelector('input[name="download"]:checked').value;
                                // const create = document.querySelector('input[name="create"]:checked').value;

                                let formData = new FormData();
                                formData.append('id', userid.value);
                                formData.append('name', name.value);
                                formData.append('username', username.value);
                                formData.append('dpm', dpm.value);
                                formData.append('agn', agn.value);
                                formData.append('brn', brn.value);
                                formData.append('phone', phone.value);
                                formData.append('sign', sign.files[0]);
                                formData.append('role', role && role.value ? role.value : userRole);
                                formData.append('permiss', JSON.stringify({
                                    // permission,
                                    download: (download == 1 ? true : false),
                                    approve: approver.checked,
                                    inspect: inspector.checked,

                                    WI: wi.checked,
                                    SOP: sop.checked,
                                    POL: pol.checked,
                                    PRO: pro.checked,
                                    MOU: mou.checked,
                                    ANNO: anno.checked,
                                    CONT: cont.checked,
                                    checklist: check.checked,
                                    course: course.checked,
                                    media: media.checked,

                                    cWI: cwi.checked,
                                    cSOP: csop.checked,
                                    cPOL: cpol.checked,
                                    cPRO: cpro.checked,
                                    cMOU: cmou.checked,
                                    cANNO: canno.checked,
                                    cCONT: ccont.checked,
                                    ccheck: ccheck.checked,
                                    ccourse: ccourse.checked,
                                    cmedia: cmedia.checked,

                                    staff: staff.checked,
                                    addProjCode: addProjCode.checked,
                                }));

                                const response = fetch('/users/update', {
                                    method: "POST",
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Replace with the actual CSRF token
                                    },
                                    body: formData,
                                })
                                .then((response) => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then((data) => {
                                    console.log(data);
                                    window.location.reload();
                                })
                                .catch((error) => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'error',
                                        title: 'Your work has not saved',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                });

                                name.disabled = true;
                                username.disabled = true;
                                phone.disabled = true;
                                sign.disabled = true;

                                if ( userRole == 'admin') {
                                    dpm.disabled = true;
                                    agn.disabled = true;
                                    brn.disabled = true;

                                    role.disabled = true;

                                    down_yes.disabled = true;
                                    down_no.disabled = true;

                                    // Create
                                    // create_yes.disabled = true;
                                    // create_no.disabled = true;

                                    // Confirmable
                                    approver.disabled = true;
                                    inspector.disabled = true;


                                    // Access
                                    wi.disabled = true;
                                    sop.disabled = true;
                                    pol.disabled = true;
                                    pro.disabled = true;
                                    mou.disabled = true;
                                    anno.disabled = true;
                                    cont.disabled = true;
                                    check.disabled = true;
                                    course.disabled = true;
                                    media.disabled = true;

                                    cwi.disabled = true;
                                    csop.disabled = true;
                                    cpol.disabled = true;
                                    cpro.disabled = true;
                                    cmou.disabled = true;
                                    canno.disabled = true;
                                    ccont.disabled = true;
                                    ccheck.disabled = true;
                                    ccourse.disabled = true;
                                    cmedia.disabled = true;

                                    staff.disabled = true;

                                    addProjCode.disabled = true;
                                }

                                editbtn.textContent = 'Edit';


                            }

                        });
                </script>
            </div>
        </form>
    </div>
    @vite(['resources/css/profile.css'])
    <script>

    </script>
</body>
@endsection

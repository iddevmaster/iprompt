@extends('layouts.app')

@section('content')
<?php $regData = \App\CoreFunction\Helper::regData();
        $roles = Spatie\Permission\Models\Role::all();
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('เพิ่มบัญชีผู้ใช้') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('ชื่อ') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('ชื่อผู้ใช้') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('รหัสผ่าน') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('ยืนยันรหัสผ่าน') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('หน่วยงาน') }}</label>

                            <div class="col-md-6">
                                <select class="form-select" aria-label="Default select example" name="agency">
                                    <option disabled selected>กรุณาเลือกหน่วยงาน</option>
                                    @foreach ($regData['agencie'] as $data)
                                        <option value="{{$data->id}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('สาขา') }}</label>

                            <div class="col-md-6">
                                <select class="form-select" aria-label="Default select example" name="branch" id="usrBrn">
                                    <option disabled selected>กรุณาเลือกสาขา</option>
                                    @foreach ($regData['branche'] as $data)
                                        <option value="{{$data->id}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('ฝ่าย') }}</label>

                            <div class="col-md-6">
                                <select class="form-select" aria-label="Default select example" id="usrDpm" name="dpm" disabled>
                                    <option disabled selected>กรุณาเลือกฝ่าย</option>
                                    @foreach ($regData['department'] as $data)
                                        <option value="{{$data->id}}" bid="{{ $data->branch_id }}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <script>
                            const usrBrn = document.getElementById('usrBrn');
                            const usrDpm = document.getElementById('usrDpm');
                            usrBrn.addEventListener('change', () => {
                                usrDpm.disabled = false;
                                const selectedBranch = usrBrn.value;
                                const options = document.querySelectorAll('#usrDpm option');
                                options.forEach((option) => {
                                    if (option.getAttribute('bid') == selectedBranch) {
                                        option.style.display = 'block';
                                    } else {
                                        option.style.display = 'none';
                                    }
                                });
                            });


                        </script>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('เบอร์โทรศัพท์') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="phone" >
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('ระดับผู้ใช้งาน') }}</label>

                            <div class="col-md-6">
                                <select class="form-select" aria-label="Default select example" name="role">
                                    <option disabled selected>กรุณาเลือกระดับผู้ใช้งาน</option>
                                    @foreach ($roles as $data)
                                        <option value="{{$data->name}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('เพิ่มบัญชีผู้ใช้') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

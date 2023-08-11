<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('dist/img/logoiddrives.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/css/login.css' , 'resources/js/login.js'])
</head>

<body>
    <div class="container">
        <h2 class="text-light text-center">Welcome to Saraban</h2>
        <h4 class="text-light">Please Login</h4>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email input -->
            <div class="text-start mb-2">
                <label for="inputEmail" class="text-light">E-mail</label>
                <div>
                    <input id="email" placeholder="Input your E-mail" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Password input -->
            <div class="text-start mb-3">
                <label for="inputPassword5" class="text-light">Password</label>
                <div class="input-group">
                    <input id="password" placeholder="Input your password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    <button type="button" class="btn" id="togglePasswordBtn">Show</button>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- submit button -->
            <div>
                <button id="submitBtn" type="submit" class="btn">
                    {{ __('Login') }}
                </button>
            </div>
            
        </form>
    </div>
</body>
</html>

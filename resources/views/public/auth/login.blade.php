@extends('public.layouts.auth')

@section('meta_title', 'Login | Admin Panel')
@section('meta_description', 'Login')

@section('auth.content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card p-4">
                    <div class="card-body d-grid gap-4">
                        <a href="/" class="h-px-40">
                            <img src="/logo.png" alt="App Logo" class="h-100">
                        </a>
                        <h1>Log In</h1>

                        <form id="formAuthentication" method="POST" action="{{ route('login.process') }}"
                            class="d-grid gap-4">
                            @csrf
                            <div>
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}"
                                    autofocus>
                                @error('email')
                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="············" aria-describedby="password">
                                    <span class="input-group-text cursor-pointer"><i
                                            class="icon-base bx bx-hide"></i></span>
                                </div>
                                @error('password')
                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <button class="btn btn-primary w-100" type="submit">Login</button>
                            </div>
                            @if (session('error'))
                                <div><span class="text-danger d-block mt-1">{{ session(key: 'error') }}</span></div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

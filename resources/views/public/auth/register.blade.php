@extends('public.layouts.auth')

@section('meta_title', 'Register | Admin Panel')
@section('meta_description', 'Register')

@section('auth.content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card p-4">
                    <div class="card-body d-grid gap-4">
                        <a href="/" class="h-px-50">
                            <img src="/logo.png" alt="App Logo" class="h-100">
                        </a>
                        <h1>Register</h1>

                        <form id="formAuthentication" method="POST" action="{{ route('register.process') }}"
                            class="d-grid gap-4">
                            @csrf

                            <div>
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter your full name" autofocus required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="············" aria-describedby="password" required>
                                    <span class="input-group-text cursor-pointer"><i
                                            class="icon-base bx bx-hide"></i></span>
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-password-toggle">
                                <label class="form-label" for="confirm-password">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="confirm-password" class="form-control"
                                        name="password_confirmation" placeholder="············"
                                        aria-describedby="confirm-password" required>
                                    <span class="input-group-text cursor-pointer"><i
                                            class="icon-base bx bx-hide"></i></span>
                                </div>
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" checked
                                    required>
                                <label class="form-check-label" for="terms-conditions">
                                    By registering, you agree to our
                                    <a href="/privacy-policy" class="fw-bold">Privacy Policy</a> &amp;
                                    <a href="/terms-and-conditions" class="fw-bold">Terms & Conditions</a>
                                </label>
                            </div>

                            <div>
                                <button class="btn btn-primary d-grid w-100" type="submit"
                                    id="register-btn">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const termsCheckbox = document.getElementById("terms-conditions");
            const submitButton = document.getElementById("register-btn");

            function validateForm() {
                submitButton.disabled = !termsCheckbox.checked;
            }

            termsCheckbox.addEventListener("change", validateForm);
            validateForm();
        });
    </script>

@endsection

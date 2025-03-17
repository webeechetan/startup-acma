@extends('admin.layouts.admin')

@section('meta_title', 'Add User | Admin Panel')
@section('meta_description', 'Add User')

@section('admin.content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Add User</h2>
            <a href="{{ route('pilots.users.index') }}" class="btn btn-primary btn-sm">View All Users</a>
        </div>

        <div class="card-body">
            <form id="formUser" method="POST" action="{{ route('pilots.users.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="pilot_id" class="form-label">Company <span class="text-danger">*</span></label>
                    <select class="form-select" id="pilot_id" name="pilot_id" autofocus required>
                        <option value="" disabled selected>Select Company</option>
                        @foreach ($pilots as $pilot)
                            <option value="{{ $pilot->id }}" {{ old('pilot_id') == $pilot->id ? 'selected' : '' }}>
                                {{ $pilot->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('pilot_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name"
                        value="{{ old('name') }}" autofocus required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email"
                        value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password"
                        required>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="confirm-password" class="form-label">Confirm Password <span
                            class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="confirm-password" name="password_confirmation"
                        placeholder="Confirm password" required>
                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button class="btn btn-primary" type="submit">Save</button>
            </form>

            <div class="mt-4">
                <small class="text-muted">Note: All <span class="text-danger">*</span> fields are required.</small>
            </div>
        </div>
    </div>

@endsection

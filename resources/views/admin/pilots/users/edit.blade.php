@extends('admin.layouts.admin')

@section('meta_title', 'Edit User | Admin Panel')
@section('meta_description', 'Edit User')

@section('admin.content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Edit User</h2>
            <a href="{{ route('pilots.users.index') }}" class="btn btn-primary btn-sm">View All Users</a>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('pilots.users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4 d-grid">
                    <label for="pilot_id" class="form-label">Company <span class="text-danger">*</span></label>
                    <select class="form-select" id="pilot_id" name="pilot_id" autofocus required>
                        <option value="" disabled>Select Company</option>
                        @foreach ($pilots as $pilot)
                            <option value="{{ $pilot->id }}"
                                {{ old('pilot_id', $selectedPilot) == $pilot->id ? 'selected' : '' }}>
                                {{ $pilot->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('pilot_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4 d-grid">
                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name"
                        value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4 d-grid">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email"
                        value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                        {{ $user->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Set as Active</label>
                </div>

                <button class="btn btn-primary" type="submit">Update</button>
            </form>

            <div class="mt-4">
                <small class="text-muted">Note: All <span class="text-danger">*</span> fields are required.</small>
            </div>
        </div>
    </div>

@endsection

@extends('admin.layouts.admin')

@section('meta_title', 'Edit Season | Admin Panel')
@section('meta_description', 'Edit Season')

@section('admin.content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Edit Season</h2>
            <a href="{{ route('seasons.index') }}" class="btn btn-primary btn-sm">View All Seasons</a>
        </div>

        <div class="card-body">
            <form id="formSeason" method="POST" action="{{ route('seasons.update', $season->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4 d-grid">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Season Name"
                        value="{{ old('name', $season->name) }}" autofocus required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4 d-grid">
                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                        value="{{ old('start_date', $season->start_date) }}" required>
                    @error('start_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4 d-grid">
                    <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="end_date" name="end_date"
                        value="{{ old('end_date', $season->end_date) }}" required>
                    @error('end_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                        {{ $season->is_active ? 'checked' : '' }}>
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

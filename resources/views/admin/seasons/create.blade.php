@extends('admin.layouts.admin')

@section('meta_title', 'Add Season | Admin Panel')
@section('meta_description', 'Add Season')

@section('admin.content')

    <div class="card">
        <h2 class="card-header">Add Season</h2>
        <div class="card-body">
            <form id="formSeason" method="POST" action="{{ route('seasons.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Season 1"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                        value="{{ old('start_date') }}" required>
                    @error('start_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}"
                        required>
                    @error('end_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button class="btn btn-primary" type="submit">Add Season</button>
            </form>
            <div class="mt-4">
                <small class="text-muted">Note: All <span class="text-danger">*</span> fields are required.</small>
            </div>
        </div>
    </div>

@endsection

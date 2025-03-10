@extends('admin.layouts.admin')

@section('meta_title', 'Edit Season | Admin Panel')
@section('meta_description', 'Edit Season')

@section('admin.content')

    <div class="card">
        <h2 class="card-header">Edit Season</h2>
        <div class="card-body">
            <form id="formSeason" method="POST" action="{{ route('seasons.update', $season->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $season->name) }}" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                        value="{{ old('start_date', $season->start_date) }}" required>
                    @error('start_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
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

                <button class="btn btn-primary" type="submit">Update Season</button>
            </form>
        </div>
    </div>

@endsection

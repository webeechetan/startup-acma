@extends('admin.layouts.admin')

@section('meta_title', 'Edit Category | Admin Panel')
@section('meta_description', 'Edit Category')

@section('admin.content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Edit Category</h2>
            <a href="{{ route('pilots.categories.index') }}" class="btn btn-primary btn-sm">View All Categories</a>
        </div>

        <div class="card-body">
            <form id="formPilotCategory" method="POST" action="{{ route('pilots.categories.update', $category->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Enter Category Name" value="{{ old('name', $category->name) }}" autofocus required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button class="btn btn-primary" type="submit">Update Category</button>
            </form>

            <div class="mt-4">
                <small class="text-muted">Note: All <span class="text-danger">*</span> fields are required.</small>
            </div>
        </div>
    </div>

@endsection

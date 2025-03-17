@extends('admin.layouts.admin')

@section('meta_title', 'Add Category | Admin Panel')
@section('meta_description', 'Add Category')

@section('admin.content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Add Category</h2>
            <a href="{{ route('pilots.categories.index') }}" class="btn btn-primary btn-sm">View All Categories</a>
        </div>

        <div class="card-body">
            <form id="formPilotCategory" method="POST" action="{{ route('pilots.categories.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Enter Category Name" value="{{ old('name') }}" autofocus required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="pilot-select" class="form-label">Companies <span class="text-danger">*</span></label>
                    <x-admin.multi-select id="pilot-select" name="pilot_id" :options="$pilots" :config="[
                        'placeholder' => 'Type to Search or Select Companies',
                        'allowClear' => true,
                        'tags' => false,
                    ]"
                        class="form-control w-100" :multiple="true" :required="true" />
                    @error('pilot_id')
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

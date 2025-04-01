@extends('admin.layouts.admin')

@section('meta_title', 'Add Contact | Admin Panel')
@section('meta_description', 'Add Contact')

@section('admin.content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Add Contact</h2>
            <a href="{{ route('contacts.index') }}" class="btn btn-primary btn-sm">View All Contacts</a>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('contacts.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" 
                        value="{{ old('name') }}" placeholder="Enter Name" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" 
                        value="{{ old('email') }}" placeholder="Enter Email" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="message" name="message" rows="4" 
                        placeholder="Enter Message" required>{{ old('message') }}</textarea>
                    @error('message')
                        <div class="text-danger">{{ $message }}</div>
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

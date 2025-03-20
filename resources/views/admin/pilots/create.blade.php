@extends('admin.layouts.admin')

@section('meta_title', 'Add Pilot Company | Admin Panel')
@section('meta_description', 'Add Pilot Company')

@section('admin.content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Add Company</h2>
            <a href="{{ route('pilots.index') }}" class="btn btn-primary btn-sm">View All Companies</a>
        </div>

        <div class="card-body">
            <form id="formPilot" method="POST" action="{{ route('pilots.store') }}">
                @csrf
                <div class="mb-4 d-grid">
                    <label for="pilot-select" class="form-label">Company Name(s) <span class="text-danger">*</span></label>
                    <x-admin.select id="pilot-select" name="pilot_names" :options="$pilots" :config="[
                        'placeholder' =>
                            'Search for a company, select from the list, or type a new name and press Enter to add',
                        'allowClear' => true,
                        'tags' => true,
                        'multiple' => true,
                        'selectAll' => true,
                        'required' => true,
                    ]" />
                    @error('pilot_names')
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

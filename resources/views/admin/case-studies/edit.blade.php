@extends('admin.layouts.admin')

@section('meta_title', 'Edit Case Study | Admin Panel')
@section('meta_description', 'Edit Case Study')

@section('admin.content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Edit Case Study</h2>
            <a href="{{ route('case-studies.index') }}" class="btn btn-primary btn-sm">View All Case Studies</a>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('case-studies.update', $caseStudy->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label">Thumbnail <span class="text-danger">*</span></label>
                    <div class="d-grid align-items-center gap-3">
                        <div>
                            <input type="file" id="thumbnail" name="thumbnail" hidden accept="image/*"
                                onchange="previewFile(this, 'thumbnailPreview')">
                            <button type="button" class="btn btn-primary"
                                onclick="document.getElementById('thumbnail').click()">Upload</button>
                            <button type="button" class="btn btn-outline-secondary"
                                onclick="clearFile('thumbnail', 'thumbnailPreview', '{{ asset('admin/assets/img/avatars/default-image.png') }}')">Reset</button>
                            <small class="text-muted d-block">Allowed Formats: JPG, JPEG, PNG, WEBP | Maximum File
                                Size: 5MB | Aspect Ratio: 1:1</small>
                            @error('thumbnail')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <img id="thumbnailPreview"
                            src="{{ $caseStudy->thumbnail ? asset('storage/' . $caseStudy->thumbnail) : asset('admin/assets/img/avatars/default-image.png') }}"
                            class="rounded border" style="width: 300px; height: 300px; object-fit: cover;">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" id="title" name="title" class="form-control"
                        value="{{ old('title', $caseStudy->title) }}" placeholder="Enter Case Study Title" required>
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="overview" class="form-label">Overview <span class="text-danger">*</span></label>
                    <textarea id="overview" name="overview" class="form-control" rows="4" placeholder="Enter Case Study Overview"
                        required>{{ old('overview', $caseStudy->overview) }}</textarea>
                    @error('overview')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-admin.editor name="description" label="Description" :value="old('description', $caseStudy->description)" :required="true"
                        placeholder="Enter Detailed Description" />
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary" type="submit">Update</button>
            </form>
        </div>
    </div>

    <script>
        // Preview thumbnail file
        const previewFile = (input, previewId) => {
            const preview = document.getElementById(previewId);
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => preview.src = e.target.result;
                reader.readAsDataURL(file);
            }
        };

        // Clear thumbnail file and reset preview
        const clearFile = (inputId, previewId, defaultSrc = '') => {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            input.value = '';
            preview.src = defaultSrc;
        };
    </script>
@endsection

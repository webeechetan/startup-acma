@extends('admin.layouts.admin')

@section('meta_title', 'Edit Knowledge Sharing | Admin Panel')
@section('meta_description', 'Edit Knowledge Sharing')

@section('admin.content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Edit Knowledge Sharing</h2>
            <a href="{{ route('knowledge-sharings.index') }}" class="btn btn-primary btn-sm">View All Knowledge Sharings</a>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('knowledge-sharings.update', $knowledgeSharing->id) }}" enctype="multipart/form-data">
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
                                Size: 5MB</small>
                            @error('thumbnail')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <img id="thumbnailPreview"
                            src="{{ $knowledgeSharing->thumbnail ? asset('storage/' . $knowledgeSharing->thumbnail) : asset('admin/assets/img/avatars/default-image.png') }}"
                            class="rounded border" style="width: 300px; height: 300px; object-fit: cover;">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" id="title" name="title" class="form-control"
                        value="{{ old('title', $knowledgeSharing->title) }}" placeholder="Enter Knowledge Sharing Title" required>
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="overview" class="form-label">Overview <span class="text-danger">*</span></label>
                    <textarea id="overview" name="overview" class="form-control" rows="4" placeholder="Enter Knowledge Sharing Overview"
                        required>{{ old('overview', $knowledgeSharing->overview) }}</textarea>
                    @error('overview')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-admin.editor name="description" label="Description" :value="old('description', $knowledgeSharing->description)" :required="true"
                        placeholder="Enter Detailed Description" />
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Collaterals</label>
                    <input type="file" id="collaterals" name="collaterals[]" class="form-control" multiple
                        accept="image/*,application/pdf,.doc,.docx" onchange="handleCollaterals(this)">
                    <small class="text-muted">Allowed Formats: Images, PDFs, DOCs | Maximum File Size: 10MB per
                        file</small>
                    <div id="collateralDetails" class="mt-2">
                        @if($knowledgeSharing->collaterals)
                            @foreach($knowledgeSharing->collaterals as $index => $collateral)
                                <div class="d-flex justify-content-between align-items-center border p-2 rounded mb-2">
                                    <span>{{ basename($collateral) }}</span>
                                    <button type="button" class="btn-close" onclick="removeExistingFile({{ $index }})"></button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <input type="hidden" name="existing_collaterals" id="existing_collaterals" 
                        value="{{ json_encode($knowledgeSharing->collaterals) }}">
                    @error('collaterals.*')
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

        // To store previously selected collaterals
        let collateralFiles = new DataTransfer();
        let existingCollaterals = @json($knowledgeSharing->collaterals ?? []);

        // Handle collateral uploads while preserving previous files
        const handleCollaterals = (input) => {
            Array.from(input.files).forEach(file => collateralFiles.items.add(file));
            input.files = collateralFiles.files;
            showFileNames(input, 'collateralDetails');
        };

        // Display filenames for collaterals
        const showFileNames = (input, containerId) => {
            const container = document.getElementById(containerId);
            container.innerHTML = '';

            // Show existing files
            existingCollaterals.forEach((file, index) => {
                container.innerHTML += `
                <div class="d-flex justify-content-between align-items-center border p-2 rounded mb-2">
                    <span>${file.split('/').pop()}</span>
                    <button type="button" class="btn-close" onclick="removeExistingFile(${index})"></button>
                </div>
                `;
            });

            // Show new files
            Array.from(input.files).forEach((file, index) => {
                container.innerHTML += `
                <div class="d-flex justify-content-between align-items-center border p-2 rounded mb-2">
                    <span>${file.name}</span>
                    <button type="button" class="btn-close" onclick="removeFile(${index}, '${input.id}', '${containerId}')"></button>
                </div>
                `;
            });
        };

        // Remove individual collateral file
        const removeFile = (index, inputId, containerId) => {
            const input = document.getElementById(inputId);
            const container = document.getElementById(containerId);

            // Remove file from DataTransfer object
            const newFiles = new DataTransfer();
            Array.from(input.files).forEach((file, i) => {
                if (i !== index) newFiles.items.add(file);
            });

            collateralFiles = newFiles;
            input.files = collateralFiles.files;
            showFileNames(input, containerId);
        };

        // Remove existing file
        const removeExistingFile = (index) => {
            existingCollaterals.splice(index, 1);
            document.getElementById('existing_collaterals').value = JSON.stringify(existingCollaterals);
            showFileNames(document.getElementById('collaterals'), 'collateralDetails');
        };
    </script>
@endsection

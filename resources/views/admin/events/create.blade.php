@extends('admin.layouts.admin')

@section('meta_title', 'Add Event | Admin Panel')
@section('meta_description', 'Add Event')

@section('admin.content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Add Event</h2>
            <a href="{{ route('events.index') }}" class="btn btn-primary btn-sm">View All Events</a>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
                @csrf

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
                        <img id="thumbnailPreview" src="{{ asset('admin/assets/img/avatars/default-image.png') }}"
                            class="rounded border" style="width: 300px; height: 300px; object-fit: cover;">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}"
                        placeholder="Enter Event Title" required>
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="start_date" class="form-label">Start Date & Time <span
                                class="text-danger">*</span></label>
                        <input type="datetime-local" id="start_date" name="start_date" class="form-control"
                        value="{{ old('start_date') }}" required>
                    @error('start_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="end_date" class="form-label">End Date & Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" id="end_date" name="end_date" class="form-control"
                            value="{{ old('end_date') }}" required>
                        @error('end_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                        <x-admin.select 
                            id="category" 
                            name="category" 
                            :options="[
                                'online' => 'Online',
                                'offline' => 'Offline',
                                'hybrid' => 'Hybrid'
                            ]"
                            :selected="old('category')"
                            :config="[
                                'placeholder' => 'Select Category',
                                'required' => true
                            ]"
                        />
                        @error('category')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                        <x-admin.select 
                            id="type" 
                            name="type" 
                            :options="[
                                'free' => 'Free',
                                'paid' => 'Paid'
                            ]"
                            :selected="old('type')"
                            :config="[
                                'placeholder' => 'Select Type',
                                'required' => true
                            ]"
                        />
                        @error('type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4" id="priceField" style="display: none;">
                    <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                    <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}"
                        placeholder="Enter Price" step="0.01" min="0">
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="participants" class="form-label">Participants <span class="text-danger">*</span></label>
                    <x-admin.select 
                        id="participants" 
                        name="participants" 
                        :options="[
                            'for all' => 'For All',
                            'for startups only' => 'For Startups Only',
                            'for pilots only' => 'For Pilots Only',
                            'for startups & pilots' => 'For Startups & Pilots',
                            'custom' => 'Custom Participants'
                        ]"
                        :selected="old('participants')"
                        :config="[
                            'placeholder' => 'Select Participants',
                            'required' => true
                        ]"
                    />
                    @error('participants')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4" id="startupParticipantsField" style="display: none;">
                    <label for="startup_participants" class="form-label">Select Startups</label>
                    <x-admin.select id="startup_participants" name="startup_participants" :options="$startups"
                        :config="[
                            'placeholder' =>
                                'Search for a company, select from the list, or type a new name and press Enter to add',
                            'allowClear' => true,
                            'tags' => true,
                            'multiple' => true,
                            'selectAll' => true,
                        ]" />
                </div>

                <div class="mb-4" id="pilotParticipantsField" style="display: none;">
                    <label for="pilot_participants" class="form-label">Select Pilots</label>
                    <x-admin.select id="pilot_participants" name="pilot_participants" :options="$pilots"
                        :config="[
                            'placeholder' =>
                                'Search for a company, select from the list, or type a new name and press Enter to add',
                            'allowClear' => true,
                            'tags' => true,
                            'multiple' => true,
                            'selectAll' => true,
                        ]" />
                </div>

                <div class="mb-4" id="customParticipantsField" style="display: none;">
                    <label for="custom_participants" class="form-label">Custom Participants</label>
                    <input type="text" id="custom_participants" name="custom_participants" class="form-control"
                        value="{{ old('custom_participants') }}" placeholder="Enter comma-separated participant names">
                    <small class="text-muted">Enter participant names separated by commas</small>
                </div>

                <div class="mb-4">
                    <x-admin.editor name="description" label="Description" :value="old('description')" :required="true"
                        placeholder="Enter Event Description" />
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Gallery</label>
                    <input type="file" id="gallery" name="gallery[]" class="form-control" multiple
                        accept="image/*" onchange="handleGallery(this)">
                    <small class="text-muted">Allowed Formats: JPG, JPEG, PNG, WEBP | Maximum File Size: 5MB per
                        image</small>
                    <div id="galleryPreview" class="d-flex flex-wrap gap-2 mt-3"></div>
                    @error('gallery.*')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Collaterals</label>
                    <input type="file" id="collaterals" name="collaterals[]" class="form-control" multiple
                        accept="image/*,application/pdf,.doc,.docx" onchange="handleCollaterals(this)">
                    <small class="text-muted">Allowed Formats: Images, PDFs, DOCs | Maximum File Size: 10MB per
                        file</small>
                    <div id="collateralDetails" class="mt-2"></div>
                    @error('collaterals.*')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary" type="submit">Save</button>
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

        // Handle price field visibility based on type
        document.getElementById('type').addEventListener('change', function() {
            const priceField = document.getElementById('priceField');
            priceField.style.display = this.value === 'paid' ? 'grid' : 'none';
        });

        // Handle participants fields visibility
        document.getElementById('participants').addEventListener('change', function() {
            const startupField = document.getElementById('startupParticipantsField');
            const pilotField = document.getElementById('pilotParticipantsField');
            const customField = document.getElementById('customParticipantsField');

            startupField.style.display = 'none';
            pilotField.style.display = 'none';
            customField.style.display = 'none';

            switch (this.value) {
                case 'for startups only':
                    startupField.style.display = 'grid';
                    break;
                case 'for pilots only':
                    pilotField.style.display = 'grid';
                    break;
                case 'for startups & pilots':
                    startupField.style.display = 'grid';
                    pilotField.style.display = 'grid';
                    break;
                case 'custom':
                    customField.style.display = 'grid';
                    break;
            }
        });

        // Handle gallery preview
        const handleGallery = (input) => {
            const preview = document.getElementById('galleryPreview');
            preview.innerHTML = '';

            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.innerHTML += `
                        <div class="position-relative">
                            <img src="${e.target.result}" class="rounded" style="width: 150px; height: 150px; object-fit: cover;">
                            <button type="button" class="btn-close position-absolute top-0 end-0" 
                                onclick="removeGalleryImage(this)"></button>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            });
        };

        // Remove gallery image
        const removeGalleryImage = (button) => {
            button.closest('.position-relative').remove();
        };

        // To store previously selected collaterals
        let collateralFiles = new DataTransfer();

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
    </script>
@endsection

@extends('admin.layouts.admin')

@section('meta_title', 'Add Startup Company | Admin Panel')
@section('meta_description', 'Add Startup Company')

@section('admin.content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Add Company</h2>
            <a href="{{ route('startups.index') }}" class="btn btn-primary btn-sm">View All Companies</a>
        </div>

        <div class="card-body">
            <form id="formStartup" method="POST" action="{{ route('startups.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="d-grid gap-4">
                    <div>
                        <h4 class="mb-3">Company Info</h4>
                        <div class="mb-4">
                            <label class="form-label">Logo <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center gap-3">
                                <img id="logoPreview"
                                    src="{{ old('logo') ? asset('storage/' . old('logo')) : asset('admin/assets/img/avatars/default-image.png') }}"
                                    class="rounded border" style="width: 100px; height: 100px;">
                                <div>
                                    <input type="file" id="logo" name="logo" hidden accept="image/*"
                                        onchange="previewFile(this, 'logoPreview')">
                                    <button type="button" class="btn btn-primary"
                                        onclick="document.getElementById('logo').click()">Upload</button>
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="clearFile('logo', 'logoPreview', '{{ asset('assets/img/avatars/default-image.png') }}')">Reset</button>
                                    <small class="text-muted d-block">Allowed Formats: JPG, JPEG, PNG, WEBP | Maximum File
                                        Size: 5MB | Aspect Ratio: 1:1</small>
                                    @error('logo')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ old('name') }}" placeholder="Enter Company Name" autofocus required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-admin.editor name="bio" label="Bio" :value="old('bio')" :required="true" />
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                <x-admin.select id="country" name="country" :options="config('company_options.countries')" :selected="old('country')"
                                    :config="[
                                        'placeholder' => 'Select Country',
                                        'required' => true,
                                    ]" />
                                @error('country')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                <input type="text" id="state" name="state" class="form-control"
                                    value="{{ old('state') }}" placeholder="Enter State" required>
                                @error('state')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" id="city" name="city" class="form-control"
                                    value="{{ old('city') }}" placeholder="Enter City" required>
                                @error('city')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                                <input type="text" id="pincode" name="pincode" class="form-control"
                                    placeholder="Enter Pincode" value="{{ old('pincode') }}" required>
                                @error('pincode')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                <input type="text" id="address" name="address" class="form-control"
                                    placeholder="Enter Address" value="{{ old('address') }}">
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="year" class="form-label">Founded On <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="year" name="year" class="form-control"
                                placeholder="Enter Founding Year (YYYY)" pattern="^\d{4}$" maxlength="4"
                                inputmode="numeric" value="{{ old('year') }}"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            @error('year')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-4">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <x-admin.select id="type" name="type" :options="config('company_options.type')" :selected="old('type')"
                                :config="['placeholder' => 'Select Company Type', 'required' => true]" />
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="industry" class="form-label">Industry <span class="text-danger">*</span></label>
                            <x-admin.select id="industry" name="industry" :options="config('company_options.industry')" :selected="old('industry')"
                                :config="['placeholder' => 'Select Industry', 'required' => true]" />
                            @error('industry')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="size" class="form-label">Size <span class="text-danger">*</span></label>
                            <x-admin.select id="size" name="size" :options="config('company_options.size')" :selected="old('size')"
                                :config="['placeholder' => 'Select Company Size', 'required' => true]" />
                            @error('size')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="revenue" class="form-label">Annual Revenue <span
                                    class="text-danger">*</span></label>
                            <x-admin.select id="revenue" name="revenue" :options="config('company_options.revenue')" :selected="old('revenue')"
                                :config="['placeholder' => 'Select Annual Revenue', 'required' => true]" />
                            <small class="text-muted d-block mt-1">Select revenue range in Indian Rupees (Cr.) or USD
                                equivalent</small>
                            @error('revenue')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Point of Contact (POC)</h4>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addNewPOC()">
                                <i class="bx bx-plus"></i> Add POC
                            </button>
                        </div>

                        <div id="poc-container">
                            <!-- First POC (Mandatory) -->
                            <div class="poc-entry border rounded p-3 mb-3">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="pocs[0][name]" class="form-control"
                                            value="{{ old('pocs.0.name') }}" placeholder="Enter Full Name" required>
                                        @error('pocs.0.name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Designation <span class="text-danger">*</span></label>
                                        <input type="text" name="pocs[0][designation]" class="form-control"
                                            value="{{ old('pocs.0.designation') }}" placeholder="Enter Designation"
                                            required>
                                        @error('pocs.0.designation')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="pocs[0][email]" class="form-control"
                                            value="{{ old('pocs.0.email') }}" placeholder="Enter Email" required>
                                        @error('pocs.0.email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="pocs[0][phone]" class="form-control"
                                            value="{{ old('pocs.0.phone') }}" placeholder="Enter Phone Number" required>
                                        @error('pocs.0.phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="mb-3">Company Links</h4>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="website" class="form-label">Website</label>
                                <input type="url" id="website" name="website" class="form-control"
                                    value="{{ old('website') }}" placeholder="Enter Website URL">
                                @error('website')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="linkedin" class="form-label">LinkedIn</label>
                                <input type="url" id="linkedin" name="linkedin" class="form-control"
                                    value="{{ old('linkedin') }}" placeholder="Enter LinkedIn URL">
                                @error('linkedin')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="url" id="facebook" name="facebook" class="form-control"
                                    value="{{ old('facebook') }}" placeholder="Enter Facebook URL">
                                @error('facebook')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="url" id="instagram" name="instagram" class="form-control"
                                    value="{{ old('instagram') }}" placeholder="Enter Instagram URL">
                                @error('instagram')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="twitter" class="form-label">Twitter</label>
                                <input type="url" id="twitter" name="twitter" class="form-control"
                                    value="{{ old('twitter') }}" placeholder="Enter Twitter URL">
                                @error('twitter')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 class="mb-3">Marketing Collaterals</h4>
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
                    </div>

                </div>

                <button class="btn btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>

    <script>
        // Preview logo file
        const previewFile = (input, previewId) => {
            const preview = document.getElementById(previewId);
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => preview.src = e.target.result;
                reader.readAsDataURL(file);
            }
        };

        // Clear logo file and reset preview
        const clearFile = (inputId, previewId, defaultSrc = '') => {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            input.value = '';
            preview.src = defaultSrc;
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

        let pocCount = 0; // Counter for POC entries

        function addNewPOC() {
            pocCount++;
            const template = `
                <div class="poc-entry border rounded p-3 mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="mb-0">Additional POC</h6>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removePOC(this)">
                            <i class="bx bx-trash"></i> Remove
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="pocs[${pocCount}][name]" class="form-control" 
                                placeholder="Enter Full Name">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Designation</label>
                            <input type="text" name="pocs[${pocCount}][designation]" class="form-control" 
                                placeholder="Enter Designation">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="pocs[${pocCount}][email]" class="form-control" 
                                placeholder="Enter Email">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="pocs[${pocCount}][phone]" class="form-control" 
                                placeholder="Enter Phone Number">
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('poc-container').insertAdjacentHTML('beforeend', template);
        }

        function removePOC(button) {
            button.closest('.poc-entry').remove();
        }
    </script>
@endsection

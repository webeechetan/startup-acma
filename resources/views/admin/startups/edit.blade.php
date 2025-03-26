@extends('admin.layouts.admin')

@section('meta_title', 'Edit Startup Company | Admin Panel')
@section('meta_description', 'Edit Startup Company')

@section('admin.content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Edit Company</h2>
            <a href="{{ route('startups.index') }}" class="btn btn-primary btn-sm">View All Companies</a>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('startups.update', $startup->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="d-grid gap-4">
                    <div>
                        <h4 class="mb-3">Company Info</h4>
                        <div class="mb-4">
                            <label class="form-label">Logo <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center gap-3">
                                <img id="logoPreview"
                                    src="{{ old('logo', $startup->logo) ? asset('storage/' . old('logo', $startup->logo)) : asset('admin/assets/img/avatars/default-logo.png') }}"
                                    class="rounded border" style="width: 100px; height: 100px;">
                                <div>
                                    <input type="file" id="logo" name="logo" hidden accept="image/*"
                                        onchange="previewFile(this, 'logoPreview')">
                                    <button type="button" class="btn btn-primary"
                                        onclick="document.getElementById('logo').click()">Upload</button>
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="clearFile('logo', 'logoPreview', '{{ asset('admin/assets/img/avatars/default-logo.png') }}')">Reset</button>
                                    <small class="text-muted d-block">Allowed Formats: JPG, JPEG, PNG, WEBP | Max size of
                                        5MB | Aspect Ratio: 1:1</small>
                                    @error('logo')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ old('name', $startup->name) }}" placeholder="Enter Company Name" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="bio" class="form-label">Bio <span class="text-danger">*</span></label>
                            <textarea id="bio" name="bio" class="form-control" rows="8" placeholder="Enter Company Bio" required>{{ old('bio', $startup->bio) }}</textarea>
                            @error('bio')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                <x-admin.select 
                                    id="country" 
                                    name="country" 
                                    :options="config('company_options.countries')" 
                                    :selected="old('country', $startup->country)"
                                    :config="[
                                        'placeholder' => 'Select Country',
                                        'required' => true,
                                    ]" 
                                />
                                @error('country')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                <input type="text" id="state" name="state" class="form-control"
                                    value="{{ old('state', $startup->state) }}" placeholder="Enter State" required>
                                @error('state')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" id="city" name="city" class="form-control"
                                    value="{{ old('city', $startup->city) }}" placeholder="Enter City" required>
                                @error('city')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                                <input type="text" id="pincode" name="pincode" class="form-control"
                                    placeholder="Enter Pincode" value="{{ old('pincode', $startup->pincode) }}" required>
                                @error('pincode')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="address" class="form-label">Address <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="address" name="address" class="form-control"
                                    placeholder="Enter Address" value="{{ old('address', $startup->address) }}" required>
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="year_founded" class="form-label">Founded On <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="year_founded" name="year_founded" class="form-control"
                                placeholder="Enter Founding Year (YYYY)" pattern="^\d{4}$" maxlength="4"
                                inputmode="numeric" value="{{ old('year_founded', $startup->year_founded) }}"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            @error('year_founded')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <x-admin.select id="type" name="type" :options="config('company_options.type')" :selected="old('type', $startup->type)"
                                :config="['placeholder' => 'Select Company Type', 'required' => true]" />
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="industry" class="form-label">Industry <span class="text-danger">*</span></label>
                            <x-admin.select id="industry" name="industry" :options="config('company_options.industry')" :selected="old('industry', $startup->industry)"
                                :config="['placeholder' => 'Select Industry', 'required' => true]" />
                            @error('industry')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="size" class="form-label">Size <span class="text-danger">*</span></label>
                            <x-admin.select id="size" name="size" :options="config('company_options.size')" :selected="old('size', (string) $startup->size)"
                                :config="['placeholder' => 'Select Company Size', 'required' => true]" />
                            @error('size')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="revenue" class="form-label">Annual Revenue <span
                                    class="text-danger">*</span></label>
                            <x-admin.select id="revenue" name="revenue" :options="config('company_options.revenue')" :selected="old('revenue', (string) $startup->revenue)"
                                :config="['placeholder' => 'Select Revenue (INR Cr.)', 'required' => true]" />
                            @error('revenue')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <h4 class="mb-3">Point of Contact (POC)</h4>
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <label for="poc_name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" id="poc_name" name="poc_name" class="form-control"
                                    value="{{ old('poc_name', $startup->poc_name) }}" placeholder="Enter Full Name"
                                    required>
                                @error('poc_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-4">
                                <label for="poc_designation" class="form-label">Designation <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="poc_designation" name="poc_designation" class="form-control"
                                    value="{{ old('poc_designation', $startup->poc_designation) }}"
                                    placeholder="Enter Designation" required>
                                @error('poc_designation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-4">
                                <label for="poc_email" class="form-label">Email <span
                                        class="text-danger">*</span></label>
                                <input type="email" id="poc_email" name="poc_email" class="form-control"
                                    value="{{ old('poc_email', $startup->poc_email) }}" placeholder="Enter Email"
                                    required>
                                @error('poc_email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-4">
                                <label for="poc_phone" class="form-label">Phone <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="poc_phone" name="poc_phone" class="form-control"
                                    value="{{ old('poc_phone', $startup->poc_phone) }}" placeholder="Enter Phone Number"
                                    required>
                                @error('poc_phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="mb-3">Company Links</h4>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="website" class="form-label">Website</label>
                                <input type="url" id="website" name="website" class="form-control"
                                    value="{{ old('website', $startup->website) }}" placeholder="Enter Website URL">
                                @error('website')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="linkedin" class="form-label">LinkedIn</label>
                                <input type="url" id="linkedin" name="linkedin" class="form-control"
                                    value="{{ old('linkedin', $startup->linkedin) }}" placeholder="Enter LinkedIn URL">
                                @error('linkedin')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="url" id="facebook" name="facebook" class="form-control"
                                    value="{{ old('facebook', $startup->facebook) }}" placeholder="Enter Facebook URL">
                                @error('facebook')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="url" id="instagram" name="instagram" class="form-control"
                                    value="{{ old('instagram', $startup->instagram) }}"
                                    placeholder="Enter Instagram URL">
                                @error('instagram')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="twitter" class="form-label">Twitter</label>
                                <input type="url" id="twitter" name="twitter" class="form-control"
                                    value="{{ old('twitter', $startup->twitter) }}" placeholder="Enter Twitter URL">
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
                            @if ($startup->collaterals)
                                <div class="mb-2">
                                    <div id="existingCollaterals">
                                        @foreach ($startup->collaterals as $index => $collateral)
                                            <div
                                                class="d-flex justify-content-between align-items-center border p-2 rounded mb-2">
                                                <span>{{ basename($collateral) }}</span>
                                                <button type="button" class="btn-close"
                                                    onclick="removeCollateral({{ $index }})"></button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="existing_collaterals"
                                        value="{{ json_encode($startup->collaterals) }}" id="existing_collaterals">
                                </div>
                            @endif
                            <input type="file" id="collaterals" name="collaterals[]" class="form-control" multiple
                                accept="image/*,application/pdf,.doc,.docx" onchange="handleCollaterals(this)">
                            <small class="text-muted">Allowed Formats: Images, PDFs, DOCs</small>
                            <div id="collateralDetails" class="mt-2"></div>
                            @error('collaterals.*')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Update</button>
            </form>
        </div>
    </div>

    @push('scripts')
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

            // Remove existing collateral
            function removeCollateral(index) {
                const existingCollaterals = JSON.parse(document.getElementById('existing_collaterals').value);
                existingCollaterals.splice(index, 1);
                document.getElementById('existing_collaterals').value = JSON.stringify(existingCollaterals);

                // Remove the element from DOM
                const existingCollateralsDiv = document.getElementById('existingCollaterals');
                existingCollateralsDiv.children[index].remove();
            }
        </script>
    @endpush
@endsection

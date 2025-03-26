@extends('admin.layouts.admin')

@section('meta_title', 'View Startup Company | Admin Panel')
@section('meta_description', 'View Startup Company')

@section('admin.content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Company Details</h2>
            <div>
                <a href="{{ route('startups.edit', $startup->id) }}" class="btn btn-primary btn-sm me-2">Edit Company</a>
                <a href="{{ route('startups.index') }}" class="btn btn-primary btn-sm">View All Companies</a>
            </div>
        </div>

        <div class="card-body">
            <div class="d-grid gap-4">
                <div>
                    <h4 class="mb-3">Company Info</h4>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Logo</label>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $startup->logo ? asset('storage/' . $startup->logo) : asset('admin/assets/img/avatars/default-logo.png') }}"
                                class="rounded border" style="width: 100px; height: 100px;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-4">
                            <label class="form-label fw-bold">Name</label>
                            <div class="p-2 border rounded">{{ $startup->name }}</div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-bold">Founded On</label>
                            <div class="p-2 border rounded">{{ $startup->year }}</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Bio</label>
                        <div class="p-2 border rounded">{{ $startup->bio }}</div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-bold">Country</label>
                            <div class="p-2 border rounded">{{ $startup->country }}</div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-bold">State</label>
                            <div class="p-2 border rounded">{{ $startup->state }}</div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-bold">City</label>
                            <div class="p-2 border rounded">{{ $startup->city }}</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-bold">Pincode</label>
                            <div class="p-2 border rounded">{{ $startup->pincode }}</div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-bold">Address</label>
                            <div class="p-2 border rounded">{{ $startup->address }}</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <label class="form-label fw-bold">Type</label>
                            <div class="p-2 border rounded">{{ $startup->type }}</div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <label class="form-label fw-bold">Industry</label>
                            <div class="p-2 border rounded">{{ $startup->industry }}</div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <label class="form-label fw-bold">Size</label>
                            <div class="p-2 border rounded">{{ $startup->size }}</div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <label class="form-label fw-bold">Annual Revenue</label>
                            <div class="p-2 border rounded">{{ $startup->revenue }}</div>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="mb-3">Points of Contact (POCs)</h4>
                    @if($startup->pocs && count($startup->pocs) > 0)
                        @foreach($startup->pocs as $index => $poc)
                            <div class="border rounded p-3 mb-3">
                                <h6 class="mb-3">{{ $index === 0 ? 'Primary POC' : 'Additional POC' }}</h6>
                                <div class="row">
                                    <div class="col-md-3 mb-4">
                                        <label class="form-label fw-bold">Name</label>
                                        <div class="p-2 border rounded">{{ $poc['name'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <label class="form-label fw-bold">Designation</label>
                                        <div class="p-2 border rounded">{{ $poc['designation'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <label class="form-label fw-bold">Email</label>
                                        <div class="p-2 border rounded">{{ $poc['email'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <label class="form-label fw-bold">Phone</label>
                                        <div class="p-2 border rounded">{{ $poc['phone'] ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="p-2 border rounded text-muted">No POCs found</div>
                    @endif
                </div>

                <div>
                    <h4 class="mb-3">Company Links</h4>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-bold">Website</label>
                            <div class="p-2 border rounded">
                                @if ($startup->website)
                                    <a href="{{ $startup->website }}" target="_blank"
                                        class="text-decoration-none">{{ $startup->website }}</a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-bold">LinkedIn</label>
                            <div class="p-2 border rounded">
                                @if ($startup->linkedin)
                                    <a href="{{ $startup->linkedin }}" target="_blank"
                                        class="text-decoration-none">{{ $startup->linkedin }}</a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-bold">Facebook</label>
                            <div class="p-2 border rounded">
                                @if ($startup->facebook)
                                    <a href="{{ $startup->facebook }}" target="_blank"
                                        class="text-decoration-none">{{ $startup->facebook }}</a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-bold">Instagram</label>
                            <div class="p-2 border rounded">
                                @if ($startup->instagram)
                                    <a href="{{ $startup->instagram }}" target="_blank"
                                        class="text-decoration-none">{{ $startup->instagram }}</a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-bold">Twitter</label>
                            <div class="p-2 border rounded">
                                @if ($startup->twitter)
                                    <a href="{{ $startup->twitter }}" target="_blank"
                                        class="text-decoration-none">{{ $startup->twitter }}</a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="mb-3">Marketing Collaterals</h4>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Collaterals</label>
                        @if ($startup->collaterals && count($startup->collaterals) > 0)
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($startup->collaterals as $collateral)
                                    <div class="d-flex align-items-center gap-2 border p-2 rounded">
                                        <span>{{ basename($collateral) }}</span>
                                        <a href="{{ asset('storage/' . $collateral) }}" target="_blank"
                                            class="btn btn-sm btn-link">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-2 border rounded text-muted">No collaterals uploaded</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

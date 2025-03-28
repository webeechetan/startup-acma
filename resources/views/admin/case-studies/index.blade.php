@extends('admin.layouts.admin')

@section('meta_title', 'View All Case Studies | Admin Panel')
@section('meta_description', 'View All Case Studies')

@section('admin.content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">All Case Studies</h2>
            <a href="{{ route('case-studies.create') }}" class="btn btn-primary btn-sm">Add Case Study</a>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <x-admin.datatable id="datatable-case-studies" :columns="['Thumbnail', 'Title', 'Overview', 'Actions']" :config="[
                'order' => [[1, 'asc']],
                'columnDefs' => [
                    ['orderable' => false, 'targets' => [0, -1]],
                    ['searchable' => false, 'targets' => [0, -1]],
                ],
            ]">
                @foreach ($caseStudies as $caseStudy)
                    <tr>
                        <td>
                            @if ($caseStudy->thumbnail)
                                <img src="{{ asset('storage/' . $caseStudy->thumbnail) }}" alt="{{ $caseStudy->title }}"
                                    class="rounded" style="width: 100px; height: 60px; object-fit: cover;">
                            @else
                                <span class="text-muted">No Thumbnail</span>
                            @endif
                        </td>
                        <td>{{ $caseStudy->title }}</td>
                        <td>
                            {{ Str::limit($caseStudy->overview, 100) }}
                        </td>
                        <td>
                            <a href="{{ route('case-studies.edit', $caseStudy->id) }}" class="btn btn-link btn-sm">
                                <i class="bx bx-edit"></i>
                            </a>
                            <form action="{{ route('case-studies.destroy', $caseStudy->id) }}" method="POST"
                                class="d-inline" id="deleteForm{{ $caseStudy->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-link btn-sm"
                                    onclick="confirmDelete('deleteForm{{ $caseStudy->id }}')">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </x-admin.datatable>
        </div>
    </div>
@endsection

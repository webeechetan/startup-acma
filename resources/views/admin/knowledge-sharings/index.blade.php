@extends('admin.layouts.admin')

@section('meta_title', 'View All Knowledge Sharing | Admin Panel')
@section('meta_description', 'View All Knowledge Sharing')

@section('admin.content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">All Knowledge Sharings</h2>
            <a href="{{ route('knowledge-sharings.create') }}" class="btn btn-primary btn-sm">Add Knowledge Sharing</a>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <x-admin.datatable id="datatable-knowledge-sharings" :columns="['Thumbnail', 'Title', 'Overview', 'Actions']" :config="[
                'order' => [[1, 'asc']],
                'columnDefs' => [
                    ['orderable' => false, 'targets' => [0, -1]],
                    ['searchable' => false, 'targets' => [0, -1]],
                ],
            ]">
                @foreach ($knowledgeSharings as $knowledgeSharing)
                    <tr>
                        <td>
                            @if ($knowledgeSharing->thumbnail)
                                <img src="{{ asset('storage/' . $knowledgeSharing->thumbnail) }}" alt="{{ $knowledgeSharing->title }}"
                                    class="rounded" style="max-width: 50px; height: auto;">
                            @else
                                <span class="text-muted">No Thumbnail</span>
                            @endif
                        </td>
                        <td>{{ $knowledgeSharing->title }}</td>
                        <td>
                            {{ Str::limit($knowledgeSharing->overview, 100) }}
                        </td>
                        <td>
                            <a href="{{ route('knowledge-sharings.edit', $knowledgeSharing->id) }}" class="btn btn-link btn-sm">
                                <i class="bx bx-edit"></i>
                            </a>
                            <form action="{{ route('knowledge-sharings.destroy', $knowledgeSharing->id) }}" method="POST"
                                class="d-inline" id="deleteForm{{ $knowledgeSharing->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-link btn-sm"
                                    onclick="confirmDelete('deleteForm{{ $knowledgeSharing->id }}')">
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

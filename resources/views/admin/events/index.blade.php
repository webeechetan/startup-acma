@extends('admin.layouts.admin')

@section('meta_title', 'View All Seasons | Admin Panel')
@section('meta_description', 'View All Seasons')

@section('admin.content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">All Seasons</h2>
            <a href="{{ route('seasons.create') }}" class="btn btn-primary btn-sm">Add Season</a>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <x-admin.datatable id="datatable-seasons" :columns="['Name', 'Start Date', 'End Date', 'Status', 'Actions']" :config="[
                'order' => [[3, 'asc']],
                'columnDefs' => [
                    ['orderable' => false, 'targets' => [-1]],
                    ['searchable' => false, 'targets' => [1, 2, 3, 4]],
                ],
            ]">

                @foreach ($seasons as $season)
                    <tr>
                        <td>{{ $season->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($season->start_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($season->end_date)->format('d M Y') }}</td>
                        <td>
                            <span class="badge {{ $season->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $season->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('seasons.edit', $season->id) }}" class="btn btn-link btn-sm">
                                <i class="bx bx-edit"></i>
                            </a>
                            <form action="{{ route('seasons.destroy', $season->id) }}" method="POST" class="d-inline"
                                id="deleteForm{{ $season->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-link btn-sm"
                                    onclick="confirmDelete('deleteForm{{ $season->id }}')">
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

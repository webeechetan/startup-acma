@extends('admin.layouts.admin')

@section('meta_title', 'View All Startups | Admin Panel')
@section('meta_description', 'View All Startups')

@section('admin.content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">All Companies</h2>
            <a href="{{ route('startups.create') }}" class="btn btn-primary btn-sm">Add Company</a>
        </div>

        <div class="p-4">
            <x-admin.season-filter :selected-season="$selectedSeason" />
        </div>

        <div class="table-responsive text-nowrap card-body">
            <x-admin.datatable id="datatable-startups" :columns="['Logo', 'Name', 'Type', 'POC Name', 'Actions']" :config="[
                'order' => [[1, 'asc']],
                'columnDefs' => [
                    ['orderable' => false, 'targets' => [0, -1]],
                    ['searchable' => false, 'targets' => [0, -1]],
                ],
            ]">
                @foreach ($startups as $startup)
                    <tr>
                        <td>
                            @if ($startup->logo)
                                <img src="{{ asset('storage/' . $startup->logo) }}" alt="{{ $startup->name }}" class="rounded"
                                    style="max-width: 50px; height: auto;">
                            @else
                                <span class="text-muted">No Logo</span>
                            @endif
                        </td>
                        <td>{{ $startup->name }}</td>
                        <td>{{ $startup->type }}</td>
                        <td>{{ $startup->poc_name }}</td>
                        <td>
                            <a href="{{ route('startups.show', $startup->id) }}" class="btn btn-link btn-sm">
                                <i class="bx bx-show"></i>
                            </a>
                            <a href="{{ route('startups.edit', $startup->id) }}" class="btn btn-link btn-sm">
                                <i class="bx bx-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-admin.datatable>
        </div>
    </div>
@endsection

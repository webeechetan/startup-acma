@extends('admin.layouts.admin')

@section('meta_title', 'All Users | Admin Panel')
@section('meta_description', 'All Users')

@section('admin.content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">All Users</h2>
            <a href="{{ route('pilots.users.create') }}" class="btn btn-primary btn-sm">Add New User</a>
        </div>

        <div class="p-4">
            <x-admin.season-filter :selected-season="$selectedSeason" />
        </div>

        <div class="table-responsive text-nowrap card-body">
            <x-admin.datatable id="datatable-users" :columns="['Name', 'Email', 'Status', 'Actions']" :config="[
                'columnDefs' => [['orderable' => false, 'targets' => [-1]], ['searchable' => false, 'targets' => [-1]]],
            ]">
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('pilots.users.edit', $user->id) }}" class="btn btn-link btn-sm">
                                <i class="bx bx-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-admin.datatable>
        </div>
    </div>
@endsection

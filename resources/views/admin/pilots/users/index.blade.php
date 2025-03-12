@extends('admin.layouts.admin')

@section('meta_title', 'All Users | Admin Panel')
@section('meta_description', 'All Users')

@section('admin.content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">All Users</h2>
            <a href="{{ route('pilots.users.create') }}" class="btn btn-primary btn-sm">Add New User</a>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <x-admin.datatable id="datatable-users" :columns="['Name', 'Email', 'Actions']" :config="[
                'columnDefs' => [['orderable' => false, 'targets' => [-1]], ['searchable' => false, 'targets' => [-1]]],
            ]">
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ route('pilots.users.edit', $user->id) }}" class="btn btn-link btn-sm">
                                <i class="bx bx-edit"></i>
                            </a>
                            <form action="{{ route('pilots.users.destroy', $user->id) }}" method="POST" class="d-inline"
                                id="deleteForm{{ $user->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-link btn-sm"
                                    onclick="confirmDelete('deleteForm{{ $user->id }}')">
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

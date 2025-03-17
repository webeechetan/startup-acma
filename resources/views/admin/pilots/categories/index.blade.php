@extends('admin.layouts.admin')

@section('meta_title', 'View All Categories | Admin Panel')
@section('meta_description', 'View All Categories')

@section('admin.content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">All Categories</h2>
            <a href="{{ route('pilots.categories.create') }}" class="btn btn-primary btn-sm">Add Category</a>
        </div>
        <div class="table-responsive text-nowrap card-body">
            <x-admin.datatable id="datatable-pilots-categories" :columns="['Name', 'Actions']" :config="[
                'columnDefs' => [['orderable' => false, 'targets' => [-1]], ['searchable' => false, 'targets' => [-1]]],
            ]">

                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            <a href="{{ route('pilots.categories.edit', $category->id) }}" class="btn btn-link btn-sm">
                                <i class="bx bx-edit"></i>
                            </a>
                            <form action="{{ route('pilots.categories.destroy', $category->id) }}" method="POST"
                                class="d-inline" id="deleteForm{{ $category->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-link btn-sm"
                                    onclick="confirmDelete('deleteForm{{ $category->id }}')">
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

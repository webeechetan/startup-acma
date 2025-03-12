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
                        </td>
                    </tr>
                @endforeach

            </x-admin.datatable>
        </div>
    </div>
@endsection

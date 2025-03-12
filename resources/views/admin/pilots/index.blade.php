@extends('admin.layouts.admin')

@section('meta_title', 'View All Pilot Companies | Admin Panel')
@section('meta_description', 'View All Pilot Companies')

@section('admin.content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">All Companies</h2>
            <a href="{{ route('pilots.create') }}" class="btn btn-primary btn-sm">Add Company</a>
        </div>
        
        <div class="table-responsive text-nowrap card-body">
            <x-admin.datatable id="datatable-pilots" :columns="['Name', 'Actions']" :config="[
                'columnDefs' => [['orderable' => false, 'targets' => [-1]], ['searchable' => false, 'targets' => [-1]]],
            ]">

                @foreach ($pilots as $pilot)
                    <tr>
                        <td>{{ $pilot->name }}</td>
                        <td>
                            <a href="{{ route('pilots.edit', $pilot->id) }}" class="btn btn-link btn-sm">
                                <i class="bx bx-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach

            </x-admin.datatable>
        </div>
    </div>
@endsection

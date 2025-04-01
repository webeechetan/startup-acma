@extends('admin.layouts.admin')

@section('meta_title', 'View All Contacts | Admin Panel')
@section('meta_description', 'View All Contacts')

@section('admin.content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">All Contacts</h2>
            <a href="{{ route('contacts.create') }}" class="btn btn-primary btn-sm">Add Contact</a>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <x-admin.datatable id="datatable-contacts" :columns="['Name', 'Email', 'Message', 'Actions']" :config="[
                'order' => [[0, 'asc']],
                'columnDefs' => [['orderable' => false, 'targets' => [-1]], ['searchable' => false, 'targets' => [-1]]],
            ]">

                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>
                            <a href="javascript:void(0);" class="p-0 btn btn-link" data-bs-toggle="modal"
                                data-bs-target="#messageModal{{ $contact->id }}">
                                View Message
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" class="d-inline"
                                id="deleteForm{{ $contact->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-link btn-sm"
                                    onclick="confirmDelete('deleteForm{{ $contact->id }}')">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </x-admin.datatable>
        </div>
    </div>

    @foreach ($contacts as $contact)
        <x-admin.modal :id="'messageModal' . $contact->id" title="MESSAGE">
            <div class="mb-3">
                <p class="mt-2">{!! nl2br(e($contact->message)) !!}</p>
            </div>
        </x-admin.modal>
    @endforeach
@endsection

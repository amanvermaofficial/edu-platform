@extends('admin.layout.app')

@section('content')
<div class="container p-4">
    <h3 class="mb-4">Users</h3>

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">
        + Add User
    </a>

   {!! $dataTable->table(['id' => 'users-table', 'class' => 'table table-bordered table-striped'], true) !!}

</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush


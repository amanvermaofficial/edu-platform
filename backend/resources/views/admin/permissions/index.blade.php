@extends('admin.layout.app')

@section('content')
<div class="container p-4">
    <h3 class="mb-4">Permissions</h3>

    <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary mb-3">
        + Add Permission
    </a>

   {!! $dataTable->table(['id' => 'permissions-table', 'class' => 'table table-bordered table-striped'], true) !!}

</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush

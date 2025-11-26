@extends('admin.layout.app')

@section('content')
<div class="container p-4">
    <h3 class="mb-4">Roles</h3>

    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary mb-3">
        + Add Roles
    </a>

   {!! $dataTable->table(['id' => 'roles-table', 'class' => 'table table-bordered table-striped'], true) !!}

</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush

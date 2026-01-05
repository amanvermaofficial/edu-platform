@extends('admin.layout.app')

@section('content')
<div class="content-wrapper p-4">
    <div class="card">
        <div class="card-body">
            {!! $dataTable->table(['id' => 'studentss-table','class'=>'table table-bordered table-striped'], true) !!}
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush

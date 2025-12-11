@extends('admin.layout.app')

@section('content')
<div class="content-wrapper p-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Trades</h4>
            <a href="{{ route('admin.trades.create') }}" class="btn btn-primary">+ Add Trade</a>
        </div>
        <div class="card-body">
            {!! $dataTable->table(['id' => 'trades-table','class'=>'table table-bordered table-striped'], true) !!}
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush

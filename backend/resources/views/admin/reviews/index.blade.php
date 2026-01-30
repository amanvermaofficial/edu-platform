@extends('admin.layout.app')

@section('content')
<div class="container p-4">
    <h3 class="mb-4">Reviews</h3>

   {!! $dataTable->table(['id' => 'reviews-table', 'class' => 'table table-bordered table-striped'], true) !!}

</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush

@extends('admin.layout.app')

@section('title', 'Quiz Attempts')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8"> 
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-center">Quiz Attempts</h3>
            </div>

            <div class="card-body">
                {!! $dataTable->table(['id'=>'quiz-attempts-table','class' => 'table table-bordered table-striped'], true) !!}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush

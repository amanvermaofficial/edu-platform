@extends('admin.layout.app')

@section('content')
<div class="content-wrapper p-4">
    <div class="card">
        <div class="card-header"><h4>Create Trade</h4></div>
        <form action="{{ route('admin.trades.store') }}" method="POST">
            @csrf
            @include('admin.trades.fields')
        </form>
    </div>
</div>
@endsection

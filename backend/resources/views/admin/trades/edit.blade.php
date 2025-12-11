@extends('admin.layout.app')

@section('content')
<div class="content-wrapper p-4">
    <div class="card">
        <div class="card-header"><h4>Edit Trade</h4></div>
        <form action="{{ route('admin.trades.update', $trade->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.trades.fields')
        </form>
    </div>
</div>
@endsection

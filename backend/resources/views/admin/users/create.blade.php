@extends('admin.layout.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header"><h4>Create Users</h4></div>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            @include('admin.users.fields-create')
        </form>
    </div>
</div>
@endsection

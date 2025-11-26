@extends('admin.layout.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header"><h4>Create Role</h4></div>

        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            @include('admin.roles.fields')
        </form>
    </div>
</div>
@endsection

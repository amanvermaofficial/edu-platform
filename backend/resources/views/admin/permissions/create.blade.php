@extends('admin.layout.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Create Permission</h4>
        </div>

        <form action="{{ route('admin.permissions.store') }}" method="POST">
            @csrf

            @include('admin.permissions.fields')

        </form>
    </div>
</div>
@endsection

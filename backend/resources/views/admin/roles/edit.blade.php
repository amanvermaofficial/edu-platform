@extends('admin.layout.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header"><h4>Edit Role</h4></div>

        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.roles.fields', [
                'role' => $role,
                'permissions' => $permissions
            ])

        </form>
    </div>
</div>
@endsection

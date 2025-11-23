@extends('admin.layout.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Edit Permission</h4>
        </div>

        <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.permissions.fields', ['permission' => $permission])

        </form>
    </div>
</div>
@endsection

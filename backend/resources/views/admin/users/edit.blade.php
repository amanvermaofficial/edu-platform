@extends('admin.layout.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header"><h4>Edit Users</h4></div>

        <form action="{{ route('admin.users.update',$user->id) }}" method="POST">
            @csrf
              @method('PUT')
            @include('admin.users.fields-edit')
        </form>
    </div>
</div>
@endsection

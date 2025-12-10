@extends('admin.layout.app')

@section('content')
<div class="content-wrapper p-4">
    <div class="card">
        <div class="card-header"><h4>Create Course</h4></div>
        <form action="{{ route('admin.courses.store') }}" method="POST">
            @csrf
            @include('admin.courses.fields')
        </form>
    </div>
</div>
@endsection

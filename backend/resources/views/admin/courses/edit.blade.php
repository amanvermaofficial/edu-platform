@extends('admin.layout.app')

@section('content')
<div class="content-wrapper p-4">
    <div class="card">
        <div class="card-header"><h4>Edit Course</h4></div>
        <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.courses.fields')
        </form>
    </div>
</div>
@endsection

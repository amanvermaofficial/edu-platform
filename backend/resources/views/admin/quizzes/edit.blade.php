@extends('admin.layout.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Edit Quiz</h3>
    </div>

    <form action="{{ route('admin.quizzes.update', $quiz->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.quizzes._form')
    </form>
</div>
@endsection

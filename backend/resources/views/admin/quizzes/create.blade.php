@extends('admin.layout.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h3>Create Quiz</h3>
    </div>

    <form action="{{ route('admin.quizzes.store') }}" method="POST">
        @csrf
        @include('admin.quizzes._form')
    </form>
</div>
@endsection

@extends('admin.layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="content-wrapper">

    {{-- Header --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Main content --}}
    <section class="content">
        <div class="container-fluid">

            {{-- ROW 1 --}}
            <div class="row">

                {{-- Students --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $studentsCount }}</h3>
                            <p>Total Students</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <a href="{{ route('admin.students.index') }}" class="small-box-footer">
                            View Students <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                {{-- Quizzes --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $quizzesCount }}</h3>
                            <p>Total Quizzes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <a href="{{ route('admin.quizzes.index') }}" class="small-box-footer">
                            View Quizzes <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                {{-- Quiz Attempts --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $attemptsCount }}</h3>
                            <p>Quiz Attempts</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <a href="{{ route('admin.quiz-attempts.index') }}" class="small-box-footer">
                            View Attempts <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                {{-- Pending Reviews --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $pendingReviews }}</h3>
                            <p>Pending Reviews</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <a href="{{ route('admin.reviews.index') }}" class="small-box-footer">
                            Moderate Reviews <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

            </div>

            {{-- ROW 2 --}}
            <div class="row">

                {{-- Published Reviews --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $publishedReviews }}</h3>
                            <p>Published Reviews</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <a href="{{ route('admin.reviews.index') }}" class="small-box-footer">
                            View Reviews <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                {{-- Courses --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $coursesCount }}</h3>
                            <p>Courses</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <a href="{{ route('admin.courses.index') }}" class="small-box-footer">
                            View Courses <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                {{-- Trades --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>{{ $tradesCount }}</h3>
                            <p>Trades</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <a href="{{ route('admin.trades.index') }}" class="small-box-footer">
                            View Trades <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>
</div>
@endsection

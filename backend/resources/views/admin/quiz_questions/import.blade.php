@extends('admin.layout.app')

@section('content')
<div class="container-fluid pt-4">
    {{-- Success Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-1"></i>
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif

{{-- Error Message --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-times-circle mr-1"></i>
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-file-csv mr-2"></i>
                        Upload Quiz Questions (CSV)
                    </h5>
                </div>

                <form action="{{ route('admin.quiz.questions.import.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">

                        {{-- Quiz --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Select Quiz</label>
                            <select name="quiz_id" class="form-control @error('quiz_id') is-invalid @enderror">
                                <option value="">-- Select Quiz --</option>
                                @foreach($quizzes as $quiz)
                                    <option value="{{ $quiz->id }}" {{ old('quiz_id') == $quiz->id ? 'selected' : '' }}>
                                        {{ $quiz->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('quiz_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- CSV --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Upload CSV File</label>
                            <input type="file" 
                                   name="file" 
                                   class="form-control-file @error('file') is-invalid @enderror"
                                   accept=".csv">
                            <small class="text-muted">
                                Only .csv file allowed
                            </small>
                            @error('file')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary mr-2">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload mr-1"></i> Upload
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection

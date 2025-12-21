@extends('admin.layout.app')

@push('styles')
<style>
    .card {
        border-radius: 6px;
    }

    .card-header h3 {
        font-size: 18px;
        margin-bottom: 0;
    }

    .form-control {
        height: 38px;
        font-size: 14px;
    }

    .form-control textarea {
        height: auto;
    }

    .select2-container .select2-selection--multiple {
        min-height: 38px;
        padding: 4px 6px;
        border: 1px solid #ced4da;
    }

    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
        background-color: #007bff;
        border: none;
        color: #fff;
        padding: 2px 8px;
        margin-top: 4px;
        font-size: 13px;
    }

    .select2-container--bootstrap4 .select2-selection__choice__remove {
        color: #fff;
        margin-right: 5px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid pt-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3>
                        <i class="fas fa-pen mr-2"></i>
                        {{ isset($quiz) ? 'Edit Quiz' : 'Create Quiz' }}
                    </h3>
                </div>

                <form action="{{ isset($quiz) ? route('admin.quizzes.update', $quiz->id) : route('admin.quizzes.store') }}" 
                      method="POST">
                    @csrf
                    @if(isset($quiz))
                        @method('PUT')
                    @endif

                    <div class="card-body">

                        {{-- Display Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Quiz Name --}}
                        <div class="form-group">
                            <label>Quiz Name <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   placeholder="Enter quiz name"
                                   value="{{ old('title', $quiz->title ?? '') }}">
                            @error('title')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Quiz description">{{ old('description', $quiz->description ?? '') }}</textarea>
                            @error('description')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Duration --}}
                        <div class="form-group">
                            <label>Duration (Minutes)</label>
                            <input type="number"
                                   name="duration"
                                   class="form-control @error('duration') is-invalid @enderror"
                                   placeholder="Eg: 30"
                                   value="{{ old('duration', $quiz->duration ?? '') }}">
                            @error('duration')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Total Marks --}}
                        <div class="form-group">
                            <label>Total Marks</label>
                            <input type="number"
                                   name="total_marks"
                                   class="form-control @error('total_marks') is-invalid @enderror"
                                   placeholder="Eg: 100"
                                   value="{{ old('total_marks', $quiz->total_marks ?? '') }}">
                            @error('total_marks')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Course-Trade Mapping --}}
                        <div class="form-group">
                            <label>Assign Course & Trade</label>
                            <select name="course_trade_ids[]"
                                    class="form-control select2"
                                    multiple>
                                @foreach($courseTrades as $ct)
                                    <option value="{{ $ct->id }}"
                                        {{ isset($quiz) && $quiz->courseTrades->pluck('id')->contains($ct->id) ? 'selected' : '' }}>
                                        {{ $ct->course->name }} — {{ $ct->trade->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary mr-2">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            {{ isset($quiz) ? 'Update Quiz' : 'Create Quiz' }}
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: 'Select course & trade',
            theme: 'bootstrap4',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush

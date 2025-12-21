@extends('admin.layout.app')

@section('content')
    <div class="d-flex justify-content-center flex-column align-items-center w-100 pt-4">

        <div class="card w-75">
            <div class="card-header">
                <h4>Quiz Attempt Details</h4>
            </div>

            <div class="card-body">
                <p><strong>Student:</strong> {{ $attempt->student->name }}</p>
                <p><strong>Quiz:</strong> {{ $attempt->quiz->title }}</p>
                <p><strong>Score:</strong> {{ $attempt->score }}</p>
            </div>
        </div>

        <div class="card mt-3 w-75">
            <div class="card-header">
                <h5>Questions</h5>
            </div>

            <div class="card-body">

                @foreach ($answers as $index => $answer)
                    <div class="mb-4">
                        <p>
                            <strong>Q{{ $answers->firstItem() + $index }}.</strong>
                            {{ $answer->question->question_text }}
                        </p>

                        <ul>
                            @foreach ($answer->question->options as $option)
                                <li
                                    style="
                                {{ $option->option_text == $answer->correct_option ? 'color:green;' : '' }}
                                {{ $option->option_text == $answer->selected_option && !$answer->is_correct ? 'color:red;' : '' }}
                            ">
                                    {{ $option->option_text }}

                                    @if ($option->option_text == $answer->selected_option)
                                        <strong>(Selected)</strong>
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        <p>
                            Result:
                            @if ($answer->is_correct)
                                <span class="text-success">Correct</span>
                            @else
                                <span class="text-danger">Wrong</span>
                            @endif
                        </p>
                    </div>
                    <hr>
                @endforeach

                <!-- Pagination links -->
                <div class="d-flex justify-content-between mt-4 w-100">

                    {{-- Previous --}}
                    @if ($answers->onFirstPage())
                        <button class="btn btn-secondary" disabled>← Previous</button>
                    @else
                        <a href="{{ $answers->previousPageUrl() }}" class="btn btn-primary">
                            ← Previous
                        </a>
                    @endif

                    {{-- Next --}}
                    @if ($answers->hasMorePages())
                        <a href="{{ $answers->nextPageUrl() }}" class="btn btn-primary">
                            Next →
                        </a>
                    @else
                        <button class="btn btn-secondary" disabled>Next →</button>
                    @endif

                </div>

            </div>
        </div>
    </div>
@endsection

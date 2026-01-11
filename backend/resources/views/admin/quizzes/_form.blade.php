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

    /* ✅ Duration Input Styles */
    .duration-wrapper {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 15px;
    }

    .duration-input-group {
        display: flex;
        align-items: center;
        gap: 15px;
        justify-content: center;
        margin-bottom: 15px;
    }

    .duration-field {
        text-align: center;
    }

    .duration-field input {
        width: 80px;
        height: 50px;
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        border: 2px solid #ced4da;
        border-radius: 6px;
    }

    .duration-field input:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .duration-field label {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
        display: block;
    }

    .duration-separator {
        font-size: 30px;
        font-weight: bold;
        color: #6c757d;
        margin-top: -20px;
    }

    .duration-preview {
        background: #e7f3ff;
        border: 1px solid #b3d9ff;
        border-radius: 6px;
        padding: 10px;
        text-align: center;
    }

    .duration-preview strong {
        color: #007bff;
        font-size: 16px;
    }

    .preset-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 15px;
    }

    .preset-btn {
        padding: 5px 12px;
        font-size: 13px;
        border: 1px solid #ced4da;
        background: white;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .preset-btn:hover {
        background: #007bff;
        color: white;
        border-color: #007bff;
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
                      method="POST" id="quizForm">
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

                        {{-- ✅ NEW: Duration (Minutes + Seconds) --}}
                        <div class="form-group">
                            <label>Duration <span class="text-danger">*</span></label>
                            
                            <div class="duration-wrapper">
                                {{-- Quick Presets --}}
                                <div class="preset-buttons">
                                    <button type="button" class="preset-btn" data-minutes="0" data-seconds="30">30 sec</button>
                                    <button type="button" class="preset-btn" data-minutes="1" data-seconds="0">1 min</button>
                                    <button type="button" class="preset-btn" data-minutes="2" data-seconds="0">2 min</button>
                                    <button type="button" class="preset-btn" data-minutes="5" data-seconds="0">5 min</button>
                                    <button type="button" class="preset-btn" data-minutes="10" data-seconds="0">10 min</button>
                                    <button type="button" class="preset-btn" data-minutes="30" data-seconds="0">30 min</button>
                                    <button type="button" class="preset-btn" data-minutes="60" data-seconds="0">1 hour</button>
                                </div>

                                {{-- Minutes + Seconds Input --}}
                                <div class="duration-input-group">
                                    <div class="duration-field">
                                        <input type="number" 
                                               id="duration_minutes" 
                                               min="0" 
                                               max="180" 
                                               value="{{ old('duration_minutes', isset($quiz) ? floor($quiz->duration / 60) : 0) }}"
                                               placeholder="00">
                                        <label>Minutes (0-180)</label>
                                    </div>

                                    <div class="duration-separator">:</div>

                                    <div class="duration-field">
                                        <input type="number" 
                                               id="duration_seconds" 
                                               min="0" 
                                               max="59" 
                                               value="{{ old('duration_seconds', isset($quiz) ? $quiz->duration % 60 : 0) }}"
                                               placeholder="00">
                                        <label>Seconds (0-59)</label>
                                    </div>
                                </div>

                                {{-- Preview --}}
                                <div class="duration-preview">
                                    <small class="text-muted">Total Duration:</small><br>
                                    <strong id="duration_display">0 seconds</strong><br>
                                    <small class="text-muted">(Backend receives: <span id="backend_value">0</span> seconds)</small>
                                </div>

                                {{-- ✅ Hidden field that sends to backend --}}
                                <input type="hidden" 
                                       name="duration" 
                                       id="duration_total" 
                                       value="{{ old('duration', $quiz->duration ?? 0) }}">
                            </div>
                            
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
        // Select2 initialization
        $('.select2').select2({
            placeholder: 'Select course & trade',
            theme: 'bootstrap4',
            allowClear: true,
            width: '100%'
        });

        // ✅ Duration Calculator
        const minutesInput = $('#duration_minutes');
        const secondsInput = $('#duration_seconds');
        const totalInput = $('#duration_total');
        const displayText = $('#duration_display');
        const backendValue = $('#backend_value');

        function calculateDuration() {
            const minutes = parseInt(minutesInput.val()) || 0;
            const seconds = parseInt(secondsInput.val()) || 0;
            const totalSeconds = (minutes * 60) + seconds;

            // Update hidden field
            totalInput.val(totalSeconds);

            // Update backend value display
            backendValue.text(totalSeconds);

            // Update display text
            let displayParts = [];
            if (minutes > 0) {
                displayParts.push(minutes + ' minute' + (minutes !== 1 ? 's' : ''));
            }
            if (seconds > 0) {
                displayParts.push(seconds + ' second' + (seconds !== 1 ? 's' : ''));
            }
            
            if (displayParts.length === 0) {
                displayText.text('0 seconds');
            } else {
                displayText.text(displayParts.join(' and '));
            }
        }

        // Calculate on input change
        minutesInput.on('input', function() {
            const val = parseInt($(this).val()) || 0;
            if (val < 0) $(this).val(0);
            if (val > 180) $(this).val(180);
            calculateDuration();
        });

        secondsInput.on('input', function() {
            const val = parseInt($(this).val()) || 0;
            if (val < 0) $(this).val(0);
            if (val > 59) $(this).val(59);
            calculateDuration();
        });

        // Preset buttons
        $('.preset-btn').on('click', function() {
            const minutes = $(this).data('minutes');
            const seconds = $(this).data('seconds');
            minutesInput.val(minutes);
            secondsInput.val(seconds);
            calculateDuration();
        });

        // Initial calculation
        calculateDuration();

        // Form validation
        $('#quizForm').on('submit', function(e) {
            const totalSeconds = parseInt(totalInput.val()) || 0;
            if (totalSeconds === 0) {
                e.preventDefault();
                alert('Please set a duration greater than 0');
                return false;
            }
        });
    });
</script>
@endpush
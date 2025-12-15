<div class="card-body">

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
    <button type="submit" class="btn btn-primary">
        {{ isset($quiz) ? 'Update Quiz' : 'Create Quiz' }}
    </button>
</div>
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

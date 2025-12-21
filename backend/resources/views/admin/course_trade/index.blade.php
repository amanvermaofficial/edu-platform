@extends('admin.layout.app')

@push('styles')
<style>
    .card {
        border-radius: 6px;
    }

    .card-header h5 {
        font-size: 16px;
        margin-bottom: 0;
    }

    .form-control {
        height: 38px;
        font-size: 14px;
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
        <div class="col-lg-5 col-md-7">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5>
                        <i class="fas fa-link mr-2"></i>
                        Map Trades to Course
                    </h5>
                </div>

                <form method="POST"
                      action="{{ route('admin.courses.map-trades.update', $course->id) }}">
                    @csrf

                    <div class="card-body">

                        {{-- Course --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Course</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $course->name }}"
                                   readonly>
                        </div>

                        {{-- Trades --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Select Trades</label>
                            <select name="trade_ids[]"
                                    class="form-control select2"
                                    multiple>
                                @foreach ($trades as $trade)
                                    <option value="{{ $trade->id }}"
                                        {{ in_array($trade->id, $mappedTrades) ? 'selected' : '' }}>
                                        {{ $trade->name }}
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
                            <i class="fas fa-save mr-1"></i> Save Mapping
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
    $('.select2').select2({
        placeholder: 'Select trades',
        theme: 'bootstrap4',
        allowClear: true,
        width: '100%'
    });
</script>
@endpush

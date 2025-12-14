@extends('admin.layout.app')

@push('styles')
    <style>
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
        }

        .select2-container--bootstrap4 .select2-selection__choice__remove {
            color: #fff;
            margin-right: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Map Trades to Course</h5>
        </div>

        <form method="POST" action="{{ route('admin.courses.map-trades.update', $course->id) }}">
            @csrf

            <div class="card-body">

                <!-- Course -->
                <div class="form-group">
                    <label>Course</label>
                    <input type="text" class="form-control" value="{{ $course->name }}" readonly>
                </div>

                <!-- Trades -->
                <div class="form-group">
                    <label>Trades</label>
                    <select name="trade_ids[]" class="form-control select2" multiple>
                        @foreach ($trades as $trade)
                            <option value="{{ $trade->id }}" {{ in_array($trade->id, $mappedTrades) ? 'selected' : '' }}>
                                {{ $trade->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="card-footer text-right">
                <button class="btn btn-primary">Save Mapping</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: 'Select trades',
            allowClear: true,
            width: '100%'
        });
    </script>
@endpush

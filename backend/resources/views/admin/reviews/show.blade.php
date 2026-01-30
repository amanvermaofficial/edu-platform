@extends('admin.layout.app')

@section('title', 'View Review')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Card --}}
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Student Review</h5>

                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-secondary">
                        ← Back
                    </a>
                </div>

                <div class="card-body">

                    {{-- Student Info --}}
                    <div class="d-flex align-items-center mb-4">
                        <img
                            src="{{ $review->student->profile_picture ?? asset('admin/img/avatar.png') }}"
                            alt="Student"
                            class="rounded-circle mr-3"
                            width="70"
                            height="70"
                        >

                        <div>
                            <h6 class="mb-1 font-weight-bold">
                                {{ $review->student->name }}
                            </h6>

                            <span class="badge {{ $review->is_published ? 'badge-success' : 'badge-warning' }}">
                                {{ $review->is_published ? 'Published' : 'Pending' }}
                            </span>
                        </div>
                    </div>

                    {{-- Review Text --}}
                    <div class="border rounded p-3 bg-light">
                        <p class="mb-0 font-italic text-dark">
                            “{{ $review->description }}”
                        </p>
                    </div>

                    {{-- Meta --}}
                    <div class="mt-4 text-muted small">
                        <div>
                            <strong>Submitted At:</strong>
                            {{ $review->created_at->format('d M Y, h:i A') }}
                        </div>

                        @if($review->published_at)
                            <div>
                                <strong>Published At:</strong>
                                {{ $review->published_at->format('d M Y, h:i A') }}
                            </div>
                        @endif
                    </div>

                </div>

                {{-- Actions --}}
                <div class="card-footer d-flex justify-content-end gap-2">
                    @can('reviews.update')
                        <form action="{{ route('admin.reviews.toggle-status', $review->id) }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                class="btn btn-sm {{ $review->is_published ? 'btn-warning' : 'btn-success' }}"
                                onclick="return confirm('Are you sure?')"
                            >
                                {{ $review->is_published ? 'Unpublish' : 'Publish' }}
                            </button>
                        </form>
                    @endcan

                    @can('reviews.delete')
                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this review?')"
                            >
                                Delete
                            </button>
                        </form>
                    @endcan
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

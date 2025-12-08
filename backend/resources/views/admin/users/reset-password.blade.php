@extends('admin.layout.app')

@section('title', 'Reset User Password')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Reset Password</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.users.reset-password.update-password', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- User Info --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">User</label>
                    <input type="text" class="form-control" value="{{ $user->name }} ({{ $user->email }})" disabled>
                </div>

                {{-- New Password --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">New Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Enter new password" required>

                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" 
                           class="form-control @error('password_confirmation') is-invalid @enderror" 
                           placeholder="Confirm new password" required>

                    @error('password_confirmation')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-success">Update Password</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

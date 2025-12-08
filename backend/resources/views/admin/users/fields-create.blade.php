<div class="card-body">

    {{-- Name --}}
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name"
            class="form-control @error('name') is-invalid @enderror"
            placeholder="Enter name"
            value="{{ old('name') }}">
        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    {{-- Email --}}
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email"
            class="form-control @error('email') is-invalid @enderror"
            placeholder="Enter email"
            value="{{ old('email') }}">
        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    {{-- Role --}}
    <div class="form-group">
        <label>Role</label>
        <select name="role" class="form-control select2 @error('role') is-invalid @enderror">
            <option value="">Select Role</option>
            @foreach ($roles as $role)
                <option value="{{ $role->name }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
        @error('role') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    {{-- Password --}}
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="Enter password">
        @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    {{-- Confirm Password --}}
    <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation"
            class="form-control" placeholder="Confirm password">
    </div>

</div>

<div class="card-footer text-right">
    <button type="submit" class="btn btn-primary">Create User</button>
</div>

@push('scripts')
<script>
    $('.select2').select2({ width: '100%' });
</script>
@endpush

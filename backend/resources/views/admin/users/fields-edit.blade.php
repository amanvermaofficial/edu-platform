<div class="card-body">

    {{-- Name --}}
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name) }}">
        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    {{-- Email --}}
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $user->email) }}">
        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    {{-- Role --}}
    <div class="form-group">
        <label>Role</label>
        <select name="role" class="form-control select2 @error('role') is-invalid @enderror">
            @foreach ($roles as $role)
                <option value="{{ $role->name }}"
                    {{ $user->roles->first()->id ?? '' == $role->id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
        @error('role') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

</div>

<div class="card-footer text-right">
    <button type="submit" class="btn btn-primary">Update User</button>
</div>

@push('scripts')
<script>
    $('.select2').select2({ width: '100%' });
</script>
@endpush

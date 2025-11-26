<div class="card-body">
    {{-- Role Name --}}
    <div class="form-group">
        <label for="name">Role Name</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
            placeholder="Enter role name" value="{{ old('name', isset($role) ? $role->name : '') }}">

        @error('name')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="permissions">Assign Permissions</label>
        <select name="permissions[]" id="permissions"
            class="form-control select2 @error('permissions') is-invalid @enderror" multiple>
            @foreach ($permissions as $permission)
                <option value="{{ $permission->id }}"
                    {{ isset($role) && $role->hasPermissionTo($permission->name) ? 'selected' : '' }}>
                    {{ $permission->name }}
                </option>
            @endforeach
        </select>
        @error('permissions')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>

    <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary">
            {{ isset($role) ? 'Update Role' : 'Create Role' }}
        </button>
    </div>

</div>
@push('scripts')
<script>
    $(document).ready(function() {
        $('#permissions').select2({
             theme: 'bootstrap4',
            placeholder: 'Select Permissions',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush
<div class="card-body">
    <div class="form-group">
        <label for="name">Permission Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
            placeholder="Permission Name" value="{{ old('name', isset($permission) ? $permission->name : '') }}"
            placeholder="Enter Permission name">
        @error('name')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>
    <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary">
            {{ isset($permission) ? 'Update Permission' : 'Create Permission' }}
        </button>
    </div>
</div>

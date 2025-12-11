<div class="card-body">
    <div class="form-group">
        <label for="name">Trade Name</label>
        <input type="text" name="name" id="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', isset($trade) ? $trade->name : '') }}"
            placeholder="Enter trade name">
        @error('name') 
            <span class="text-danger small">{{ $message }}</span> 
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" rows="4"
            class="form-control @error('description') is-invalid @enderror"
            placeholder="Enter description">{{ old('description', isset($trade) ? $trade->description : '') }}</textarea>
        @error('description') 
            <span class="text-danger small">{{ $message }}</span> 
        @enderror
    </div>
</div>

<div class="card-footer text-right">
    <button class="btn btn-primary" type="submit">
        {{ isset($trade) ? 'Update Trade' : 'Create Trade' }}
    </button>
</div>

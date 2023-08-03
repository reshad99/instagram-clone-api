<div class="form-group">
    <label for="permissionDesc" class="form-label">{{ __('Role title') }}</label>
    <input type="text"
           class="form-control @error('title') is-invalid @enderror"
           name="title"
           value="{{ old("title", $item->title) }}"
           id="permissionDesc" placeholder="{{ __('Role title') }}" required>
    @error('title')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="md-3">
    <div class="position-relative form-group">
        <div>
            <label for="exampleSelect" class="">Select permissions</label>
        </div>
        <div class="row">
            @foreach($permissions as $permission)
                <div class="col-md-4">
                    <label>
                        <input @if($item->hasPermissionTo($permission->name)) checked @endif type="checkbox" name="permissions[]" value="{{ $permission->name }}"> {{ $permission->title }}
                    </label>
                </div>
            @endforeach
        </div>

    </div>
</div>

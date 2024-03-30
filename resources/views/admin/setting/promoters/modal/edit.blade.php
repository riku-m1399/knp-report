<div class="modal fade mt-5" id="edit-promoter-{{ $promoter->id }}">
  <div class="modal-dialog">
    <div class="modal-content border-warning">
      <div class="modal-header border-warning">
        <h3 class="h5 modal-title text-warning">
          <i class="fa-regular fa-pen-to-square"></i> Update Promoter
        </h3>
      </div>
      <div class="modal-body text-start">
        <form action="{{ route('admin.setting.promoters.update', $promoter->id) }}" method="post" class="my-3 mx-3">
          @csrf
          @method('PATCH')

          <div class="mb-3">
            <label for="name" class="form-label fw-bold">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $promoter->name) }}" autofocus>
            {{-- Error message --}}
            @error('name')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email Address</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $promoter->email) }}">
            {{-- Error message --}}
            @error('email')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-3">
            <label for="role_id" class="form-label fw-bold">Role</label>
            <select name="role_id" class="form-control">
              <option value="2" @if ($promoter->role_id === 2) selected @endif>Promoter</option>
              <option value="1" @if ($promoter->role_id === 1) selected @endif>Admin</option>
            </select>
          </div>
          <button type="submit" class="btn btn-warning px-5">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
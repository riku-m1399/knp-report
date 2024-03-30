<div class="modal fade mt-5" id="edit-place-{{ $place->id }}">
  <div class="modal-dialog">
    <div class="modal-content border-warning">
      <div class="modal-header border-warning">
        <h3 class="h5 modal-title text-warning">
          <i class="fa-regular fa-pen-to-square"></i> Update Place
        </h3>
      </div>
      <div class="modal-body text-start">
        
        <form action="{{ route('admin.setting.places.update', $place->id) }}" method="post" class="my-3 mx-3">
          @csrf
          @method('PATCH')
          
          <div class="mb-3">
            <label for="name" class="form-label fw-bold">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $place->name) }}" autofocus>
            {{-- Error message --}}
            @error('name')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-3">
            <label for="fee" class="form-label fw-bold">Fee</label>
            <input type="number" name="fee" class="form-control" value="{{ old('fee', $place->fee) }}" min="0" required>
            {{-- Error message --}}
            @error('fee')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
          </div>
          <p class="text-danger">*If you change the information of the place, it affects the reports in the past related to the place.</p>
          <button type="submit" class="btn btn-warning px-5">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
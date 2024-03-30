<div class="modal fade mt-5" id="delete-place-{{ $place->id }}">
  <div class="modal-dialog">
    <div class="modal-content border-danger">
      <div class="modal-header border-danger">
        <h3 class="h5 modal-title text-danger">
          <i class="fa-solid fa-circle-exclamation"></i> Delete Place
        </h3>
      </div>
      <div class="modal-body text-start">
        <p>Are you sure you want to delete this place?</p>
        <div class="mt-3">

          <table class="table table-bordered table-hover align-middle">
            <tbody class="text-center">
              <tr>
                <td>{{ $place->name }}</td>
                <td>{{ $place->fee }}</td>
                <td>{{ $place->created_at }}</td>
                <td>{{ $place->updated_at }}</td>
              </tr>
            </tbody>
          </table>

          <form action="{{ route('admin.setting.places.destroy', $place->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger px-5">Delete</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade mt-5" id="delete-report-{{ $report->id }}">
  <div class="modal-dialog">
    <div class="modal-content border-danger">
      <div class="modal-header border-danger">
        <h3 class="h5 modal-title text-danger">
          <i class="fa-solid fa-circle-exclamation"></i> Delete Report
        </h3>
      </div>
      <div class="modal-body text-start">
        <p>Are you sure you want to delete this report?</p>
        <div class="mt-3">

          <table class="table table-bordered table-hover align-middle">
            <tbody class="text-center">
              <tr>
                <td>{{ $report->date }}</td>
                <td>{{ $report->promoter->name }}</td>
                <td>{{ $report->place->name }}</td>
                <td>{{ $report->entries }}</td>
                <td>{{ $report->place->fee }}</td>
                <td>
                  <button id="note-dropdown" class="btn btn-link text-dark" data-bs-toggle="dropdown">
                      {{ Str::limit($report->note, 10, '...') }}
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" area-labelledby="note-dropdown">
                      <div class="dropdown-item">{{ $report->note }}</div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>

          <form action="{{ route('report.destroy', $report->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger px-5">Delete</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
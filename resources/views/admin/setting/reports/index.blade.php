@extends('layouts.app')

@section('title', 'Admin: Reports')
    
@section('content')
    <div class="container">
      <div class="row justify-content-center gx-5">
        <h1 class="text-center my-5">Setting: Reports</h1>
        <div class="col-3">
          <div class="list-group">
            <a href="{{ route('admin.setting.promoters') }}" class="list-group-item"><i class="fa-solid fa-users"></i> Promoters</a>
            <a href="{{ route('admin.setting.places') }}" class="list-group-item"><i class="fa-solid fa-location-dot"></i> Places</a>
            <a href="{{ route('admin.setting.reports') }}" class="list-group-item active"><i class="fa-solid fa-newspaper"></i> Reports</a>
          </div>
        </div>
        <div class="col-9">

          <table class="table table-bordered table-hover align-middle">
            <thead class="text-center">
                <tr class="table-primary">
                    <th>DATE</th>
                    <th>PROMOTER</th>
                    <th>PLACE</th>
                    <th>ENTRIES</th>
                    <th>FEE</th>
                    <th>NOTE</th>
                    <th>Created At</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($all_reports as $report)
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
                        <td>{{ $report->created_at }}</td>
                        <td><a href="{{ route('report.edit', $report->id) }}" class="text-warning">Edit</a></td>
                        <td>
                            <button href="" class="btn btn-link text-danger" data-bs-toggle="modal" data-bs-target="#delete-report-{{ $report->id }}">Delete</button>
                            @include('report.delete')
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
          {{ $all_reports->links() }}
        </div>
      </div>
    </div>
@endsection
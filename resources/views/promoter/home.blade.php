@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1 class="text-center my-5">{{ Auth::user()->name }}'s Report</h1>

        <div class="col-9">
            @if ($home_reports)
                <form action="{{ route('index') }}" method="get">
                    <div class="row mb-3 gx-0">
                        {{-- Place select --}}
                        <div class="col-2 me-5">
                            <select name="place_id" class="form-control">
                                <option value="" hidden>Place</option>
                                @foreach ($all_places as $place)
                                    <option value="{{ $place->id }}">{{ $place->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Date select --}}
                        <div class="col-3 me-0">
                            <input type="date" class="form-control" name="date_start">
                        </div>
                        <div class="col-1 my-auto me-0 text-center mx-0">~</div>
                        <div class="col-3 me-3 ms-0">
                            <input type="date" class="form-control" name="date_end">
                        </div>
                        <div class="col text-end">
                            <button type="submit" class="btn btn-secondary">Filter</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <p>
                        @if (Request::input('place_id'))
                            <span class="ms-2">Place: {{ $all_places[Request::input('place_id') -1]['name'] }}</span>
                        @endif
                        @if (Request::input('date_start'))
                            <span class="ms-2">From: {{ Request::input('date_start') }}</span>
                        @endif
                        @if (Request::input('date_end'))
                            <span class="ms-2">To: {{ Request::input('date_end') }}</span>
                        @endif
                    </p>
                </div>
                <table class="table table-bordered table-hover align-middle">
                    <thead class="text-center">
                        <tr class="table-success">
                            <th>DATE</th>
                            <th>PROMOTER</th>
                            <th>PLACE</th>
                            <th>ENTRIES</th>
                            <th>FEE</th>
                            <th>NOTE</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($filtered_home_reports as $report)
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
                                    <div class="dropdown-menu dropdown-menu-end" area-labeledby="note-dropdown">
                                        <div class="dropdown-item">{{ $report->note }}</div>
                                    </div>
                                </td>
                                <td><a href="{{ route('report.edit', $report->id) }}" class="text-warning">Edit</a></td>
                                <td>
                                    <button class="btn btn-link text-danger" data-bs-toggle="modal" data-bs-target="#delete-report-{{ $report->id }}">Delete</button>
                                    @include('report.delete')
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center">
                    <p class="text-muted">When you make reports, they'll appear here.</p>
                    <a href="{{ route('report.create') }}" class="text-decolation-none">Make Your First Report</a>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
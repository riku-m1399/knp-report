@extends('layouts.app')

@section('title', 'Dashboard')
    
@section('content')
    <div class="container">
      <div class="row justify-content-center gx-5">
        <h1 class="text-center my-5">Dashboard</h1>
        <div class="col-3">
          <form action="{{ route('admin.dashboard') }}" method="get">
            <div class="row">
              <h1 class="h5 fw-bold mb-3">Filter</h1>
      
              {{-- Promoter select --}}
              <div class="mb-3">
                <label for="promoter_id" class="form-label fw-bold">Promoter</label>
                <select name="promoter_id" class="form-control">
                  <option value="" hidden>Select a promoter</option>
                  @foreach ($all_promoters as $promoter)
                      <option value="{{ $promoter->id }}">{{ $promoter->name }}</option>
                  @endforeach
                </select>
              </div>
              
              {{-- Place select --}}
              <div class="mb-3">
                <label for="place_id" class="form-label fw-bold">Place</label>
                <select name="place_id" class="form-control">
                  <option value="" hidden>Select a place</option>
                  @foreach ($all_places as $place)
                      <option value="{{ $place->id }}">{{ $place->name }}</option>
                  @endforeach
                </select>
              </div>

              {{-- Date select --}}
              <div class="mb-5">
                <label for="date" class="form-label fw-fold">Date</label>
                <div class="mb-1">
                    <input type="date" class="form-control" name="date_start">
                </div>
                <div class="mb-0 text-center">~</div>
                <div class="mb-1">
                    <input type="date" class="form-control" name="date_end">
                </div>
              </div>

              <div>
                <button type="submit" name="filter" class="btn btn-secondary w-100">Filter</button>
              </div>
            </div>
          </form>   
        </div>

        <div class="col-9">

          <div class="row mb-5">
            <h1 class="h4"></h1>
          </div>
          <div class="row mb-5">
            <h1 class="h4">Entries by Club <span class="small text-danger h5">(filter by promoter and date)</span></h1>
            <p>
              @if (Request::input('promoter_id'))
                  <span class="ms-2">Promoter: {{ $all_promoters[Request::input('promoter_id') -1]['name'] }}</span>
              @endif
              @if (Request::input('date_start'))
                  <span class="ms-2">From: {{ Request::input('date_start') }}</span>
              @endif
              @if (Request::input('date_end'))
                  <span class="ms-2">To: {{ Request::input('date_end') }}</span>
              @endif
            </p>
            <div>
              <canvas id="chart"></canvas>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx = document.getElementById('chart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($graph_labels),
                        datasets: [{
                            label: 'Entries by club',
                            data: @json($graph_data),
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
          </div>

          <div class="row mb-5">
            <h1 class="h4">Sales Representative Key Performance Indicators <span class="small text-danger h5">(filter by date)</span></h1>
            <p>
              @if (Request::input('date_start'))
                  <span class="ms-2">From: {{ Request::input('date_start') }}</span>
              @endif
              @if (Request::input('date_end'))
                  <span class="ms-2">To: {{ Request::input('date_end') }}</span>
              @endif
            </p>
            <table class="table table-bordered table-hover align-middle">
              <thead class="text-center">
                <tr class="table-secondary">
                  <th>SALES REP NAME</th>
                  @foreach ($all_places as $place)
                      <th>{{ $place->name }}</th>
                  @endforeach
                  <th>INCOME</th>
                </tr>
              </thead>
              <tbody class="text-center">
                @php
                    // define total
                    $total_entries = [];
                    $total_income = 0;
                @endphp
                @foreach ($all_promoters as $promoter)
                    <tr>
                      @php
                          // define income
                          $income = 0;
                      @endphp
                      <td>{{ $promoter->name }}</td>
                      @foreach ($all_places as $place)
                        @php
                            // count entries
                            $count_entries = 0;
                            foreach($filtered_dashboard_reports_by_date as $filtered_dashboard_report_by_date){
                              if($filtered_dashboard_report_by_date->promoter_id == $promoter->id && $filtered_dashboard_report_by_date->place_id == $place->id){
                                $count_entries += $filtered_dashboard_report_by_date->entries;
                              }
                            }

                            // calculate income by the promoter
                            $income += $place->fee * $count_entries;

                            // add total
                            if(isset($total_entries[$place->id])){
                              $total_entries[$place->id] += $count_entries;
                            }else{
                              $total_entries[$place->id] = $count_entries;
                            }
                            $total_income += $income;
                        @endphp
                        <td>{{ $count_entries }}</td>
                      @endforeach
                      <td>{{ $income }}</td>
                    </tr>
                @endforeach
                <tr>
                  <td>TOTAL</td>
                  @foreach ($all_places as $place)
                      <td>{{ $total_entries[$place->id] }}</td>
                  @endforeach
                  <td>{{ $total_income }}</td>
                </tr>
              </tbody>
            </table>
          </div>

          @if (Request::input())
            <div class="row">
              <h1 class="h4">Reports <span class="small text-danger h5">(filter by promoter, place, and date)</span></h1>
              <p>
                @if (Request::input('promoter_id'))
                    <span class="ms-2">Promoter: {{ $all_promoters[Request::input('promoter_id') -1]['name'] }}</span>
                @endif
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
              <table class="table table-bordered table-hover align-middle">
                <thead class="text-center">
                    <tr class="table-primary">
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
                    @foreach ($filtered_dashboard_reports as $report)
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
                            <td><a href="{{ route('report.edit', $report->id) }}" class="text-warning">Edit</a></td>
                            <td>
                                <button href="" class="btn btn-link text-danger" data-bs-toggle="modal" data-bs-target="#delete-report-{{ $report->id }}">Delete</button>
                                @include('report.delete')
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>
    </div>
@endsection
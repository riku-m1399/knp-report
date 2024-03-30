@extends('layouts.app')

@section('title', 'Panel')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <h1 class="text-center my-5">{{ Auth::user()->name }}'s monthly panel</h1>
    <table class="table table-bordered table-hover align-middle">
      <thead class="text-center">
        <tr class="table-secondary">
          <th>Month</th>
          @foreach ($all_places as $place)
            <th>{{ $place->name }} (¥{{$place->fee}})</th>
          @endforeach
          <th>Income</th>
        </tr>
      </thead>
      <tbody class="text-center">
        @foreach ($monthly_reports as $month => $monthly_report)
          <tr>
            @php
              $income = 0;
            @endphp
            <td>{{ $month }}</td>
            @foreach ($all_places as $place)
              @php
                // count monthly entries
                $count_entries = 0;
                foreach($monthly_report as $report){
                  if($report->place_id == $place->id){
                    $count_entries += $report->entries;
                  }
                }
                // calculate income in a month
                $income += $place->fee * $count_entries
              @endphp
              <td>{{ $count_entries }}</td>
            @endforeach
            <td>{{ $income }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

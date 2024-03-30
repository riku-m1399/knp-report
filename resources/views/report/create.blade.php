@extends('layouts.app')

@section('title', 'Create Report')
    
@section('content')
    <form action="{{ route('report.store') }}" method="post">
      @csrf
      <div class="container">
        <div class="row justify-content-center">
          <h1 class="text-center my-5">Create Report</h1>
          <div class="col-9">
            <div class="mb-3">
              <label for="promoter_id" class="form-label fw-bold h5">PROMOTER <span class="text-danger">*</span></label>
              <select name="promoter_id" class="form-select" required>
                @if (Auth::user()->role_id == 1)
                    @foreach ($all_users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                @else
                  <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                @endif
              </select>
              {{-- Only admin can change the promoter to the others --}}
            </div>

            <div class="mb-3">
              <label for="place_id" class="form-label fw-bold h5">PLACE <span class="text-danger">*</span></label>
              <select name="place_id" class="form-control" required>
                @foreach ($all_places as $place)
                    <option value="{{ $place->id }}">{{ $place->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="entries" class="form-label fw-bold h5">ENTRIES <span class="text-danger">*</span></label>
              <input type="number" name="entries" class="form-control" value="{{ old('entries', 0) }}" min="0" required>
              {{-- Error message --}}
              @error('entries')
                  <p class="text-danger small">{{ $message }}</p>
              @enderror
            </div>

            <div class="mb-3">
              <label for="date" class="form-label fw-bold h5">DATE <span class="text-danger">*</span></label>
              <input type="date" name="date" class="form-control" required value="<?php echo date('y-m-j')?>">
              {{-- Error message --}}
              @error('date')
                <p class="text-danger small">{{ $message }}</p>
              @enderror
            </div>

            <div class="mb-3">
              <label for="note" class="form-label fw-bold h5">NOTE</label>
              <textarea name="note" cols="30" rows="10" class="form-control" placeholder="If you have anything to say..."></textarea>
              {{-- Error message --}}
              @error('note')
                <p class="text-danger small">{{ $message }}</p>
              @enderror
            </div>

            <button type="submit" class="btn btn-success px-5">Submit</button>
          </div>
        </div>
      </div> 
    </form>
@endsection
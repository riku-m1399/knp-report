@extends('layouts.app')

@section('title', 'Admin: Places')
    
@section('content')
    <div class="container">
      <div class="row justify-content-center gx-5">
        <h1 class="text-center my-5">Setting: Places</h1>
        <div class="col-3">
          <div class="list-group">
            <a href="{{ route('admin.setting.promoters') }}" class="list-group-item"><i class="fa-solid fa-users"></i> Promoters</a>
            <a href="{{ route('admin.setting.places') }}" class="list-group-item active"><i class="fa-solid fa-location-dot"></i> Places</a>
            <a href="{{ route('admin.setting.reports') }}" class="list-group-item"><i class="fa-solid fa-newspaper"></i> Reports</a>
          </div>
        </div>
        <div class="col-9">
          <form action="{{ route('admin.setting.places.store') }}" method="post" class="mb-5">
            @csrf
            <h3>Add Place</h3>
            <div class="row">
              <div class="col">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" autofocus>
                {{-- Error message --}}
                @error('name')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
              </div>
              <div class="col">
                <label for="fee" class="form-label">Fee</label>
                <input type="number" name="fee" class="form-control" value="{{ old('fee') }}" min="0" required>
                {{-- Error message --}}
                @error('fee')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
              </div>
            </div>
            <button type="submit" class="btn btn-info px-5 mt-3">Add</button>
          </form>
          <table class="table table-hover align-middle bg-white border text-secondary">
            <thead class="table-warning">
              <th>Name</th>
              <th>Fee</th>
              <th>Created At</th>
              <th>Last Update</th>
              <th></th>
            </thead>
            <tbody>
              @foreach ($all_places as $place)
                  <tr>
                    <td>{{ $place->name }}</td>
                    <td>{{ $place->fee }}</td>
                    <td>{{ $place->created_at }}</td>
                    <td>{{ $place->updated_at }}</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm" data-bs-toggle="dropdown">
                          <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <div class="dropdown-menu">
                          <button class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#edit-place-{{ $place->id }}">Edit</button>
                          <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-place-{{ $place->id }}">Delete</button>
                        </div>
                      </div>
                      @include('admin.setting.places.modal.edit')
                      @include('admin.setting.places.modal.delete')
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@endsection
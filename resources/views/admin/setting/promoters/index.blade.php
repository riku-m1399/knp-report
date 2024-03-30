@extends('layouts.app')

@section('title', 'Admin: Promoters')
    
@section('content')
    <div class="container">
      <div class="row justify-content-center gx-5">
        <h1 class="text-center my-5">Setting: Promoters</h1>
        <div class="col-3">
          <div class="list-group">
            <a href="{{ route('admin.setting.promoters') }}" class="list-group-item active"><i class="fa-solid fa-users"></i> Promoters</a>
            <a href="{{ route('admin.setting.places') }}" class="list-group-item"><i class="fa-solid fa-location-dot"></i> Places</a>
            <a href="{{ route('admin.setting.reports') }}" class="list-group-item"><i class="fa-solid fa-newspaper"></i> Reports</a>
          </div>
        </div>
        <div class="col-9">
          <table class="table table-hover align-middle bg-white border text-secondary">
            <thead class="table-info">
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th></th>
            </thead>
            <tbody>
              @foreach ($all_promoters as $promoter)
                  <tr>
                    <td>{{ $promoter->name }}</td>
                    <td>{{ $promoter->email }}</td>
                    <td>
                      @if ($promoter->role_id === 1)
                          Admin
                      @else
                          Promoter
                      @endif
                    </td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm" data-bs-toggle="dropdown">
                          <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <div class="dropdown-menu">
                          <button class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#edit-promoter-{{ $promoter->id }}">Edit</button>
                        </div>
                      </div>
                      @include('admin.setting.promoters.modal.edit')
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@endsection
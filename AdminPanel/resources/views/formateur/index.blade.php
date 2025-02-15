@extends('layouts.app')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Formateurs List</h4>
                        <p class="card-description">
                            List of all formateurs
                            <a href="{{ route('formateur.create') }}" class="btn btn-primary btn-sm float-right">
                                <i class="fas fa-plus"></i> Add New Formateur
                            </a>
                        </p>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Picture</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($formateurs as $formateur)
                                        <tr>
                                            <td>
                                                @if($formateur->picture)
                                                    <img src="{{ asset('storage/' . $formateur->picture) }}" 
                                                         class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" 
                                                         alt="Profile Picture">
                                                @else
                                                    <img src="{{ asset('assets/images/default-profile.png') }}" 
                                                         class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" 
                                                         alt="Default Profile Picture">
                                                @endif
                                            </td>
                                            <td>{{ $formateur->name }}</td>
                                            <td>{{ $formateur->email }}</td>
                                            <td>{{ $formateur->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <a href="{{ route('formateur.edit', $formateur->id) }}" 
                                                   class="btn btn-info btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('formateur.destroy', $formateur->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Are you sure you want to delete this formateur?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
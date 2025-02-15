@extends('layouts.app')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Formateur</h4>
                        <p class="card-description">Update formateur information</p>

                        <form method="POST" action="{{ route('formateur.update', $formateur->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $formateur->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $formateur->email) }}" required>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">New Password (leave empty to keep current)</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password">
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="picture">Profile Picture</label>
                                <input type="file" class="form-control-file @error('picture') is-invalid @enderror" 
                                       id="picture" name="picture">
                                @error('picture')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            @if($formateur->picture)
                                <div class="mb-3">
                                    <label>Current Picture:</label>
                                    <img src="{{ asset('storage/' . $formateur->picture) }}" 
                                         class="img-thumbnail" style="max-width: 150px;" alt="Current Profile Picture">
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary">Update Formateur</button>
                            <a href="{{ route('formateur.index') }}" class="btn btn-light">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
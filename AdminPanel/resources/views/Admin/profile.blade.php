@extends('layouts.app')



@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="content-wrapper">
            <div class="row">
                <!-- Admin Information -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Admin Information</h4>
                            <p><strong>Name:</strong> {{ $LoggedAdminInfo->name }}</p>
                            <p><strong>Email:</strong> {{ $LoggedAdminInfo->email }}</p>
                            <p><strong>Bio:</strong> {{ $LoggedAdminInfo->bio }}</p>
                            <p><strong>Picture:</strong></p>

                            @if ($LoggedAdminInfo->picture)
                            <div style="max-width: 300px; margin: auto;">
                                <!-- Adjust max-width and margin as needed -->
                                <img src="{{ asset('storage/' . $LoggedAdminInfo->picture) }}"
                                    class="img-fluid rounded" alt="Admin Picture"
                                    style="max-width: 50%; height: auto;">
                            </div>
                            @else
                            <p>Admin Picture not available</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Profile Update Form -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Update Profile</h4>
                            <form action="{{ route('admin.profile.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ $LoggedAdminInfo->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input disabled type="email" id="email" name="email"
                                        class="form-control" value="{{ $LoggedAdminInfo->email }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="bio">Bio</label>
                                    <textarea id="bio" name="bio"
                                        class="form-control">{{ $LoggedAdminInfo->bio }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="picture">Profile Picture</label>
                                    <input type="file" id="picture" name="picture"
                                        class="form-control-file">
                                </div>
                                <!-- Add more fields (image upload, etc.) as needed -->

                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>


@endsection
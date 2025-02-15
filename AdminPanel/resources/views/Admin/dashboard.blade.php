@extends('layouts.app')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">
                                Welcome
                                @if (session('LoggedAdminInfo'))
                                    @php
                                        $admin = session('LoggedAdminInfo');
                                        if (is_object($admin)) {
                                            $adminName = $admin->name ?? 'Admin';
                                        } elseif (is_array($admin)) {
                                            $adminName = $admin['name'] ?? 'Admin';
                                        } else {
                                            $adminName = 'Admin';
                                        }
                                    @endphp
                                    {{ $adminName }}
                                @else
                                    <p>Access denied. Please <a href="{{ route('admin.login') }}">login</a> to view this page.</p>
                                @endif
                            </h3>
                            <h6 class="font-weight-normal mb-0">All systems are running smoothly! You have <span class="text-primary">3 unread alerts!</span></h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card tale-bg">
                        <div class="card-people mt-auto">
                            <img src="/images/dashboard/people.svg" alt="people">
                            <div class="weather-info">
                                <div class="d-flex">
                                    <div>
                                        <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i>31<sup>C</sup></h2>
                                    </div>
                                    <div class="ml-2">
                                        <h4 class="location font-weight-normal">Bangalore</h4>
                                        <h6 class="font-weight-normal">morocco</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Rows -->
                <div class="col-md-6 grid-margin transparent">
    <div class="row">
        <div class="col-md-6 mb-4 stretch-card transparent">
            <div class="card card-tale">
                <div class="card-body">
                    <p class="mb-4">Total formateurs</p>
                    <p class="fs-30 fs-md-40 mb-2">{{ $totalFormateurs ?? 0 }}</p>
                   
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4 stretch-card transparent">
            <div class="card card-dark-blue">
                <div class="card-body">
                    <p class="mb-4">Total stagiaires</p>
                    <p class="fs-30 fs-md-40 mb-2">{{ $totalStagiaires ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
            <div class="card card-light-blue">
                <div class="card-body">
                    <p class="mb-4">Number of Users</p>
                    <p class="fs-30 fs-md-40 mb-2">{{ $totalUsers ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 stretch-card transparent">
            <div class="card card-light-danger">
                <div class="card-body">
                    <p class="mb-4">Number of Groups</p>
                    <p class="fs-30 fs-md-40 mb-2">{{ $totalGroups ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Groups and Their Stagiaires</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Group Name</th>
                                    <th>Number of Stagiaires</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groupes as $groupe)
                                <tr>
                                    <td>{{ $groupe->name }}</td>
                                    <td>{{ $groupe->stagiaires_count }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

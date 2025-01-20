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
                                            $adminPicture = $admin->picture ?? null;
                                        } elseif (is_array($admin)) {
                                            $adminName = $admin['name'] ?? 'Admin';
                                            $adminPicture = $admin['picture'] ?? null;
                                        } else {
                                            $adminName = 'Admin';
                                            $adminPicture = null;
                                        }
                                    @endphp
                                    {{ $adminName }}
                                @else
                                    <p>Access denied. Please <a href="{{ route('admin.login') }}">login</a> to view this page.</p>
                                @endif
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Dashboard Statistics</h4>
                            <!-- Chart Container -->
                            <div id="chart">
                                {!! $chart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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

    <!-- Add these scripts at the bottom of your view -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    {{ $chart->script() }}
@endsection

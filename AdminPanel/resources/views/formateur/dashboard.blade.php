@extends('layouts.app')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        @if(config('app.debug'))
            <div class="alert alert-info">
                <p>Debug Info:</p>
                <ul>
                    <li>Formateur ID: {{ $formateur->id }}</li>
                    <li>Name: {{ $formateur->name }}</li>
                    <li>Raw Counts:</li>
                    <li>- Groups: {{ $totalGroups ?? 0 }}</li>
                    <li>- Students: {{ $totalStudents ?? 0 }}</li>
                    <li>- Courses: {{ $totalCourses ?? 0 }}</li>
                    <li>- Exams: {{ $totalExams ?? 0 }}</li>
                    <li>Groups IDs: {{ implode(', ', $formateur->groupes()->pluck('id')->toArray()) }}</li>
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">
                            Welcome
                            @if (Auth::guard('formateur')->user())
                                {{ Auth::guard('formateur')->user()->name }}
                            @else
                                <p>Access denied. Please <a href="{{ route('login') }}">login</a> to view this page.</p>
                            @endif
                        </h3>
                        <h6 class="font-weight-normal mb-0">All systems are running smoothly!</h6>
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
                                <p class="mb-4">My Total Courses</p>
                                <p class="fs-30 fs-md-40 mb-2">{{ $totalCourses ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-4">My Total Exams</p>
                                <p class="fs-30 fs-md-40 mb-2">{{ $totalExams ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-4">My Students</p>
                                <p class="fs-30 fs-md-40 mb-2">{{ $totalStudents ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 stretch-card transparent">
                        <div class="card card-light-danger">
                            <div class="card-body">
                                <p class="mb-4">My Groups</p>
                                <p class="fs-30 fs-md-40 mb-2">{{ $totalGroups ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Recent Activity</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Activity</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentActivities ?? [] as $activity)
                                    <tr>
                                        <td>{{ $activity->description }}</td>
                                        <td>{{ $activity->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <label class="badge badge-{{ $activity->status_color }}">
                                                {{ $activity->status }}
                                            </label>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No recent activities</td>
                                    </tr>
                                    @endforelse
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
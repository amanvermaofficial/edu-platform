@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <h4>Student Details</h4>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="row justify-content-center">

                <!-- Profile Card -->
                <div class="col-lg-4 col-md-5">
                    <div class="card text-center">
                        <div class="card-body">

                            <img
                                src="{{ $student->profile_picture 
                                    ? asset('storage/'.$student->profile_picture) 
                                    : asset('admin-assets/img/avatar.png') }}"
                                class="rounded-circle mb-3"
                                width="120"
                                height="120"
                            >

                            <h5>{{ $student->name ?? 'N/A' }}</h5>
                            <p class="text-muted">{{ $student->email ?? 'N/A' }}</p>

                            <span class="badge {{ $student->completed_profile ? 'bg-success' : 'bg-warning' }}">
                                {{ $student->completed_profile ? 'Profile Completed' : 'Incomplete Profile' }}
                            </span>

                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="col-lg-8 col-md-7">
                    <div class="card">
                        <div class="card-body">

                            <h5 class="mb-3">Basic Information</h5>

                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Phone</th>
                                    <td>{{ $student->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $student->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>{{ ucfirst($student->gender) ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td>{{ $student->state ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Course</th>
                                    <td>{{ $student->course->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Trade</th>
                                    <td>{{ $student->trade->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile Verified</th>
                                    <td>
                                        @if($student->mobile_verified_at)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Registered On</th>
                                    <td>{{ $student->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

</div>
@endsection

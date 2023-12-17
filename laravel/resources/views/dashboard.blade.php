@extends('layouts.app')
@section('title', 'Dashboard')
@section('velnesActive', 'active')
@section('content')
    <div class="homepage">
        <div class="leftDiv">
            <div class="welcome">
                <div class="title">
                    <h1>Welcome to Velnes!</h1>
                    <p>From now on we will make your everyday work life easier, so you cam focus on what you do best! Start setting up your business in Velnes and discover all features. Prefer talking to a human?</p>
                </div>
                <div class="actions">
                    <a href="" class="start-product-tour">Start the product tour</a>
                    <a href="" class="schedule-free-demo">Schedule a free demo</a>
                </div>
            </div>
            <div class="schedule-and-activity">
                <div class="nav">
                    <div class="options">
                        <button class="scheduleButton active">Schedule</button>
                        <button class="activityButton">Activity</button>
                    </div>
                    <select name="employeesList" id="employeesList" class="select">
                        <option value="0" selected><img src="{{ asset('svg/profile-icon.svg') }}" alt="">All Employees</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}"><img src="{{ asset('svg/profile-icon.svg') }}" alt="">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="schedule" id="scheduleDiv">
                    @if($appointments->isNotEmpty())
                        @foreach($appointments as $appointment)
                            <div class="appointment">
                                <div class="time">
                                    <p class="start-time">{{ \Carbon\Carbon::parse($appointment->date_time)->format('H:i') }}</p>
                                    <p class="end-time">{{ \Carbon\Carbon::parse($appointment->date_time)->addMinutes($appointment->duration)->format('H:i') }}</p>
                                </div>
                                <div class="profile-picture">
                                    <div class="circle">
                                        @if($appointment->employee->photo_url)
                                            <img src="{{ asset('storage/' . $appointment->employee->photo_url) }}" alt="Profile Picture">
                                        @else
                                            <div class="circle">
                                                <p>{{ substr($appointment->employee->name, 0, 1) }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="name-and-service">
                                    <p class="name">{{ $appointment->employee->name }}</p>
                                    <p class="service">{{ $appointment->service->name }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="no-appointments">No appointments for today</p>
                    @endif
                </div>
                <div class="activity"></div>
            </div>
        </div>
        <div class="rightDiv">
            <div class="quick-start">
                <div class="title">
                    <h3>Quick start</h3>
                </div>
                <div class="actions">
                    <a href="">Appointment</a>
                    <a href="">Invoice</a>
                    <a href="">New customer</a>
                </div>
            </div>
            <div class="notes">
                <div class="title">
                    <h3>Notes</h3>
                    <button><span>+</span> Create note</button>
                </div>
                <div class="notes-content">
                    <div class="note">
                        <div class="profile-picture">
                            <div class="circle">
                                <p>I</p>
                            </div>
                        </div>
                        <div class="note-content">
                            <p class="name">Ivan</p>
                            <p>Prepare a newsletter for clients</p>
                            <p class="date">16.06.2023</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="working-today">
                <div class="title">
                    <h3>Who's working today</h3>
                </div>
                <div class="employees">
                    @foreach($workingToday as $row)
                        <div class="employee">
                            <div class="employee-info">
                                <div class="profile-picture">
                                    <div class="circle">
                                        @if($row['employee']->photo_url)
                                            <img src="{{ asset('storage/' . $row['employee']->photo_url) }}" alt="Profile Picture">
                                        @else
                                            <div class="circle">
                                                <p>{{ substr($row['employee']->name, 0, 1) }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="name-and-appointments">
                                    <p class="name">{{ $row['employee']->name }}</p>
                                    <p class="appointments">{{ $row['totalAppointments'] }} appointments</p>
                                </div>
                            </div>
                            <div class="working-hours">
                                <p>{{ $row['workingHoursStart'] }} - {{ $row['workingHoursEnd'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
    </div>
@endsection
@section('scripts')
    @vite(['resources/js/homepage.js'])
@endsection
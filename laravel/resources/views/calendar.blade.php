@extends('layouts.app')
@section('title', 'Calendar')
@section('page-name')
    <h1 id="calendarTitle">Calendar <button id="calendar-settings"><img src="{{ asset('svg/settings-grey.svg') }}" alt=""></button></h1>
    <div class="window calendar-settings mini">
        <a href=""><img src="{{ asset('svg/calendar-clock.svg') }}" alt="">Working hours</a>
        <a href=""><img src="{{ asset('svg/calendar-calendar.svg') }}" alt="">Calendar settings</a>
        <a href=""><img src="{{ asset('svg/calendar-web.svg') }}" alt="">Online booking</a>
        <a href=""><img src="{{ asset('svg/calendar-employees.svg') }}" alt="">Manage employees</a>
    </div>
@endsection
@section('calendarActive', 'active')
@section('content')
    <div class="calendar">
        <div class="calendar-options">
            <div class="alert alert-success"></div>
            <div class="todayButton"><p>Today</p></div>
            <div class="date">
                <button class="previousDayBtn"><img src="{{ asset('svg/arrow-left.svg') }}" alt=""></button>
                <input type="date" name="datePicker" id="datePicker" value="{{ now()->format('Y-m-d') }}">
                <button class="nextDayBtn"><img src="{{ asset('svg/arrow-right.svg') }}" alt=""></button>
            </div>
            <div class="range">
                <select name="range" id="range">
                    <option value="day">Day</option>
                    <option value="week" selected>Week</option>
                </select>
            </div>
            <div class="employees">
                <select name="employees" id="employees">
                    <option value="0" selected>All employees</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="resources">
                <select name="resources" id="resources">
                    <option value="0" selected>All resources</option>
                </select>
            </div>
            <div class="create-new">
                <button id="eventCreateButton">Create new +</button>
            </div>
        </div>

        <div class="calendar-table">
            <table>
                <thead>
                    <tr>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="modal" id="eventCreateModal">
            <div class="event-create bg-grey">
            <div class="window">
                <div class="navigation header">
                    <div class="options">
                        <button id="btnAppointment" class="active">Appointment</button>
                        <button id="btnAbsence">Absence</button>
                        <button id="btnChore">Chore</button>
                        <button id="btnNote">Note</button>
                    </div>
                    <button id="closeEventCreateModalButton"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                </div>
                <div class="create-appointment" id="createAppointment">
                    <form action="" id="appointment-store">
                        <div class="form">
                            <div class="service section">
                                <div class="form-group">
                                    <label for="appointment-service">Service</label>
                                    <select name="service" id="appointment-service" class="form-control">
                                        <option value="0">Services</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" data-price="{{ $service->price }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-message" id="appointment-service-error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="appointment-duration">Duration</label>
                                    <input name="duration" id="appointment-duration" class="form-control">
                                    <span class="error-message" id="appointment-duration-error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="appointment-employee">Employee 1</label>
                                    <select name="employee" id="appointment-employee" class="form-control">
                                        <option value="0">Employees</option>
                                    </select>
                                    <span class="error-message" id="appointment-employee-error"></span>
                                </div>
                            </div>
                            <a href="" id="addServiceBtn">+ Add service</a>
                            <div class="room section">
                                <div class="form-group">
                                    <label for="appointment-room">Room</label>
                                    <select name="room" id="appointment-room" class="form-control">
                                        <option value="0">Select room</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-message" id="appointment-room-error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="appointment-tool1">Tool 1</label>
                                    <select name="tool1" id="appointment-tool1" class="form-control">
                                        <option value="0">Select tool</option>
                                        @foreach($tools as $tool)
                                            <option value="{{ $tool->id }}">{{ $tool->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-message" id="appointment-tool-error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="appointment-tool2">Tool 2</label>
                                    <select name="tool2" id="appointment-tool2" class="form-control">
                                    <option value="0">Select tool</option>
                                        @foreach($tools as $tool)
                                            <option value="{{ $tool->id }}">{{ $tool->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-message" id="appointment-tool2-error"></span>
                                </div>
                            </div>
                            <a href="">+ Add resource</a>
                            <div class="date section">
                                <div class="form-group">
                                    <label for="appointment-date">Date and time</label>
                                    <div class="inputs">
                                        <div>
                                        <input type="date" name="date" id="appointment-date" class="form-control">
                                        </input>
                                        <span class="error-message" id="appointment-date-error"></span>
                                        </div>
                                       <div>
                                       <input type="time" id="appointment-time" name="time" min="08:00" max="15:15" step="900" class="form-control">
                                        <span class="error-message" id="appointment-time-error"></span>
                                       </div>
                                        <button class="form-control" id="findAvailabilitiesButton">Find availabilites</button>
                                    </div>
                                </div>
                                <div class="form-group repeat">
                                    <input type="checkbox" name="repeat-checkbox" id="appointment-repeat-checkbox">
                                    <label for="appointment-repeat-checkbox">Repeat appointment</label>
                                </div>
                            </div>
                            <div class="buffer-time section">
                                <div class="form-group">
                                    <input type="checkbox" id="appointment-buffer-time" name="buffer-time">
                                    <label for="appointment-buffer-time">Add buffer time</label>
                                </div>
                            </div>
                            <div class="note section">
                                <div class="form-group">
                                    <label for="appointment-note">Note</label>
                                    <textarea name="note" id="appointment-note" cols="30" rows="3" placeholder="Write your note here" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="save">
                            <div class="customer">
                                <div class="form-group">
                                    <label for="appointment-customer">Customer</label>
                                    <select name="customer" id="appointment-customer" class="form-control">
                                        <option value="0">Select customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-message" id="appointment-customer-error"></span>
                                </div>
                                <a href="">+ New customer</a>
                            </div>
                            <div class="save-appointment">
                                <div class="form-group selectedDate">
                                    <label for="">Date and time</label>
                                    <p>22.08.2023, 11:00</p>
                                </div>
                                <div class="form-group totalPrice">
                                    <label for="">Price</label>
                                    <p>$0.00</p>
                                </div>
                                <button type="submit">Save appointment</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="create-absence" id="createAbsence">
                    <form action="">
                        <div class="inner-window">
                            <div class="description">
                                <div class="form-group">
                                    <label for="absence-description">Description*</label>
                                    <textarea name="description" id="absence-description" cols="30" rows="3" placeholder="Enter description" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="date-and-time">
                                <div class="inputs">
                                    <div class="form-group">
                                        <label for="absence-date">Date and time</label>
                                        <input type="date" id="absence-date" name="date" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="absence-from-time">From</label>
                                        <input type="time" min="08:00" max="15:15" id="absence-from-time" name="from-time" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="absence-to-time">To</label>
                                        <input type="date" min="08:00" max="15:15" id="absence-to-time" name="to-time" class="form-control">
                                    </div>
                                </div>
                                <div class="checkboxes">
                                    <div class="form-group">
                                        <input type="checkbox" name="all-day" id="absence-all-day">
                                        <label for="absence-all-day">All day</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" name="repeat" id="absence-repeat">
                                        <label for="absence-repeat">Repeat absence</label>
                                    </div>
                                </div>
                            </div>
                            <div class="applies-to">
                                <p>Applies to</p>
                                <div class="radios">
                                    <div class="form-group">
                                        <input type="radio" name="applies-to" id="absence-applies-to-company" value="entire-company">
                                        <label for="absence-applies-to-company">Entire company</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" name="applies-to" id="absence-applies-to-employee" value="employee">
                                        <label for="absence-applies-to-employee">Employee</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="create-chore" id="createChore">
                    <form action="">
                        <div class="inner-window">
                            <div class="description">
                                <div class="form-group">
                                    <label for="chore-description">Description*</label>
                                    <textarea name="description" id="chore-description" cols="30" rows="3" placeholder="Enter description" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="date-and-time">
                                <div class="inputs">
                                    <div class="form-group">
                                        <label for="chore-date">Date and time</label>
                                        <input type="date" id="chore-date" name="date" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="chore-from-time">From</label>
                                        <input type="time" min="08:00" max="15:15" id="chore-from-time" name="from-time" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="chore-to-time">To</label>
                                        <input type="date" min="08:00" max="15:15" id="chore-to-time" name="to-time" class="form-control">
                                    </div>
                                </div>
                                <div class="checkboxes">
                                    <div class="form-group">
                                        <input type="checkbox" name="all-day" id="chore-all-day">
                                        <label for="chore-all-day">All day</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" name="repeat" id="chore-repeat">
                                        <label for="chore-repeat">Repeat chore</label>
                                    </div>
                                </div>
                            </div>
                            <div class="applies-to">
                                <p>Applies to</p>
                                <div class="radios">
                                    <div class="form-group">
                                        <input type="radio" name="applies-to" id="chore-applies-to-company" value="entire-company">
                                        <label for="chore-applies-to-company">Entire company</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" name="applies-to" id="chore-applies-to-employee" value="employee">
                                        <label for="chore-applies-to-employee">Employee</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="create-note" id="createNote">
                    <form action="">
                        <div class="inner-window">
                            <div class="description">
                                <div class="form-group">
                                    <label for="note-description">Description*</label>
                                    <textarea name="description" id="note-description" cols="30" rows="3" placeholder="Enter description" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="date-and-time">
                                <div class="inputs">
                                    <div class="form-group">
                                        <label for="note-date">Date</label>
                                        <input type="date" id="note-date" name="date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="applies-to">
                                <p>Applies to</p>
                                <div class="radios">
                                    <div class="form-group">
                                        <input type="radio" name="applies-to" id="note-applies-to-company" value="entire-company">
                                        <label for="note-applies-to-company">Entire company</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" name="applies-to" id="note-applies-to-employee" value="employee">
                                        <label for="note-applies-to-employee">Employee</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="appointmentDetailsModal">
        <div class="window">
            <div class="header">
                <h2>Appointment details</h2>
                <button class="closeModal" id="closeAppointmentDetailsModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
            </div>
            <div class="body">
                <div class="main-info">
                    <div class="date-time-price">
                        <div class="group">
                            <label for="">date</label>
                            <p class="date"></p>
                        </div>
                        <div class="group">
                            <label for="">time</label>
                            <p class="time"></p>
                        </div>
                        <div class="group">
                            <label for="">price</label>
                            <p class="price"></p>
                        </div>
                    </div>
                    <div class="service">
                        <table id="appointment-details-table">
                            <thead>
                                <tr>
                                    <th>service</th>
                                    <th>duration</th>
                                    <th>employee</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="warning">
                        <p>Warning</p>
                        <div></div>
                    </div>
                </div>
                <div class="appointment-actions">
                    <div class="customer">
                        <label for="">Customer</label>
                        <div class="inner-customer">
                        <div class="profile-picture">
                            <div class="circle">
                                <p></p>
                            </div>
                        </div>
                        <div class="info">
                            <p class="customer-name"></p>
                            <p class="customer-email"></p>
                            <p class="customer-phone"></p>
                        </div>
                        </div>
                    </div>
                    <div class="main-actions">
                        <button><img src="{{ asset('svg/form-grey.svg') }}" alt="">Forms</button>
                        <button><img src="{{ asset('svg/no-show.svg') }}" alt="">Mark as no-show</button>
                        <button><img src="{{ asset('svg/copy.svg') }}" alt="">Copy</button>
                        <button id="deleteAppointmentButton"><img src="{{ asset('svg/trash-grey.svg') }}" alt="">Delete</button>
                    </div>
                    <div class="additional-actions">
                        <button id="editAppointmentButton">Edit</button>
                        <button id="checkout">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="editAppointmentModal">
        <div class="window">
            <div class="header">
                <h2>Edit appointment</h2>
                <button class="closeModal" id="closeEditAppointmentModalButton"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
            </div>
            <div class="update-appointment">
                <form action="" id="appointment-update">
                    <div class="form">
                        <div class="service section">
                            <div class="form-group">
                                <label for="update-appointment-service">Service</label>
                                <select name="service" id="update-appointment-service" class="form-control">
                                    <option value="0">Services</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" data-price="{{ $service->price }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error-message" id="update-appointment-service-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="update-appointment-duration">Duration</label>
                                <input name="duration" id="update-appointment-duration" class="form-control">
                                <span class="error-message" id="update-appointment-duration-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="update-appointment-employee">Employee 1</label>
                                <select name="employee" id="update-appointment-employee" class="form-control">
                                    <option value="0">Employees</option>
                                </select>
                                <span class="error-message" id="update-appointment-employee-error"></span>
                            </div>
                        </div>
                        <a href="" id="addServiceBtn">+ Add service</a>
                        <div class="room section">
                            <div class="form-group">
                                <label for="update-appointment-room">Room</label>
                                <select name="room" id="update-appointment-room" class="form-control">
                                    <option value="0">Select room</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error-message" id="update-appointment-room-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="update-appointment-tool1">Tool 1</label>
                                <select name="tool1" id="update-appointment-tool1" class="form-control">
                                    <option value="0">Select tool</option>
                                    @foreach($tools as $tool)
                                        <option value="{{ $tool->id }}">{{ $tool->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error-message" id="update-appointment-tool-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="update-appointment-tool2">Tool 2</label>
                                <select name="tool2" id="update-appointment-tool2" class="form-control">
                                <option value="0">Select tool</option>
                                    @foreach($tools as $tool)
                                        <option value="{{ $tool->id }}">{{ $tool->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error-message" id="update-appointment-tool2-error"></span>
                            </div>
                        </div>
                        <a href="">+ Add resource</a>
                        <div class="date section">
                            <div class="form-group">
                                <label for="update-appointment-date">Date and time</label>
                                <div class="inputs">
                                    <div>
                                    <input type="date" name="date" id="update-appointment-date" class="form-control">
                                    </input>
                                    <span class="error-message" id="update-appointment-date-error"></span>
                                    </div>
                                    <div>
                                    <input type="time" id="update-appointment-time" name="time" min="08:00" max="15:15" step="900" class="form-control">
                                    <span class="error-message" id="update-appointment-time-error"></span>
                                    </div>
                                    <button class="form-control">Find availabilites</button>
                                </div>
                            </div>
                            <div class="form-group repeat">
                                <input type="checkbox" name="repeat-checkbox" id="appointment-repeat-checkbox">
                                <label for="appointment-repeat-checkbox">Repeat appointment</label>
                            </div>
                        </div>
                        <div class="buffer-time section">
                            <div class="form-group">
                                <input type="checkbox" id="appointment-buffer-time" name="buffer-time">
                                <label for="appointment-buffer-time">Add buffer time</label>
                            </div>
                        </div>
                        <div class="note section">
                            <div class="form-group">
                                <label for="appointment-note">Note</label>
                                <textarea name="note" id="appointment-note" cols="30" rows="3" placeholder="Write your note here" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="save">
                        <div class="customer">
                            <div class="form-group">
                                <label for="update-appointment-customer">Customer</label>
                                <select name="customer" id="update-appointment-customer" class="form-control">
                                    <option value="0">Select customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                    @endforeach
                                </select>
                                <span class="error-message" id="update-appointment-customer-error"></span>
                            </div>
                            <a href="">+ New customer</a>
                        </div>
                        <div class="save-appointment">
                            <div class="form-group selectedDate">
                                <label for="">Date and time</label>
                                <p>22.08.2023, 11:00</p>
                            </div>
                            <div class="form-group totalPrice">
                                <label for="">Price</label>
                                <p>$0.00</p>
                            </div>
                            <button type="submit">Save appointment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="availabilityModal">
        <div class="window">
            <div class="header">
                <h2>Available Time Slots</h2>
                <span class="close" id="closeAvailabilityModal">&times;</span>
            </div>
            <div class="modal-content">
                <div id="calendarContainer">
                    <input type="text" id="datepicker" placeholder="Select a date">
                </div>
                <div id="timeSlotsContainer"></div>
            </div>
        </div>
    </div>

    </div>
@endsection
@section('scripts')
    @vite(['resources/js/calendar.js'])
@endsection
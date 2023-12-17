@extends('layouts.app')
@section('title', 'Customers')
@section('page-name')
    <div class="customer-heading">
        <h1 id="calendarTitle">{{ $customer->first_name }}  {{ $customer->last_name }}</h1>
    </div>
@endsection
@section('customersActive', 'active')
@section('content')
    <div class="customer">
        <div class="customer-nav">
            <button id="customerOverviewButton" class="active">Overview</button>
            <button id="customerAppointmentsButton">Appointments</button>
            <button id="customerInvoicesButton">Invoices</button>
            <button id="customerFormsButton">Forms</button>
            <button id="customerLoyaltyButton">Loyalty</button>
            <button id="customerPrepaidButton">Prepaid</button>
            <button id="customerFeedbackButton">Feedback</button>
        </div>
        <div class="customer-overview">
            <div class="left-div">
                <div class="quick-actions">
                    <button id="newAppointmentButton"><img src="{{ asset('svg/calendar-grey.svg') }}" alt="">New appointment</button>
                    <button><img src="{{ asset('svg/cart-grey.svg') }}" alt="">New invoice</button>
                    <button><img src="{{ asset('svg/form-grey.svg') }}" alt="">Fill in a form</button>
                    <button><img src="{{ asset('svg/trash-grey.svg') }}" alt="">Delete</button>
                </div>
                <div class="details">
                    <div class="header">
                        <p>Details</p>
                    </div>
                    <div class="body">
                        <div class="group">
                            <p class="label">Email</p>
                            <p>{{ $customer->email }}</p>
                        </div>
                        <div class="group">
                            <p class="label">Phone number</p>
                            <p>{{ $customer->phone }}</p>
                        </div>
                        <div class="group">
                            <p class="label">Date of birth</p>
                            <p>{{ $customer->date_of_birth }}</p>
                        </div>
                        <div class="group">
                            <p class="label">Gender</p>
                            <p>{{ $customer->gender }}</p>
                        </div>
                        <div class="group">
                            <p class="label">Date created</p>
                            <p>{{ $customer->created_at }}</p>
                        </div>
                    </div>
                </div>
                <div class="notification-settings">
                    <div class="header">
                        <p>Notification settings</p>
                    </div>
                    <div class="body">
                        <div class="group">
                            <p>Email remainder</p>
                            <label class="switch">
                                <input type="checkbox" id="toggleButton">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="group">
                            <p>SMS appointment reminder</p>
                            <label class="switch">
                                <input type="checkbox" id="toggleButton">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="group">
                            <p>Newsletters</p>
                            <label class="switch">
                                <input type="checkbox" id="toggleButton">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="group">
                            <p>Birthday wishes</p>
                            <label class="switch">
                                <input type="checkbox" id="toggleButton">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="group">
                            <p>Feedback request</p>
                            <label class="switch">
                                <input type="checkbox" id="toggleButton">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="group">
                            <p>Reebook reminder</p>
                            <label class="switch">
                                <input type="checkbox" id="toggleButton">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-div">
                <div class="stats">
                    <div class="group">
                        <p class="number">{{ $customer->appointments->count() }}</p>
                        <p>Appointments</p>
                    </div>
                    <div class="group">
                        <p class="number">1</p>
                        <p>invoices</p>
                    </div>
                    <div class="group">
                        <p class="number">1000</p>
                        <p>Loyalty points</p>
                    </div>
                    <div class="group">
                        <p class="number">1</p>
                        <p>Cancellations</p>
                    </div>
                    <div class="group">
                        <p class="number">1</p>
                        <p>No shows</p>
                    </div>
                    <div class="group">
                        <p class="number">6</p>
                        <p>Total spent</p>
                    </div>
                </div>
                <div class="right-inner-div">
                    <div class="history">
                        <div class="header">
                            <p>History</p>
                        </div>
                        <div class="body">
                            <div class="group">
                                <div class="photo-content">
                                    <div class="photo-div">
                                        <div class="circle"><p>S</p></div>
                                    </div>
                                    <div class="content">
                                        <p class="label">Feednacl request sent to</p>
                                        <p>k.stojanovska@velnes.mk</p>
                                    </div>
                                </div>
                                <div class="date-time">
                                    <p>16.06.2023, 10:38</p>
                                </div>
                            </div>
                            <div class="group">
                                <div class="photo-content">
                                    <div class="photo-div">
                                        <div class="circle"><p>S</p></div>
                                    </div>
                                    <div class="content">
                                        <p class="label">Feednacl request sent to</p>
                                        <p>k.stojanovska@velnes.mk</p>
                                    </div>
                                </div>
                                <div class="date-time">
                                    <p>16.06.2023, 10:38</p>
                                </div>
                            </div>
                            <div class="group">
                                <div class="photo-content">
                                    <div class="photo-div">
                                        <div class="circle"><p>S</p></div>
                                    </div>
                                    <div class="content">
                                        <p class="label">Feednacl request sent to</p>
                                        <p>k.stojanovska@velnes.mk</p>
                                    </div>
                                </div>
                                <div class="date-time">
                                    <p>16.06.2023, 10:38</p>
                                </div>
                            </div>
                            <div class="group">
                                <div class="photo-content">
                                    <div class="photo-div">
                                        <div class="circle"><p>S</p></div>
                                    </div>
                                    <div class="content">
                                        <p class="label">Feednacl request sent to</p>
                                        <p>k.stojanovska@velnes.mk</p>
                                    </div>
                                </div>
                                <div class="date-time">
                                    <p>16.06.2023, 10:38</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="notes">
                        <div class="header">
                            <p>Notes</p>
                            <button><span>+</span> Create note</button>
                        </div>
                        <div class="body">
                            <div class="group">
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
                </div>
            </div>
        </div>
        <div class="customer-appointments">
            <div class="actions">
                <div class="filters">
                    <select name="state" id="state" class="form-control">
                        <option value="0">State</option>
                    </select>
                    <select name="employees" id="employees" class="form-control">
                        <option value="0">All employees</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button id="eventCreateButton">New appointment</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Date and time</th>
                        <th>services</th>
                        <th>employees</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customer->appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->date_time }}</td>
                            <td>{{ $appointment->service->name }}</td>
                            <td>{{ $appointment->employee->name }}</td>
                            <td><div class="status">Future</div></td>
                            <td>
                                <button class="appointmentCrudModalButton"><img src="{{ asset('svg/three-dots.svg') }}" alt=""></button>
                                <div class="crudModal appointmentCrudModal">
                                    <button class="editAppointmentButton" data-id="{{ $appointment->id }}">
                                        <img src="{{ asset('svg/pen.svg') }}" alt="">
                                        Edit
                                    </button>
                                    <button class="deleteAppointmentButton" data-id="{{ $appointment->id }}">
                                        <img src="{{ asset('svg/trash-grey.svg') }}" alt="">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="customer-feedback">
            <div class="left-div">
                <div class="filters">
                    <select name="reaction" id="reaction" class="form-control">
                        <option value="0">Reaction</option>
                    </select>
                    <select name="status" id="status" class="form-control">
                        <option value="0">Status</option>
                    </select>
                </div>
                <div class="feedback-messages">
                    <div class="feedback active" id="feedback-1">
                        <div class="reaction">
                            <div class="circle">
                                <img src="{{ asset('svg/happy.svg') }}" alt="">
                            </div>
                        </div>
                        <div>
                            <p class="customer">Katerina Stojanovska</p>
                            <p class="date-time">18.03.2023, 9:30</p>
                        </div>
                    </div>
                    <div class="feedback" id="feedback-2">
                        <div class="reaction">
                            <div class="circle">
                                <img src="{{ asset('svg/sad.svg') }}" alt="">
                            </div>
                        </div>
                        <div>
                            <p class="customer">Katerina Stojanovska</p>
                            <p class="date-time">18.03.2023, 9:30</p>
                        </div>
                    </div>
                    <div class="feedback" id="feedback-3">
                        <div class="reaction">
                            <div class="circle">
                                <img src="{{ asset('svg/sad.svg') }}" alt="">
                            </div>
                        </div>
                        <div>
                            <p class="customer">Katerina Stojanovska</p>
                            <p class="date-time">18.03.2023, 9:30</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-div">
                <div id="feedback-1-full" class="feedback-full">
                    <div class="actions">
                        <div class="delete">
                            <img src="{{ asset('svg/trash-grey.svg') }}" alt="">
                        </div>
                        <button>Publish a response</button>
                    </div>
                    <div class="feedback-info">
                        <div class="header">
                            <div class="profile-picture">
                                <div class="circle">
                                    <p>K</p>
                                </div>
                            </div>
                            <p class="customer">Katerina Stojanovska</p>
                            <p class="date">16.08.2022</p>
                        </div>
                        <div class="body">
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestias alias maiores aspernatur voluptatum eum provident obcaecati. Omnis, iusto, quaerat ratione quod at corporis illo cum, quas dolores reprehenderit rerum culpa.</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum tempora quibusdam sequi, explicabo adipisci fuga laboriosam debitis tempore ducimus praesentium?</p>
                        </div>
                    </div>
                    <div class="appointment-details">
                        <div class="header">
                            <h3>Appointment details</h3>
                        </div>
                        <div class="body">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Date and time</th>
                                        <th>Services</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Maria</td>
                                        <td>18.03.2023, 9:30</td>
                                        <td>Gel lack French</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="footer">
                                <button>View appointment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="eventCreateModal">
        <div class="window">
        <div class="header">
            <h2>Create appointment</h2>
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
                                <option value="{{ $customer->id }}" selected>{{ $customer->first_name }} {{ $customer->last_name }}</option>
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
                                    <option value="{{ $customer->id }}">{{ $customer-> first_name }} {{ $customer->last_name }}</option>
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
    </div>

@endsection
@section('scripts')
    @vite(['resources/js/customer.js', 'resources/js/calendar.js'])
@endsection
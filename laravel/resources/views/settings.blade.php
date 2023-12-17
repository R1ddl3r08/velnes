@extends('layouts.app')
@section('title', 'Settings')
@section('page-name')
    <h1 id="calendarTitle">Settings</h1>
@endsection
@section('settingsActive', 'active')
@section('content')
    <div class="settings-menu">
        <div class="general-settings">
            <div class="header">
                <p>General</p>
            </div>
            <div class="menu">
                <button id="general-settings-button" data-target="general-settings">General settings</button>
                <button id="user-accounts-button" data-target="user-accounts">User accounts</button>
                <button id="activity-logs-button" data-target="activity-logs">Activity logs</button>
            </div>
        </div>
        <div class="company-settings">
            <div class="header">
                <p>Company</p>
            </div>
            <div class="menu">
                <button id="company-information-button" data-target="company-information">Company information</button>
                <button id="employees-button" data-target="employees">Employees</button>
                <button id="resources-button" data-target="resources">Resources</button>
                <button id="services-button" data-target="services">Services</button>
            </div>
        </div>
        <div class="calendar-settings">
            <div class="header">
                <p>Calendar</p>
            </div>
            <div class="menu">
                <button id="calendar-button" data-target="calendar">Calendar</button>
                <button id="working-hours-button" data-target="working-hours">Working hours</button>
                <button id="online-booking-button" data-target="online-booking">Online booking</button>
            </div>
        </div>
        <div class="customers-settings">
            <div class="header">
                <p>Customers</p>
            </div>
            <div class="menu">
                <button id="customer-groups-button" data-target="customer-groups">Customer groups</button>
                <button id="forms-button" data-target="forms">Forms</button>
            </div>
        </div>
    </div>
    <div id="settings-index" class="settings-content">
        <div class="popular-settings">
            <h2>Popular settings</h2>
            <div class="card">
                <div class="image">
                    <img src="{{ asset('svg/services-image.svg') }}" alt="">
                </div>
                <div class="content">
                    <p class="title">Services</p>
                    <p>Set up and adjust the services you want to offer to your customers.</p>
                </div>
            </div>
            <div class="card">
                <div class="image">
                    <img src="{{ asset('svg/timetable-image.svg') }}" alt="">
                </div>
                <div class="content">
                    <p class="title">Timetable</p>
                    <p>Schedule your company's business hours and employee working hours.</p>
                </div>
            </div>
            <div class="card">
                <div class="image">
                    <img src="{{ asset('svg/online-bookings-image.svg') }}" alt="">
                </div>
                <div class="content">
                    <p class="title">Online bookings</p>
                    <p>Set up your settings for the booking widget and stay control.</p>
                </div>
            </div>
            <div class="card">
                <div class="image">
                    <img src="{{ asset('svg/communication-image.svg') }}" alt="">
                </div>
                <div class="content">
                    <p class="title">Communication</p>
                    <p>Adjust the content of your automatic emails and SMS.</p>
                </div>
            </div>
        </div>
        <div class="your-stats">
            <h2>Your stats</h2>
            <div class="stats">
                <div class="group">
                    <p class="number">1</p>
                    <p>total customers</p>
                </div>
                <div class="group">
                    <p class="number">8</p>
                    <p>total invoices</p>
                </div>
                <div class="group">
                    <p class="number">33</p>
                    <p>total appointments</p>
                </div>
            </div>
            <div class="invite">
                <p>Invite a colleague and receive up to $50 both</p>
                <button>Learn more</button>
            </div>
        </div>
    </div>
    <div id="general-settings" class="settings-content">
        <h2>General settings</h2>
        <div class="section selects">
            <div class="group">
                <label for="language">English</label>
                <select name="language" id="language" class="form-control">
                    <option value="0">English</option>
                </select>
            </div>
            <div class="group">
                <label for="currency">Currency</label>
                <select name="currency" id="currency" class="form-control">
                    <option value="0">Euro(&euro;)</option>
                </select>
            </div>
        </div>
        <div class="section access">
            <div class="group">
                <input type="checkbox" name="access" id="access">
                <label for="access">Allow Velnes employees to access my account</label>
            </div>
            <p>In order to help you answer any Velnes questions you might have, we may need to log into your account. You can allow or deny access any time.</p>
        </div>
        <button id="deleteAccountButton"><img src="{{ asset('svg/trash-red.svg') }}" alt=""> Delete my account</button>
        <div class="modal" id="deleteAccountModal">
            <div class="profile-delete">
                <div class="window">
                    <div class="header">
                        <h2>Do you want to proceed</h2>
                        <button class="closeModal" id="closeDeleteAccountModalButton"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                    </div>
                    <form action="">
                        <div class="warning">
                            <img src="{{ asset('svg/alert-red.svg') }}" alt="">
                            <p>Warning! You cannot revert this action. This will destroy all your data and will prevent you from being able to log intro your account.</p>
                        </div>
                        <div class="section">
                            <div class="group">
                                <input type="checkbox" id="confirm-delte" name="confirm-delte">
                                <label for="confirm-delte">Confirm deleting the account</label>
                            </div>
                            <p>I’m aware that by deleting my account, all my data will be erased and I will never be able to have access to it again or reactivate my account the way it currently is.</p>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                    </form>
                    <div class="footer">
                        <button type="submit" class="delete">Delete my account</button>
                        <button id="cancelDeleteAccountButton">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="user-accounts" class="settings-content">
        <div class="first-div">
            <div class="alert alert-success"></div>
            <p>Here you can create extra user accounts. By assining users to access levels, you determine the information they can see and actions are allowed to perform.</p>
            <button id="newUserAccountButton">New user account</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>email address</th>
                    <th>name</th>
                    <th>user access</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>t.natalia@gmail.com</td>
                    <td>N Natalia</td>
                    <td>Account owner</td>
                    <td class="userAccountsCrudModalField">
                        <button class="userAccountsCrudModalButton"><img src="{{ asset('svg/three-dots.svg') }}" alt=""></button>
                        <div class="crudModal userAccountsCrudModal">
                            <button class="editUserAccountButton">
                                <img src="{{ asset('svg/pen.svg') }}" alt="">
                                Edit
                            </button>
                            <button class="deleteUserAccountButton">
                                <img src="{{ asset('svg/trash-grey.svg') }}" alt="">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="modal deleteAccountModal">
        </div>
        <div class="modal" id="newUserAccountModal">
            <div class="user-create">
                <div class="window">
                    <div class="header">
                        <h2>Create new account</h2>
                        <button class="closeModal" id="closeNewUserAccountModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                    </div>
                    <form action="" id="accounts-store">
                        <div class="inner-form">
                        <div class="group">
                            <div class="form-group">
                                <label for="account-first_name">First name</label>
                                <input type="text" id="account-first_name" name="first_name" class="form-control">
                                <span class="error-message" id="account-first_name-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="account-last_name">Last name</label>
                                <input type="text" id="account-last_name" name="last_name" class="form-control">
                                <span class="error-message" id="account-last_name-error"></span>
                            </div>
                        </div>
                        <div class="group">
                            <div class="form-group">
                                <label for="account-email">Email</label>
                                <input type="text" id="account-email" name="email" class="form-control" placeholder="email@velnes.mk">
                                <span class="error-message" id="account-email-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="account-phone_number">Phone number</label>
                                <input type="text" id="account-phone_number" name="phone_number" class="form-control" placeholder="+389">
                                <span class="error-message" id="account-phone_number-error"></span>
                            </div>
                        </div>
                        <div class="group">
                            <div class="form-group">
                                <label for="update-account-password">Password</label>
                                <input type="password" id="update-account-password" name="password" class="form-control">
                                <span class="error-message" id="update-account-password-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="update-account-confirm_password">Confirm password</label>
                                <input type="password" id="update-account-confirm_password" name="confirm_password" class="form-control">
                                <span class="error-message" id="update-account-confirm_password-error"></span>
                            </div>
                        </div>
                        <label for="" class="access-label">User Access</label>
                        <!-- <div class="access-group">
                            <input type="checkbox" value="calendar-view-access" id="calendar-view-access" name="calendar-view-access">
                            <label for="calendar-view-access">
                                <p class="title">Calendar view</p>
                                <p>User has access to the calendar, can create and modify appointments</p>
                            </label>
                        </div>
                        <div class="access-group">
                            <input type="checkbox" value="full-access" id="full-access" name="full-access">
                            <label for="full-access">
                                <p class="title">Full access</p>
                                <p>Full access User has full access to all parts of your account.</p>
                            </label>
                        </div> -->
                        <div class="access-group">
                            <input type="radio" value="1" id="account-administrator-access" name="access">
                            <label for="account-administrator-access">
                                <p class="title">Administrator</p>
                                <p> User has access to all basic features, including Feedback and Reports. Can also access the aco for the sections "data export" and "user accounts</p>
                            </label>
                        </div>
                        <div class="access-group">
                            <input type="radio" value="2" id="account-manager-access" name="access">
                            <label for="account-manager-access">
                                <p class="title">Manager</p>
                                <p>User has access to all basic features, including Feedback. Has limited access to the account settings; can edit services and manage the schedule. No access to Reports.</p>
                            </label>
                        </div>
                        <span class="error-message" id="account-access-error"></span>
                        <!-- <div class="access-group">
                            <input type="checkbox" value="reports-access" id="reports-access" name="reports-access">
                            <label for="reports-access">
                                <p class="title">Reports</p>
                                <p>User has access to all basic features, including the Reports with financial data</p>
                            </label>
                        </div>
                        <div class="access-group">
                            <input type="checkbox" value="calendar-view-access" id="calendar-view-access" name="calendar-view-access">
                            <label for="calendar-view-access">
                                <p class="title">Calendar view</p>
                                <p>User has access to the calendar, can create and modify appointments</p>
                            </label>
                        </div>
                        <div class="access-group">
                            <input type="checkbox" value="basic-access" id="basic-access" name="basic-access">
                            <label for="basic-access">
                                <p class="title">Basic access</p>
                                <p>User has access to all features for daily use of Salonized. User can't edit or delete invoices</p>
                            </label>
                        </div> -->
                        </div>
                        <div class="footer">
                            <button type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal" id="editUserAccountModal">
            <div class="user-create">
                <div class="window">
                    <div class="header">
                        <h2>Edit account</h2>
                        <button class="closeModal" id="closeEditUserAccountModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                    </div>
                    <form action="" id="accounts-update">
                        <div class="inner-form">
                        <div class="group">
                            <div class="form-group">
                                <label for="first_name">First name</label>
                                <input type="text" id="update-account-first_name" name="first_name" class="form-control">
                                <span class="error-message" id="update-account-first_name-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="update-account-last_name">Last name</label>
                                <input type="text" id="update-account-last_name" name="last_name" class="form-control">
                                <span class="error-message" id="update-account-last_name-error"></span>
                            </div>
                        </div>
                        <div class="group">
                            <div class="form-group">
                                <label for="update-account-email">Email</label>
                                <input type="text" id="update-account-email" name="email" class="form-control" placeholder="email@velnes.mk">
                                <span class="error-message" id="update-account-email-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="update-account-phone_number">Phone number</label>
                                <input type="text" id="update-account-phone_number" name="phone_number" class="form-control" placeholder="+389">
                                <span class="error-message" id="update-account-phone_number-error"></span>
                            </div>
                        </div>
                        <label for="" class="access-label">User Access</label>
                        <!-- <div class="access-group">
                            <input type="checkbox" value="calendar-view-access" id="calendar-view-access" name="calendar-view-access">
                            <label for="calendar-view-access">
                                <p class="title">Calendar view</p>
                                <p>User has access to the calendar, can create and modify appointments</p>
                            </label>
                        </div>
                        <div class="access-group">
                            <input type="checkbox" value="full-access" id="full-access" name="full-access">
                            <label for="full-access">
                                <p class="title">Full access</p>
                                <p>Full access User has full access to all parts of your account.</p>
                            </label>
                        </div> -->
                        <div class="access-group">
                            <input type="checkbox" value="administrator-access" id="update-account-administrator-access" name="administrator-access">
                            <label for="update-account-administrator-access">
                                <p class="title">Administrator</p>
                                <p> User has access to all basic features, including Feedback and Reports. Can also access the aco for the sections "data export" and "user accounts</p>
                            </label>
                        </div>
                        <div class="access-group">
                            <input type="checkbox" value="manager-access" id="update-account-manager-access" name="manager-access">
                            <label for="update-account-manager-access">
                                <p class="title">Manager</p>
                                <p>User has access to all basic features, including Feedback. Has limited access to the account settings; can edit services and manage the schedule. No access to Reports.</p>
                            </label>
                        </div>
                        <!-- <div class="access-group">
                            <input type="checkbox" value="reports-access" id="reports-access" name="reports-access">
                            <label for="reports-access">
                                <p class="title">Reports</p>
                                <p>User has access to all basic features, including the Reports with financial data</p>
                            </label>
                        </div>
                        <div class="access-group">
                            <input type="checkbox" value="calendar-view-access" id="calendar-view-access" name="calendar-view-access">
                            <label for="calendar-view-access">
                                <p class="title">Calendar view</p>
                                <p>User has access to the calendar, can create and modify appointments</p>
                            </label>
                        </div>
                        <div class="access-group">
                            <input type="checkbox" value="basic-access" id="basic-access" name="basic-access">
                            <label for="basic-access">
                                <p class="title">Basic access</p>
                                <p>User has access to all features for daily use of Salonized. User can't edit or delete invoices</p>
                            </label>
                        </div> -->
                        </div>
                        <div class="footer">
                            <button type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="company-information" class="settings-content">
        <h2>Company information</h2>
        <form action="">
            <div class="section">
                <div class="group">
                    <div class="form-group company_name">
                        <label for="company_name">Company name*</label>
                        <input type="text" name="company_name" id="company_name" class="form-control">
                    </div>
                    <div class="form-group city">
                        <label for="city">City</label>
                        <input type="text" name="city" id="city" class="form-control">
                    </div>
                    <div class="form-group postal_code">
                        <label for="postal_code">Postal code</label>
                        <input type="text" name="postal_code" id="postal_code" class="form-control">
                    </div>
                </div>
                <div class="group contact">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone number</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control">
                    </div>
                </div>
                <div class="group">
                    <div class="form-group">
                        <label for="company_logo">Company logo</label>
                        <input type="file" name="company_logo" id="company_logo" class="form-control">
                    </div>
                </div>
            </div>
        </form>
        <form action="">
            <div class="section">
                <div class="form-group">
                    <label for="notification_email_address">Notification email address</label>
                    <input type="text" id="notification_email_address" name="notification_email_address" class="form-control">
                </div>
                <div class="form-group">
                    <label for="billing_email_address">Billing email address</label>
                    <input type="text" id="billing_email_address" name="billing_email_address" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Contact email address</label>
                    <button>Connect Email</button>
                </div>
            </div>
        </form>
        <h2>SMS Settings</h2>
        <form action="" class="sms">
            <div class="form-group">
                <label for="sms_message_sender">SMS Message sender</label>
                <input type="text" id="sms_message_sender" name="sms_message_sender" class="form-control">
            </div>
            <div class="form-group">
                <label for="sms_notification_number">SMS notification number</label>
                <input type="text" id="sms_notification_number" name="sms_notification_number" class="form-control">
            </div>
        </form>
        <h2>Social information</h2>
        <form action="">
            <p>Fill in your social information and we will help you promote them</p>
            <div class="form-group">
                <label for="facebook">http://www.facebook.com/</label>
                <input type="text" id="facebook" name="facebook" class="form-control">
            </div>
            <div class="form-group">
                <label for="facebook">http://www.twitter.com/</label>
                <input type="text" id="facebook" name="facebook" class="form-control">
            </div>
            <div class="form-group">
                <label for="facebook">http://www.instagram.com/</label>
                <input type="text" id="facebook" name="facebook" class="form-control">
            </div>
        </form>
    </div>
    <div id="employees" class="settings-content">
        <div class="employees-actions">
            <div class="group">
                <select name="employees-type" id="employees-type" class="form-control">
                    <option value="0">Active employees</option>
                    <option value="1">Bookable employees</option>
                    <option value="2">Deleted employees</option>
                </select>
                <input type="search" name="search_employees" id="search_employees" class="form-control" placeholder="Search employees">
            </div>
            <button id="createEmployeeAccountButton">New employee</button>
            <div class="alert alert-success"></div>
        </div>
        <div class="employees-div">
        </div>
        <div class="modal" id="editEmployeeAccountModal">
            <div class="user-create">
                <div class="window">
                    <div class="header">
                        <h2>Edit account</h2>
                        <button class="closeModal" id="closeEditEmployeeAccountModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                    </div>
                    <form action="" id="employee-update">
                        <div class="inner-form">
                        <div class="group name-photo">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="employee-name" name="name">
                                <span id="employee-update-name-error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="photo">Photo</label>
                                <div class="inner-group">
                                    <div class="profile-picture">
                                        <div class="circle">
                                            <p>M</p>
                                        </div>
                                    </div>
                                    <input type="file" placeholder="change photo">
                                </div>
                            </div>
                        </div>
                        <div class="group gender">
                            <label for="gender">Gender</label>
                            <div class="options">
                                <div class="radio-group">
                                    <input type="radio" value="male" name="gender" id="male">
                                    <label for="male">Male</label>
                                </div>
                                <div class="radio-group">
                                    <input type="radio" value="female" name="gender" id="female">
                                    <label for="female">Female</label>
                                </div>
                                <div class="radio-group">
                                    <input type="radio" value="unknown" name="gender" id="unknown">
                                    <label for="unknown">Unknown</label>
                                </div>
                                <span id="employee-update-gender-error" class="error-message"></span>
                            </div>
                        </div>
                        <div class="group email-number">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" id="employee-email" name="email" class="form-control">
                                <span id="employee-update-email-error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Phone number</label>
                                <input type="text" id="employee-phone_number" name="phone_number" class="form-control">
                                <span id="employee-update-phone_number-error" class="error-message"></span>
                            </div>
                        </div>
                        <div class="group bookable">
                            <div class="form-group">
                                <input type="checkbox" name="bookable_online" id="employee-bookable_online">
                                <label for="bookable_online">Allow this employee to be bookable online</label>
                            </div>
                        </div>
                        <div class="group checkboxes">
                            <h3>This employee is available for the following services</h3>
                            <div id="update-checkboxes-container">

                            </div>
                            <span id="employee-update-services-error" class="error-message"></span>
                        </div>
                        </div>
                        <div class="footer">
                            <button type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal" id="createEmployeeAccountModal">
            <div class="user-create">
                <div class="window">
                    <div class="header">
                        <h2>Create new employee</h2>
                        <button class="closeModal" id="closeCreateEmployeeAccountModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                    </div>
                    <form action="" id="employee-store">
                        <div class="inner-form">
                        <div class="group name-photo">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                                <span id="employee-name-error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="photo">Photo</label>
                                <div class="inner-group">
                                    <div class="profile-picture">
                                        <div class="circle">
                                            <p>M</p>
                                        </div>
                                    </div>
                                    <input type="file" placeholder="change photo">
                                </div>
                            </div>
                        </div>
                        <div class="group gender">
                            <label for="gender">Gender</label>
                            <div class="options">
                                <div class="radio-group">
                                    <input type="radio" value="male" name="gender" id="male">
                                    <label for="male">Male</label>
                                </div>
                                <div class="radio-group">
                                    <input type="radio" value="female" name="gender" id="female">
                                    <label for="female">Female</label>
                                    
                                </div>
                                <div class="radio-group">
                                    <input type="radio" value="unknown" name="gender" id="unknown">
                                    <label for="unknown">Unknown</label>
                                </div>
                            </div>
                            <span id="employee-gender-error" class="error-message"></span>
                        </div>
                        <div class="group email-number">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" id="email" name="email" class="form-control">
                                <span id="employee-email-error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Phone number</label>
                                <input type="text" id="phone_number" name="phone_number" class="form-control">
                                <span id="employee-phone_number-error" class="error-message"></span>
                            </div>
                        </div>
                        <div class="group bookable">
                            <div class="form-group">
                                <input type="checkbox" name="bookable_online" id="bookable_online">
                                <label for="bookable_online">Allow this employee to be bookable online</label>
                            </div>
                        </div>
                        <div class="group checkboxes">
                            <h3>This employee is available for the following services</h3>
                            <div id="checkboxes-container">

                            </div>
                            <span id="employee-services-error" class="error-message"></span>
                        </div>
                        </div>
                        <div class="footer">
                            <button type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="settings-content" id="resources">
        <div class="resources-actions">
            <div class="alert alert-success"></div>
            <div class="group">
                <select name="resources-type" id="resources-type" class="form-control">
                    <option value="0">All</option>
                    <option value="rooms">Rooms</option>
                    <option value="tools">Tools</option>
                </select>
                <input type="search" name="search_resources" id="search_resources" class="form-control" placeholder="Search resources">
            </div>
            <button id="createResourceButton">New resource</button>
        </div>
        <div class="resources-div rooms">
            <label for="">Active rooms</label>
        </div>
        <div class="resources-div tools">
            <label for="">Active tools</label>
        </div>
        <div class="modal" id="createResourceModal">
            <div class="window">
                <div class="header">
                    <h2>Resource</h2>
                    <button class="closeModal" id="closeCreateResourceModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                </div>
                <form action="" id="resources-store">
                    <div class="inner-form">
                        <div class="group name-photo">
                            <div class="form-group">
                                <label for="resource-name">Name</label>
                                <input type="text" id="resource-name" name="name" class="form-control">
                                <span class="error-message" id="resource-name-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="photo">Photo</label>
                                <div class="inner-group">
                                    <div class="profile-picture">
                                        <div class="circle">
                                            <p>M</p>
                                        </div>
                                    </div>
                                    <input type="file" placeholder="change photo">
                                </div>
                            </div>
                        </div>
                        <div class="group radio">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <div class="options">
                                    <div class="radio-group">
                                        <input type="radio" id="resource-type-room" name="type" value="room">
                                        <label for="resource-type-room">Room</label>
                                    </div>
                                    <div class="radio-group">
                                        <input type="radio" id="resource-type-tool" name="type" value="tool">
                                        <label for="resource-type-tool">Tool</label>
                                    </div>
                                    <span class="error-message" id="resource-type-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="group bookable-online">
                            <div class="form-group">
                                <input type="checkbox" id="resource_bookable_online" name="resource_bookable_online">
                                <label for="resource_bookable_online">Allow this resource to be bookable online</label>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <button>Save</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal" id="editResourceModal">
            <div class="window">
                <div class="header">
                    <h2>Edit Resource</h2>
                    <button class="closeModal" id="closeEditResourceModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                </div>
                <form action="" id="resources-update">
                    <div class="inner-form">
                        <div class="group name-photo">
                            <div class="form-group">
                                <label for="update-resources-name">Name</label>
                                <input type="text" id="update-resources-name" name="name" class="form-control">
                                <span class="error-message" id="update-resources-name-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="photo">Photo</label>
                                <div class="inner-group">
                                    <div class="profile-picture">
                                        <div class="circle">
                                            <p>M</p>
                                        </div>
                                    </div>
                                    <input type="file" placeholder="change photo">
                                </div>
                            </div>
                        </div>
                        <div class="group bookable-online">
                            <div class="form-group">
                                <input type="checkbox" id="resource_bookable_online" name="resource_bookable_online">
                                <label for="resource_bookable_online">Allow this resource to be bookable online</label>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <button>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="services" class="settings-content">
        <div class="services-actions">
            <div class="alert alert-success"></div>
            <div class="group">
                <select name="services-type" id="serviceCategoriesSelect" class="form-control">
                    <option value="0">All</option>
                </select>
                <input type="search" name="search_services" id="search_services" class="form-control" placeholder="Search services">
            </div>
            <div class="buttons">
                <button id="addServiceCategoryButton">Add category</button>
                <button id="createServiceButton">New service</button>
            </div>
        </div>
        <div class="services-div">
            
        </div>
        <div class="modal" id="createServiceModal">
            <div class="window">
                <div class="header">
                    <h2>Create service</h2>
                    <button class="closeModal" id="closeCreateServiceModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                </div>
                <form action="" id="store-service">
                    <div class="inner-form">
                        <div class="group name-photo">
                            <div class="form-group">
                                <label for="service-name">Service name</label>
                                <input type="text" id="service-name" name="name" class="form-control">
                                <span class="error-message" id="service-name-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="service-service_category">Category</label>
                                <select name="service_category" id="service-service_category" class="form-control">
                                    <option value="0">Select</option>
                                    @foreach($serviceCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error-message" id="service-service_category-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="service-price">Price</label>
                                <input type="text" id="service-price" name="price" class="form-control">
                                <span class="error-message" id="service-price-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="service-vat_rate">Vat rate</label>
                                <select name="vat_rate" id="service-vat_rate" class="form-control">
                                    <option value="0">Select</option>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                </select>
                                <span class="error-message" id="service-vat-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="service-duration">Duration</label>
                                <select name="duration" id="service-duration" class="form-control">
                                    <option value="0">Select</option>
                                    <option value="15">15 min</option>
                                    <option value="30">30 min</option>
                                    <option value="45">45 min</option>
                                    <option value="60">60 min</option>
                                    <option value="75">75 min</option>
                                    <option value="90">90 min</option>
                                </select>
                                <span class="error-message" id="service-duration-error"></span>
                            </div>
                            <div class="form-group bookable">
                                <input type="checkbox" name="bookable_online" id="service-bookable_online">
                                <label for="service-bookable_online">Allow this service to be bookable online</label>
                                <span class="error-message" id="service-bookable_online-error"></span>
                            </div>
                            <div class="form-group employees">
                                <p>Employees who can perform this service</p>
                                <div class="employees-checkboxes">
                                    @foreach($employees as $employee)
                                        <div class="group">
                                            <input type="checkbox" value="{{ $employee->id }}" id="employee-{{ $employee->id }}" name="employees[]">
                                            <label for="employee-{{ $employee->id }}">{{ $employee->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <button>Save</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal" id="editServiceModal">
            <div class="window">
                <div class="header">
                    <h2>Edit service</h2>
                    <button class="closeModal" id="closeEditServiceModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                </div>
                <form action="" id="update-service">
                    <div class="inner-form">
                        <div class="group name-photo">
                            <div class="form-group">
                                <label for="update-service-name">Service name</label>
                                <input type="text" id="update-service-name" name="name" class="form-control">
                                <span class="error-message" id="update-service-name-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="update-service-service_category">Category</label>
                                <select name="service_category" id="update-service-service_category" class="form-control">
                                    <option value="0">Select</option>
                                    @foreach($serviceCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span class="error-message" id="update-service-service_category-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="update-service-price">Price</label>
                                <input type="text" id="update-service-price" name="price" class="form-control">
                                <span class="error-message" id="update-service-price-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="update-service-vat_rate">Vat rate</label>
                                <select name="vat_rate" id="update-service-vat_rate" class="form-control">
                                    <option value="0">Select</option>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                </select>
                                <span class="error-message" id="update-service-vat-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="update-service-duration">Duration</label>
                                <select name="duration" id="update-service-duration" class="form-control">
                                    <option value="0">Select</option>
                                    <option value="15">15 min</option>
                                    <option value="30">30 min</option>
                                    <option value="45">45 min</option>
                                    <option value="60">60 min</option>
                                    <option value="75">75 min</option>
                                    <option value="90">90 min</option>
                                </select>
                                <span class="error-message" id="update-service-duration-error"></span>
                            </div>
                            <div class="form-group bookable">
                                <input type="checkbox" name="bookable_online" id="update-service-bookable_online">
                                <label for="update-service-bookable_online">Allow this service to be bookable online</label>
                            </div>
                            <div class="form-group employees">
                                <p>Employees who can perform this service</p>
                                <div class="employees-checkboxes">
                                    @foreach($employees as $employee)
                                        <div class="group">
                                            <input type="checkbox" value="{{ $employee->id }}" id="update-employee-{{ $employee->id }}" name="employees[]">
                                            <label for="employee-{{ $employee->id }}">{{ $employee->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <button>Save</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal" id="createServiceCategoryModal">
            <div class="window">
                <div class="header">
                    <h2>Create service category</h2>
                    <button class="closeModal" id="closeCreateServiceCategoryModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                </div>
                <form action="" id="store-service-category">
                    <div class="inner-form">
                        <div class="name-group">
                            <label for="name">Name</label>
                            <input type="text" id="service-category-name" name="name" class="form-control">
                            <span class="error-message" id="service-category-name-error"></span>
                        </div>
                        <div class="color-group">
                            <label for="color">Color</label>
                            <div class="group">
                                <div class="circle">
                                    <div class="inner-circle"></div>
                                </div>
                                <select name="color" id="service-category-color" class="form-control">
                                    <option value="0">Select color</option>
                                    <option value="#BE7300">Ochre color</option>
                                    <option value="#FFA78A">Atomic tangerine</option>
                                    <option value="#3689A0">Munsel blue</option>
                                    <option value="#A0CE95">Celadon</option>
                                </select>
                                <span class="error-message" id="service-category-color-error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <button>Save</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal" id="editServiceCategoryModal">
            <div class="window">
                <div class="header">
                    <h2>Edit service category</h2>
                    <button class="closeModal" id="closeEditServiceCategoryModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                </div>
                <form action="" id="update-service-category">
                    <div class="inner-form">
                        <div class="name-group">
                            <label for="update-service-category-name">Name</label>
                            <input type="text" id="update-service-category-name" name="name" class="form-control">
                            <span class="error-message" id="update-service-category-name-error"></span>
                        </div>
                        <div class="color-group">
                            <label for="color">Color</label>
                            <div class="group">
                                <div class="circle">
                                    <div class="inner-circle"></div>
                                </div>
                                <select name="color" id="update-service-category-color" class="form-control">
                                    <option value="0">Select color</option>
                                    <option value="#BE7300">Ochre color</option>
                                    <option value="#FFA78A">Atomic tangerine</option>
                                    <option value="#3689A0">Munsel blue</option>
                                    <option value="#A0CE95">Celadon</option>
                                </select>
                                <span class="error-message" id="update-service-category-color-error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <button>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="working-hours" class="settings-content">
        <div class="working-hours-actions">
            <div>
                <h2>Week 20</h2>
                <p class="date">May 22-28</p>
            </div>
            <div>
                <p class="today">Today</p>
                <div class="choose-date">
                    <button class="previousDayBtn"><img src="{{ asset('svg/arrow-left.svg') }}" alt=""></button>
                    <input type="date" name="datePicker" id="datePicker" value="{{ now()->format('Y-m-d') }}">
                    <button class="nextDayBtn"><img src="{{ asset('svg/arrow-right.svg') }}" alt=""></button>
                </div>
            </div>
        </div>
        <div class="days">
            <div class="space"></div>
            <div class="inner-days">
                <div class="day">
                    <p class="date">22</p>
                    <p class="day-of-week">Monday</p>
                </div>
                <div class="day">
                    <p class="date">23</p>
                    <p class="day-of-week">Monday</p>
                </div>
                <div class="day">
                    <p class="date">24</p>
                    <p class="day-of-week">Monday</p>
                </div>
                <div class="day">
                    <p class="date">25</p>
                    <p class="day-of-week">Monday</p>
                </div>
                <div class="day">
                    <p class="date">26</p>
                    <p class="day-of-week">Monday</p>
                </div>
                <div class="day">
                    <p class="date">27</p>
                    <p class="day-of-week">Monday</p>
                </div>
                <div class="day">
                    <p class="date">28</p>
                    <p class="day-of-week">Monday</p>
                </div>
            </div>
        </div>
        <div class="salon-working-hours">
            <div class="salon-identity">
                <div class="name-photo">
                    <div class="profile-picture">
                        <div class="circle">
                            <p>S</p>
                        </div>
                    </div>
                    <p class="name">Salon</p>
                </div>
                <p class="hours">54 hours</p>
            </div>
            <div class="working-hours">
                <div class="interval divided">
                    <div class="inner-interval green">
                        <p>9:00 - 14:00</p>
                    </div>
                    <div class="inner-interval blue">
                        <p>9:00 - 14:00</p>
                    </div>
                    <div class="inner-interval orange">
                        <p>9:00 - 14:00</p>
                    </div>
                </div>
                <div class="interval">
                    <p>9:00 - 19:00</p>
                </div>
                <div class="interval">
                    <p>9:00 - 19:00</p>
                </div>
                <div class="interval">
                    <p>9:00 - 19:00</p>
                </div>
                <div class="interval">
                    <p>9:00 - 19:00</p>
                </div>
                <div class="interval">
                    <p>9:00 - 19:00</p>
                </div>
                <div class="interval add-new">
                    <p>+</p>
                </div>
            </div>
        </div>
        <div class="employees-working-hours">
            <h2>Employees</h2>
            <div class="employee salon">
                <div class="identity">
                    <div class="name-photo">
                        <div class="profile-picture">
                            <div class="circle">
                                <p>SO</p>
                            </div>
                        </div>
                        <p class="name">Salon owner</p>
                    </div>
                    <p class="hours">52 hours</p>
                </div>
                <div class="working-hours">
                    <div class="interval">
                        <p>Same as salon</p>
                    </div>
                </div>
            </div>
            <div class="employee">
                <div class="identity">
                    <div class="name-photo">
                        <div class="profile-picture">
                            <div class="circle">
                                <p>K</p>
                            </div>
                        </div>
                        <p class="name">Katerina</p>
                    </div>
                    <p class="hours">52 hours</p>
                </div>
                <div class="working-hours">
                    <div class="interval">
                        <p>9:00 -19:00</p>
                    </div>
                    <div class="interval">
                        <p>9:00 -19:00</p>
                    </div>
                    <div class="interval">
                        <p>9:00 -19:00</p>
                    </div>
                    <div class="interval">
                        <p>9:00 -19:00</p>
                    </div>
                    <div class="interval">
                        <p>9:00 -19:00</p>
                    </div>
                    <div class="interval add-new">
                        <p>+</p>
                    </div>
                    <div class="interval add-new">
                        <p>+</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="customer-groups" class="settings-content">
        <div class="customer-group-actions">
            <button id="createCustomerGroupsButton">New group</button>
            <div class="alert alert-success"></div>
        </div>
        <div class="customer-groups-content">
            <table>
                <thead>
                    <tr>
                        <th>name</th>
                        <th>customers</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="modal" id="createCustomerGroupsModal">
            <div class="window">
                <div class="header">
                    <h2>Create customer group</h2>
                    <button class="closeModal" id="closeCreateCustomerGroupsModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                </div>
                <form action="" id="customer-group-store">
                    <div class="inner-form">
                        <div class="form-group">
                            <label for="name">Name*</label>
                            <input type="text" class="form-control" id="customer-group-name" name="name">
                            <span id="customer-group-name-error" class="error-message"></span>
                        </div>
                    </div>
                    <div class="footer">
                        <button>Save</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal" id="editCustomerGroupsModal">
            <div class="window">
                <div class="header">
                    <h2>Edit customer group</h2>
                    <button class="closeModal" id="closeEditCustomerGroupsModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                </div>
                <form action="" id="customer-group-update">
                    <div class="inner-form">
                        <div class="form-group">
                            <label for="name">Name*</label>
                            <input type="text" class="form-control" id="update-customer-group-name" name="name">
                            <span id="update-customer-group-name-error" class="error-message"></span>
                        </div>
                    </div>
                    <div class="footer">
                        <button>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @vite(['resources/js/settingsMenu.js', 'resources/js/generalSettings.js', 'resources/js/userAccounts.js', 'resources/js/employeeAccounts.js', 'resources/js/resources.js', 'resources/js/services.js', 'resources/js/customerGroups.js'])
@endsection
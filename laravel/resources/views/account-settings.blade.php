@extends('layouts.app')
@section('title', 'Account Settings')
@section('page-name')
    <h1 id="calendarTitle">My account</h1>
@endsection
@section('velnesActive', 'active')
@section('content')
    <div class="account-settings">
        <div class="account-settings-nav">
            <button id="accountSettingsButton" class="active">Account settings</button>
            <button id="inviteColleaguesButton">Invite colleagues</button>
            <button id="billingButton">Billing</button>
            <button id="logoutButton">Logout</button>
        </div>
        <div id="accountSettings" class="account-settings-content">
            @if(session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="my-account section">
                <h2>My account</h2>
                <p class="info">Change login info, password and notification settings</p>
            </div>
            <div class="login-info section">
                <form action="{{ route('update.login.info') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="inner-form">
                        <h2>Login info</h2>
                        <div class="form-group">
                            <label for="full_name">Full name</label>
                            <input type="text" for="full_name" name="full_name" class="form-control" value="{{ auth()->user()->full_name }}">
                            @error('full_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="work_email">Email</label>
                            <input type="text" for="work_email" name="work_email" class="form-control" value="{{ auth()->user()->work_email }}">
                            @error('work_email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <button>Save</button>
                    </div>
                </form>
            </div>
            <div class="change-password section">
                <form action="{{ route('update.password') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="inner-form">
                        <h2>Change password</h2>
                        <div class="form-group">
                            <label for="current_password">Current password</label>
                            <input type="password" for="current_password" name="current_password" class="form-control">
                            @error('current_password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">New password</label>
                            <input type="password" for="password" name="password" class="form-control">
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Repeat password</label>
                            <input type="password" for="password_confirmation" name="password_confirmation" class="form-control">
                            @error('password_confirmation')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <p class="warning">Changing your password will require you to sign in again</p>
                    <button>Save</button>
                </form>
            </div>
            <div class="modal" id="logoutModal">
                <div class="window">
                    <div class="header">
                        <h2>Do you want to log out?</h2>
                        <button class="closeModal" id="closeLogoutModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                    </div>
                    <div class="footer">
                    <button id="cancelLogoutButton">Cancel</button>
                    <form action="{{ route('logout') }}" class="mini" method="POST">
                        @csrf
                        <button><img src="{{ asset('svg/logout.svg') }}" alt="">Logout</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="invite-colleagues" class="account-settings-content"></div>
    <div id="billing" class="account-settings-content"></div>
@endsection
@section('scripts')
    @vite(['resources/js/accountSettings.js'])
@endsection
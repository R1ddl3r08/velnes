@extends('layouts.guest')
@section('title', 'Register')

@section('form')
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-title">
            <h3>Join us for free</h3>
        </div>
        <div class="form-inputs">
            <div class="form-group">
                <label for="full_name">Full name*</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name') }}">
                @error('full_name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="company_name">Company name*</label>
                <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name') }}">
                @error('company_name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="work_email">Your work email address*</label>
                <input type="text" class="form-control" id="work_email" name="work_email" value="{{ old('work_email') }}">
                @error('work_email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone_number">Phone number*</label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                @error('phone_number')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password*</label>
                <input type="password" class="form-control" id="password" name="password">
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                <div id="password-requirements" class="password-requirements"></div>
            </div>
            <p>By registering you will agree to our <a href="">terms and conditions</a>.</p>
        </div>
        <div class="form-btn">
            <button type="submit" class="registerBtn">Get started</button>
        </div>
    </form>
@endsection

@section('message')
<p class="message">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
@endsection
@section('scripts')
    @vite(['resources/js/passwordValidation.js'])
@endsection
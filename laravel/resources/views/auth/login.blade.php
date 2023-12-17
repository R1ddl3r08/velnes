@extends('layouts.guest')
@section('title', 'Login')

@section('form')
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-title">
            <h3>Login</h3>
        </div>
        <div class="form-inputs">
            <div class="form-group">
                <label for="work_email">Email*</label>
                <input type="text" class="form-control" id="work_email" name="work_email">
                @error('work_email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password*</label>
                <input type="password" class="form-control" id="password" name="password">
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form-btn">
            <a href="">Forgot password?</a>
            <button type="submit">Log in</button>
        </div>
    </form>
@endsection

@section('message')
<p class="message">Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
@endsection
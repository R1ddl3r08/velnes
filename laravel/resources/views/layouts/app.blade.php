<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/main.css'])
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        const baseUrl = "{{ asset('') }}";
        const profileIconUrl = "{{ asset('svg/profile-icon.svg') }}";
        const penIconUrl = "{{ asset('svg/pen.svg') }}";
        const cartGreyIconUrl = "{{ asset('svg/cart-grey.svg') }}";
        const noShowIconUrl = "{{ asset('svg/no-show.svg') }}";
        const trashIconUrl = "{{ asset('svg/trash-grey.svg') }}";
        const arrowDownIconUrl = "{{ asset('svg/arrow-down.svg') }}";
        const arrowUpIconUrl = "{{ asset('svg/arrow-up.svg') }}";
        const threeDotsSvgPath = `${baseUrl}svg/three-dots.svg`;
    </script>
</head>
<body>
    <div id="menu">
        <div id="menu-icons">
            <a href="{{ route('dashboard.index') }}" class="velnes icon @yield('velnesActive')">
                <img src="{{ asset('svg/icon-home.svg') }}" alt="">
            </a>
            <a href="{{ route('calendar.index') }}" class="calendar icon @yield('calendarActive')">
                <img src="{{ asset('svg/calendar.svg') }}" alt="">
            </a>
            <a href="" class="payment icon @yield('paymentActive')">
                <img src="{{ asset('svg/payment.svg') }}" alt="">
            </a>
            <a href="{{ route('products.index') }}" class="products icon @yield('productsActive')">
                <img src="{{ asset('svg/bottle.svg') }}" alt="">
            </a>
            <a href="{{ route('customers.index') }}" class="profile icon @yield('customersActive')">
                <img src="{{ asset('svg/profile.svg') }}" alt="">
            </a>
            <a class="mail icon @yield('mailActive')">
                <img src="{{ asset('svg/mail.svg') }}" alt="">
            </a>
            <a href="{{ route('reports.index') }}" class="statistics icon @yield('reportsActive')">
                <img src="{{ asset('svg/statistics.svg') }}" alt="">
            </a>
        </div>
        <div id="settings-div">
            <a href="{{ route('settings.index') }}" class="settings icon @yield('settingsActive')">
                <img src="{{ asset('svg/settings.svg') }}" alt="">
            </a>
        </div>
    </div>
    <nav class="@if (trim($__env->yieldContent('page-name'))) space-between @else flex-end @endif">
        @yield('page-name')
        <div class="main-icons">
            <div class="search icon">
                <img src="{{ asset('svg/search.svg') }}" alt="">
            </div>
            <div id="searchInput" class="icon">
                <input type="text" placeholder="Search for users" id="userSearch">
            </div>
            <div class="notifications icon">
                <img src="{{ asset('svg/bell.svg') }}" alt="">
            </div>
            <div class="profile-picture icon">
                <div class="circle">
                    @if(auth()->check() && auth()->user()->photo_url)
                        <img src="{{ asset('storage/' . Auth::user()->photo_url) }}" alt="Profile Picture">
                    @else
                        <div class="circle">
                            <p>{{ substr(auth()->user()->full_name, 0, 1) }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="window profile-menu mini">
            <a href="{{ route('account-settings.index') }}"><img src="{{ asset('svg/pen.svg') }}" alt="">Account settings</a>
            @if(auth()->user()->role_id == 1)
                <a href=""><img src="{{ asset('svg/plus.svg') }}" alt="">Invite colleagues</a>
                <a href=""><img src="{{ asset('svg/cart.svg') }}" alt="">Billing</a>
            @endif
            <form action="{{ route('logout') }}" class="mini" method="POST">
                @csrf
                <button><img src="{{ asset('svg/logout.svg') }}" alt="">Logout</button>
            </form>
        </div>
        <div class="window notifications mini">
            <div class="notifications-title">
                <h3>Welcome to Velnes</h3>
                <img src="{{ asset('svg/close.svg') }}" alt="" id="closeNotifications">
            </div>
            <div class="main">
                <div class="inner-main">
                    <ul>
                        <li><img src="{{ asset('svg/taskCheck.svg') }}" alt="" id="task1Status">Set up your appointment</li>
                        <li><img src="" alt="" id="task2Status">Give the booking widget a try</li>
                        <li><img src="" alt="" id="task3Status">Set your business hours</li>
                        <li><img src="" alt="" id="task4Status">Set up your customer base</li>
                        <li><img src="" alt="" id="task5Status">Set up your company info</li>
                    </ul>
                </div>
            </div>
            @if(auth()->user()->is_trial == true)
                <div class="footer">
                    <div class="trial-div">
                        @php
                            $trialEndDate = auth()->user()->trial_end_date;
                            $currentDate = \Carbon\Carbon::now();
                            $daysLeft = $currentDate->diffInDays($trialEndDate);
                        @endphp
                        <p>trial ends</p>
                        <h3>{{ $daysLeft }} days</h3>
                    </div>
                    <div class="upgrade-div">
                        <a href="">Upgrade now</a>
                    </div>
                </div>
            @endif
        </div>
    </nav>
    <div class="content">
        @yield('content')
    </div>
    @vite(['resources/js/navbar.js'])
    @yield('scripts')
</body>
</html>
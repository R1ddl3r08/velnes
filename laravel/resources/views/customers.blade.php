@extends('layouts.app')
@section('title', 'Customers')
@section('page-name')
    <h1 id="calendarTitle">Customers</h1>
@endsection
@section('customersActive', 'active')
@section('content')
    <div class="customers">
        <div class="customers-nav">
            <input type="text" class="form-control" placeholder="search" name="customers-search" id="customers-search">
            <div>
                <select name="customers-file" id="customers-file" class="form-control">
                    <option value="0">File</option>
                </select>
                <button id="customerCreateButton">Create customer</button>
            </div>
            <div class="alert alert-success"></div>
        </div>
        <div class="filters">
            <div class="form-group">
                <label for="customer-group">Customer group</label>
                <select name="customer-group" id="customer-group" class="form-control">
                    <option value="0">All</option>
                    @foreach($customerGroups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="treated-by">Treated by</label>
                <select name="treated-by" id="treated-by" class="form-control">
                    <option value="0">All employees</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
                </select>
            </div>
            <div class="form-group">
                <label for="services">Services</label>
                <select name="services" id="services" class="form-control">
                    <option value="0">All services</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
                </select>
            </div>
            <div class="form-group">
                <label for="products">Products</label>
                <select name="products" id="products" class="form-control">
                    <option value="0">All products</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                </select>
            </div>
            <div class="filters-button">
                <img src="{{ asset('svg/filter.svg') }}" alt="">
            </div>
        </div>
        <div class="selected-filters"></div>
            <table>
                <thead>
                    <tr>
                        <th>full name</th>
                        <th>customer group</th>
                        <th>phone mobile</th>
                        <th>email</th>
                        <th>newsletter</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                        <tr id="{{ $customer->id }}">
                            <td>
                                <a href="{{ route('customers.customer', ['id' => $customer->id]) }}">{{ $customer->first_name }} {{ $customer->last_name }}</a>
                            </td>
                            <td>
                                @if($customer->groups->isNotEmpty())
                                    <ul>
                                        @foreach($customer->groups as $group)
                                            <li>{{ $group->name }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    /
                                @endif
                            </td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>
                                @if($customer->newsletter)
                                    <img src="{{ asset('svg/check.svg') }}" alt="">
                                @else
                                    <img src="{{ asset('svg/x.svg') }}" alt="">
                                @endif
                            </td>
                            <td>
                                <button class="customerCrudModalButton"><img src="{{ asset('svg/three-dots.svg') }}" alt=""></button>
                                <div class="crudModal customerCrudModal">
                                    <button class="editCustomerButton" data-id="{{ $customer->id }}">
                                        <img src="{{ asset('svg/pen.svg') }}" alt="">
                                        Edit
                                    </button>
                                    <button class="deleteCustomerButton" data-id="{{ $customer->id }}">
                                        <img src="{{ asset('svg/trash-grey.svg') }}" alt="">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="modal" id="customerCreateModal">
                <div class="customer-create">
                    <div class="window">
                        <div class="header">
                            <h2>Create customer</h2>
                            <button class="closeModal" id="closeCreateCustomerModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                        </div>
                        <form action="" id="customer-store">
                            <div class="inner-form">
                                <h3>Personal information</h3>
                                <div class="form-group">
                                    <label for="first_name">First name</label>
                                    <input type="text" ida="first_name" name="first_name" class="form-control">
                                    <span id="first_name-error" class="error-message"></span>
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last name</label>
                                    <input type="text" ida="last_name" name="last_name" class="form-control">
                                    <span id="last_name-error" class="error-message"></span>
                                </div>
                                <div class="form-group">
                                    <label for="date_of_birth">Date of birth</label>
                                    <input type="date" ida="date_of_birth" name="date_of_birth" class="form-control">
                                    <span id="date_of_birth-error" class="error-message"></span>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <input type="file" id="photo" name="photo" class="form-control">
                                    <span id="photo-error" class="error-message"></span>
                                </div>
                                <div class="form-group radio">
                                    <label for="" class="group-label">Gender</label>
                                    <div class="radio-groups">
                                        <div class="radio-group">
                                            <input type="radio" name="gender" id="male" value="male">
                                            <label for="male">Male</label>
                                        </div>
                                        <div class="radio-group">
                                            <input type="radio" name="gender" id="female" value="female">
                                            <label for="female">Female</label>
                                        </div>
                                        <div class="radio-group">
                                            <input type="radio" name="gender" id="other" value="other">
                                            <label for="other">Other</label>
                                        </div>
                                    </div>
                                    <span id="gender-error" class="error-message"></span>
                                </div>
                                <h3>Other information</h3>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="email@velnes.mk">
                                    <span id="email-error" class="error-message"></span>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone number</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="+389">
                                    <span id="phone-error" class="error-message"></span>
                                </div>
                                <div class="form-group address">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" id="address" class="form-control">
                                    <span id="address-error" class="error-message"></span>
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" name="city" id="city" class="form-control">
                                    <span id="city-error" class="error-message"></span>
                                </div>
                                <div class="form-group">
                                    <label for="postal_code">Postal code</label>
                                    <input type="text" name="postal_code" id="postal_code" class="form-control">
                                    <span id="postal_code-error" class="error-message"></span>
                                </div>
                                <h3>Additional information</h3>
                                <div class="form-group">
                                    <label for="customer_groups">Customer groups</label>
                                    <select name="customer_groups" id="customer_groups" class="form-control">
                                        <option value="0">Select</option>
                                        @foreach($customerGroups as $group)
                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                    <span id="customer_groups-error" class="error-message"></span>
                                </div>
                                <a href="">+ New customer group</a>
                                <div class="form-group warning">
                                    <label for="warning">Warning</label>
                                    <textarea name="warning" id="warning" cols="30" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="footer">
                                <button type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal" id="editCustomerModal">
                <div class="customer-update">
                    <div class="window">
                        <div class="header">
                            <h2>Edit customer</h2>
                            <button class="closeModal" id="closeEditCustomerModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                        </div>
                        <form action="" id="customer-update">
                            @method('PATCH')
                            <div class="inner-form">
                                <h3>Personal information</h3>
                                <div class="form-group">
                                    <label for="first_name">First name</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control">
                                    <span id="update-first_name-error" class="error-message"></span>
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last name</label>
                                    <input type="text" id="last_name" name="last_name" class="form-control">
                                    <span id="update-last_name-error" class="error-message"></span>
                                </div>
                                <div class="form-group">
                                    <label for="date_of_birth">Date of birth</label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control">
                                    <span id="update-date_of_birth-error" class="error-message"></span>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <input type="file" id="photo" name="photo" class="form-control">
                                    <span id="update-photo-error" class="error-message"></span>
                                </div>
                                <div class="form-group radio">
                                    <label for="" class="group-label">Gender</label>
                                    <div class="radio-groups">
                                        <div class="radio-group">
                                            <input type="radio" name="gender" id="male" value="male">
                                            <label for="male">Male</label>
                                        </div>
                                        <div class="radio-group">
                                            <input type="radio" name="gender" id="female" value="female">
                                            <label for="female">Female</label>
                                        </div>
                                        <div class="radio-group">
                                            <input type="radio" name="gender" id="other" value="other">
                                            <label for="other">Other</label>
                                        </div>
                                    </div>
                                    <span id="update-gender-error" class="error-message"></span>
                                </div>
                                <h3>Other information</h3>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="email@velnes.mk">
                                    <span id="update-email-error" class="error-message"></span>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone number</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="+389">
                                    <span id="update-phone_number-error" class="error-message"></span>
                                </div>
                                <div class="form-group address">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" id="address" class="form-control">
                                    <span id="update-address-error" class="error-message"></span>
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" name="city" id="city" class="form-control">
                                    <span id="update-city-error" class="error-message"></span>
                                </div>
                                <div class="form-group">
                                    <label for="postal_code">Postal code</label>
                                    <input type="text" name="postal_code" id="postal_code" class="form-control">
                                    <span id="update-postal_code-error" class="error-message"></span>
                                </div>
                                <h3>Additional information</h3>
                                <div class="form-group">
                                    <label for="customer_groups">Customer groups</label>
                                    <select name="customer_groups" id="customer_groups" class="form-control">
                                        <option value="0">Select</option>
                                        @foreach($customerGroups as $group)
                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                    <span id="update-customer_groups-error" class="error-message"></span>
                                </div>
                                <a href="">+ New customer group</a>
                                <div class="form-group warning">
                                    <label for="warning">Warning</label>
                                    <textarea name="warning" id="warning" cols="30" rows="3" class="form-control"></textarea>
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
@endsection
@section('scripts')
    @vite(['resources/js/customers.js'])
@endsection
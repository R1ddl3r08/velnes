@extends('layouts.app')
@section('title', 'Reports')
@section('page-name')
    <h1 id="calendarTitle">Reports</h1>
@endsection
@section('reportsActive', 'active')
@section('content')
    <div class="reports">
        <div class="reports-nav">
            <button id="reportsTotalsButton" class="active">Totals</button>
            <button id="reportsDailyButton">Daily</button>
            <button id="reportsMonthlyButton">Monthly</button>
            <button id="reportsServicesButton">Services</button>
            <button id="reportsProductsButton">Products</button>
            <button id="reportsEmployeesButton">Employees</button>
            <button id="reportsVATButton">VAT</button>
        </div>
        <div class="totals">
            <div class="actions">
                <div class="left-div">
                    <select name="interval" id="interval" class="form-control">
                        <option value="0">Today</option>
                    </select>
                </div>
                <div class="right-div">
                    <select name="export" id="export" class="form-control">
                        <option value="0">Export</option>
                    </select>
                    <button>Print</button>
                </div>
            </div>
            <div class="stats">
                <div class="stat-card invoices">
                    <p>invoices</p>
                    <p class="number">14</p>
                </div>
                <div class="stat-card appointments">
                    <p>appointments</p>
                    <p class="number">14</p>
                </div>
                <div class="stat-card new-customers">
                    <p>New customers</p>
                    <p class="number">2</p>
                </div>
            </div>
            <div class="totals-methods">
                <div class="card totals">
                    <div class="header">
                        <p>Totals</p>
                    </div>
                    <div class="row">
                        <p>Total revenue</p>
                        <p>$0.00</p>
                    </div>
                    <div class="row">
                        <p>Total revenue incl. VAT</p>
                        <p>$0.00</p>
                    </div>
                    <div class="row">
                        <p>Revenue products</p>
                        <p>$0.00</p>
                    </div>
                    <div class="row">
                        <p>Revenue services</p>
                        <p>$0.00</p>
                    </div>
                    <div class="row">
                        <p>Gift cards sold</p>
                        <p>$0.00</p>
                    </div>
                    <div class="row">
                        <p>Revenue packages</p>
                        <p>$0.00</p>
                    </div>
                    <div class="row">
                        <p>Revenue memberships</p>
                        <p>$0.00</p>
                    </div>
                    <div class="row">
                        <p>Total discounts</p>
                        <p>$0.00</p>
                    </div>
                    <div class="row">
                        <p>Drawer transactions</p>
                        <p>$0.00</p>
                    </div>
                </div>
                <div class="card payment-methods">
                    <div class="header">
                        <p>Payment methods</p>
                    </div>
                    <div class="row">
                        <p>Cash</p>
                        <p>$0.00</p>
                    </div>
                    <div class="row">
                        <p>Debit</p>
                        <p>$0.00</p>
                    </div>
                    <div class="row">
                        <p>Credit card</p>
                        <p>$0.00</p>
                    </div>
                    <div class="row">
                        <p>Bank transfer</p>
                        <p>$0.00</p>
                    </div>
                    <div class="row">
                        <p>Online</p>
                        <p>$0.00</p>
                    </div>
                    <div class="row">
                        <p>Coupon</p>
                        <p>$0.00</p>
                    </div>
                    <div class="row">
                        <p>Gift card</p>
                        <p>$0.00</p>
                    </div>
                    <div class="row">
                        <p>Prepaid card</p>
                        <p>$0.00</p>
                    </div>
                    <div class="row">
                        <p>Outstanding</p>
                        <p>$0.00</p>
                    </div>
                </div>
            </div>
            <div class="card vat">
                <div class="header">
                    <p>VAT</p>
                </div>
                <div class="row">
                    <p>Total VAT</p>
                    <p>$0.00</p>
                </div>
                <div class="row">
                    <p>Base 20%</p>
                    <p>$0.00</p>
                </div>
                <div class="row">
                    <p>VAT 20%</p>
                    <p>$0.00</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection
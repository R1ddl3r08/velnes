<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\Employee;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $appointments = Appointment::with(['service', 'employee'])->whereDate('date_time', $today)->get();
        $employees = Employee::get();

        $todayAppointments = Appointment::whereDate('date_time', today())->get();
        $uniqueEmployeeIds = $todayAppointments->pluck('employee_id')->unique();
        $workingToday = [];

        foreach ($uniqueEmployeeIds as $employeeId) {
            $employeeAppointments = $todayAppointments->where('employee_id', $employeeId);
            
            $totalAppointments = $employeeAppointments->count();
            $workingHoursStart = $employeeAppointments->min('date_time');
            $workingHoursEnd = $employeeAppointments->max(function ($appointment) {
                return Carbon::parse($appointment->date_time)->addMinutes($appointment->duration);
            });

            $workingToday[] = [
                'employee' => Employee::find($employeeId),
                'totalAppointments' => $totalAppointments,
                'workingHoursStart' => Carbon::parse($workingHoursStart)->format('H:i'),
                'workingHoursEnd' => Carbon::parse($workingHoursEnd)->format('H:i'),
            ];
        }

        return view('dashboard', compact('appointments', 'workingToday', 'employees'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Room;
use App\Models\Tool;
use App\Models\Customer;

class CalendarController extends Controller
{
    public function index()
    {
        $employees = Employee::get();
        $services = Service::get();
        $rooms = Room::get();
        $tools = Tool::get();
        $customers = Customer::get();
        return view('calendar', compact('employees', 'services', 'rooms', 'tools', 'customers'));
    }

    public function getAppointments($date, $range, $employees)
    {
        $selectedDate = Carbon::parse($date);
    
        if ($range == 'week') {
            $startOfWeek = $selectedDate->startOfWeek();

            $uniqueDays = collect(range(0, 6))->map(function ($dayOffset) use ($startOfWeek) {
                return $startOfWeek->copy()->addDays($dayOffset)->format('D d');
            });
    
            if ($employees == 0) {
                $appointments = Appointment::with('employee')
                    ->where('date_time', '>=', $startOfWeek)
                    ->where('date_time', '<', $startOfWeek->copy()->addDays(7))
                    ->get();
            } else {
                $appointments = Appointment::with('employee')
                    ->where('employee_id', $employees)
                    ->where('date_time', '>=', $startOfWeek)
                    ->where('date_time', '<', $startOfWeek->copy()->addDays(7))
                    ->get();
            }
    
            // Retrieve unique employees for the week
            $appointments = $this->processAppointments($appointments);
            $uniqueEmployees = $appointments->pluck('employee')->unique('id')->values();
        } elseif ($range == 'day') {
            // Retrieve unique day for the day
            $uniqueDays = [$selectedDate->format('D d')];
    
            if ($employees == 0) {
                $appointments = Appointment::with('employee')
                    ->whereDate('date_time', $selectedDate->toDateString())
                    ->get();
            } else {
                $appointments = Appointment::with('employee')
                    ->where('employee_id', $employees)
                    ->whereDate('date_time', $selectedDate->toDateString())
                    ->get();
            }
    
            // Retrieve unique employees for the day
            $appointments = $this->processAppointments($appointments);
            $uniqueEmployees = $appointments->pluck('employee')->unique('id')->values();
        }
    
        // Prepare the data to be sent as JSON
        $responseData = [
            'appointments' => $appointments,
            'employees' => $uniqueEmployees,
            'days' => $uniqueDays,
        ];
    
        return response()->json($responseData, 200);
    }

    public function processAppointments($appointments)
    {
        return $appointments->map(function ($appointment) {
            $appointmentStart = Carbon::createFromFormat('Y-m-d H:i:s', $appointment->date_time, 'UTC');

            $durationInSlots = ceil($appointment->duration / 15) + 1;

            return [
                'id' => $appointment->id,
                'date_time' => $appointmentStart->format('Y-m-d H:i:s'),
                'duration' => $appointment->duration,
                'employee' => [
                    'id' => $appointment->employee->id,
                    'name' => $appointment->employee->name,
                    // Add other employee attributes as needed
                ],
                'service' => [
                    'id' => $appointment->service->id,
                    'name' => $appointment->service->name,
                    'category' => [
                        'id' => $appointment->service->category->id,
                        'name' => $appointment->service->category->name,
                        'color' => $appointment->service->category->color,
                    ],
                ],
                'customer' => [
                    'id' => $appointment->customer->id,
                    'name' => $appointment->customer->first_name,
                ],
                'startHour' => $appointmentStart->format('H'),
                'startMinute' => $appointmentStart->format('i'),
                'durationInSlots' => $durationInSlots,
                // Add other appointment attributes as needed
            ];
        });
    }

    
}    

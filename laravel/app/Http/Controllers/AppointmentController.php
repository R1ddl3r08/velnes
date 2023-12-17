<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function getAppointmentsByEmployee(Request $request)
    {
        $employeeId = $request->input('employeeId');

        if ($employeeId == 0) {
            $appointments = Appointment::whereDate('date_time', today())->get();
        } else {
            $appointments = Appointment::where('employee_id', $employeeId)->whereDate('date_time', today())->get();
        }

        $formattedAppointments = $appointments->map(function ($appointment) {
            return [
                'start_time' => Carbon::parse($appointment->date_time)->format('H:i'),
                'end_time' => Carbon::parse($appointment->date_time)->addMinutes($appointment->duration)->format('H:i'),
                'photo_url' => $appointment->employee->photo_url ? asset('storage/' . $appointment->employee->photo_url) : null,
                'employee_name' => $appointment->employee->name,
                'service_name' => $appointment->service->name,
            ];
        });

        return response()->json($formattedAppointments);
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'service' => 'required|numeric|exists:services,id',
            'duration' => 'required|numeric|not_in:0',
            'employee' => 'required|numeric|exists:employees,id',
            'room' => 'required|numeric|exists:rooms,id',
            'tool1' => 'required|numeric|exists:tools,id',
            'tool2' => 'nullable|numeric|exists:tools,id',
            'date' => 'required|date',
            'time' => 'required',
            'customer' => 'required|numeric|exists:customers,id',
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
        
        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->input('date') . ' ' . $request->input('time'));


        $appointment = Appointment::create([
            'service_id' => $request->input('service'),
            'employee_id' => $request->input('employee'),
            'customer_id' => $request->input('customer'),
            'tool_1_id' => $request->input('tool1'),
            'tool_2_id' => $request->input('tool2'),
            'room_id' => $request->input('room'),
            'duration' => $request->input('duration'),
            'date_time' => $dateTime,
            // 'note' => $request->input('note'),
        ]);
    
        return response()->json(['message' => 'Appointment created successfully', 'appointment' => $appointment], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'service' => 'required|numeric|exists:services,id',
            'duration' => 'required|numeric|not_in:0',
            'employee' => 'required|numeric|exists:employees,id',
            'room' => 'required|numeric|exists:rooms,id',
            'tool1' => 'required|numeric|exists:tools,id',
            'tool2' => 'nullable|numeric|exists:tools,id',
            'date' => 'required|date',
            'time' => 'required',
            'customer' => 'required|numeric|exists:customers,id',
            'note' => 'nullable|string',
        ]);

        // $response = [$request->input('date'), $request->input('time')];
        // return response()->json($response, 400);
    
        $dateTime = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('date') . ' ' . $request->input('time'));
    
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
    
        $appointment = Appointment::find($id);
    
        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }
    
        $updateData = [
            'service_id' => $request->input('service'),
            'employee_id' => $request->input('employee'),
            'customer_id' => $request->input('customer'),
            'tool_1_id' => $request->input('tool1'),
            'tool_2_id' => $request->input('tool2'),
            'room_id' => $request->input('room'),
            'duration' => $request->input('duration'),
            'date_time' => $dateTime,
            // 'note' => $request->input('note'),
        ];
    
        $appointment->update($updateData);
    
        return response()->json(['message' => 'Appointment updated successfully', 'appointment' => $appointment], 200);
    }
    


    public function appointment($id)
    {
        $appointment = Appointment::with('employee', 'service', 'customer')->find($id);

        if (!$appointment) {
            return response()->json('Appointment not found', 404);
        }

        return response()->json($appointment, 200);
    }

    public function delete($id)
    {
        $appointment = Appointment::find($id);

        if(!$appointment){
            return response()->json('Appointment not found', 400);
        }

        $appointment->delete();
        return response()->json('Appointment deleted successfully', 200);
    }
}

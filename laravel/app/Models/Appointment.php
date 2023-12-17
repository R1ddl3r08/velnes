<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $guarded = [];
    
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function tool1()
    {
        return $this->belongsTo(Tool::class, 'tool_1_id');
    }

    public function tool2()
    {
        return $this->belongsTo(Tool::class, 'tool_2_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}

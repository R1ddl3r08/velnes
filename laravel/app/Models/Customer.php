<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function groups()
    {
        return $this->belongsToMany(CustomerGroup::class, 'customers_groups', 'customer_id', 'customer_group_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}

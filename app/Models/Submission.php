<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Submission extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    public function routeNotificationForMail($notification)
    {
        // Return email address and name...
        return [$this->patient->email => $this->patient->name];
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}

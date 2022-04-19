<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientInformation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function patient()
    {
        $this->belongsTo(User::class, 'patient_id');
    }
}

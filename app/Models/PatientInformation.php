<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientInformation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'patient_information';

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}

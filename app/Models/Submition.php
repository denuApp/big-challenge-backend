<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submition extends Model
{
    use HasFactory;

    public function patient (){
        return $this->belongsTo(User::class);
    }

    public function doctors (){
        return $this->belongsTo(User::class);
    }
}

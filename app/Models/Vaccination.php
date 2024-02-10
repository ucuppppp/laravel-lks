<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;

    public $timestamps = \false;

    protected $fillable = ['dose', 'date', 'society_id', 'spot_id', 'vaccine_id', 'doctor_id', 'officer_id'];

}

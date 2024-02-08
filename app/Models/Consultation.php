<?php

namespace App\Models;


use App\Models\Medical;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consultation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];
    protected $fillable = ['society_id', 'doctor_id', 'status', 'disease_history', 'current_symptoms', 'doctor_notes'];

    public function medical(): BelongsTo
    {
        return $this->belongsTo(Medical::class, 'doctor_id');
    }


}

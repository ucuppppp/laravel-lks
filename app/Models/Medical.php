<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medical extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = ['spot_id', 'user_id', 'role', 'name'];

    /**
     * Get the consultant that owns the Medical
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctorConsultant(): HasMany
    {
        return $this->hasMany(Consultation::class, 'user_id', 'doctor_id');
    }

}

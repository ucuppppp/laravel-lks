<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpotVaccine extends Model
{
    use HasFactory;

    /**
     * Get the vaccine that owns the SpotVaccine
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vaccine(): BelongsTo
    {
        return $this->belongsTo(Vaccine::class);
    }

}

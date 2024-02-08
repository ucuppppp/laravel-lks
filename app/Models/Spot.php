<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Spot extends Model
{
    use HasFactory;

    protected $fillable = ['regional_id', 'name', 'address', 'serve', 'capacitys'];

    /**
     * Get all of the comments for the Spot
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */


    /**
     * Get all of the spots for the Spot
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spot_vaccines(): HasMany
    {
        return $this->hasMany(SpotVaccine::class);
    }

    public function regional(): BelongsTo
    {
        return $this->belongsTo(Regional::class, 'regional_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Society extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ["id_card_number", "password", "name", "born_date", "gender", "address", "regional_id", "login_tokens"];

    /**
     * Get the user that owns the Society
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regional(): BelongsTo
    {
        return $this->belongsTo(Regional::class);
    }

    public function getToken(){
        return $this->login_tokens;
    }

}

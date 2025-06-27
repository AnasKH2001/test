<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photography extends Model
{
    protected $table = 'photography'; // Prevents Laravel from looking for 'photographies'

    protected $fillable = [
        'service_id',
        'description',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}

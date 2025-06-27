<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Food extends Model
{
    protected $table = 'food';

    protected $fillable = [
        'service_id',
        'description',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Music extends Model
{
    protected $table = 'music'; // Laravel would expect 'musics' otherwise

    protected $fillable = [
        'service_id',
        'description',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    //
    protected $fillable = [
        'service_type',
        'provider_id',
        'description',
        'cost',
    ];
   

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function food() { return $this->hasOne(Food::class); }
    public function venue() { return $this->hasOne(Venue::class); }
    public function music() { return $this->hasOne(Music::class); }
    public function photography() { return $this->hasOne(Photography::class); }


    
}

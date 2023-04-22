<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'origin',
        'destination',
        'destination_name',
        'driver_location',
        'is_started',
        'is_complete'
    ];

    protected $casts = [
      'origin' => 'array',
      'destination' => 'array'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function driver() {
        return $this->belongsTo(Driver::class);
    }
}

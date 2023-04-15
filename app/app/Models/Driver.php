<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [

    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function trips() {
        return $this->hasMany(Trip::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    protected $fillable = ['name', 'registration'];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}

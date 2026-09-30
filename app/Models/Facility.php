<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
    protected $fillable = ['name', 'category', 'location', 'capacity', 'status', 'description'];

    protected function casts(): array
    {
        return ['capacity' => 'integer'];
    }

    public function scopeReservable($query)
    {
        return $query->whereIn('status', ['Available', 'Limited']);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}

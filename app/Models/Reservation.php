<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    public const STATUSES = ['Pending', 'Approved', 'Rejected', 'Completed', 'Cancelled'];

    protected $fillable = [
        'user_id', 'facility_id', 'equipment_id', 'quantity', 'date', 'time_slot', 'purpose', 'organization', 'status',
    ];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function scopeStatus($query, string|array $status)
    {
        return $query->whereIn('status', (array) $status);
    }
}

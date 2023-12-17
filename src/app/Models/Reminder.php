<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reminder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'remind_at',
        'event_at',
    ];

    protected $casts = [
        'remind_at' => 'datetime',
        'event_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUpcomingEvent($query)
    {
        return $query->where('event_at', '>', now());
    }

    public function scopeDueRemind($query)
    {
        return $query->where('remind_at', '<=', now());
    }
}

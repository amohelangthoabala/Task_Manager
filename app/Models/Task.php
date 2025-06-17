<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'status',
        'start_date',
        'end_date',
    ];

    // Define the possible statuses as constants for easy reuse
    public const STATUS_PENDING = 'pending';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_DEFERRED = 'deferred';
    public const STATUS_REJECTED = 'rejected';

    // Optionally, you can provide an array of valid statuses
    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_ACTIVE,
            self::STATUS_COMPLETED,
            self::STATUS_DEFERRED,
            self::STATUS_REJECTED,
        ];
    }

    // Relationship: Task belongs to a User (assigned user)
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}

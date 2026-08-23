<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateAutomationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_running',
        'target_category',
        'start_time',
        'active_days',
        'interval_minutes',
    ];

    protected $casts = [
        'is_running' => 'boolean',
        'active_days' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

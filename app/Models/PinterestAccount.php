<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinterestAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_name',
        'username',
        'access_token',
        'board_id',
        'board_name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(AffiliatePostLog::class, 'account_id');
    }
}

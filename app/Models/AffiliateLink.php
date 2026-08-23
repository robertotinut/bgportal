<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shopee_url',
        'affiliate_url',
        'product_title',
        'category',
        'product_image',
        'promo_image',
        'pin_title',
        'pin_description',
        'status',
        'scheduled_at',
        'posted_at',
        'error_message',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'posted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(AffiliatePostLog::class, 'affiliate_link_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliatePostLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'affiliate_link_id',
        'pin_id',
        'status',
        'message',
        'posted_at',
    ];

    protected $casts = [
        'posted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(PinterestAccount::class, 'account_id');
    }

    public function link()
    {
        return $this->belongsTo(AffiliateLink::class, 'affiliate_link_id');
    }
}

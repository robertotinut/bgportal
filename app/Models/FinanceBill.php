<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wallet_id',
        'name',
        'category',
        'amount',
        'due_day',
        'due_date',
        'status',
        'last_paid_at',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'last_paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(FinanceWallet::class, 'wallet_id');
    }
}

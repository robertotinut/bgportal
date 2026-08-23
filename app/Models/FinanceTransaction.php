<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wallet_id',
        'budget_id',
        'type',
        'amount',
        'contributor_name',
        'category',
        'description',
        'transaction_date',
    ];

    protected $casts = [
        'transaction_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(FinanceWallet::class, 'wallet_id');
    }

    public function budget()
    {
        return $this->belongsTo(FinanceBudget::class, 'budget_id');
    }
}

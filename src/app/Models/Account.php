<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'opening_balance',
        'status',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getBalanceAttribute()
    {
        $income = $this->transactions()->where('type', 'income')->sum('amount');
        $expense = $this->transactions()->where('type', 'expense')->sum('amount');
        
        // Outgoing transfers (from this account to another)
        $outgoingTransfer = $this->transactions()
            ->where('type', 'transfer')
            ->where('account_id', $this->id)
            ->sum('amount');
            
        // Incoming transfers (from another account to this account)
        $incomingTransfer = Transaction::where('type', 'transfer')
            ->where('transfer_to_account_id', $this->id)
            ->sum('amount');
            
        return $this->opening_balance + $income - $expense - $outgoingTransfer + $incomingTransfer;
    }
}

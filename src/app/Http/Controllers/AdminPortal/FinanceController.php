<?php

namespace App\Http\Controllers\AdminPortal;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FinanceController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        // Account Balances
        $accounts = Account::all();

        // Metrics
        $todayIncome = Transaction::where('type', 'income')->where('transaction_date', $today)->sum('amount');
        $todayExpense = Transaction::where('type', 'expense')->where('transaction_date', $today)->sum('amount');

        $monthIncome = Transaction::where('type', 'income')->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])->sum('amount');
        $monthExpense = Transaction::where('type', 'expense')->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])->sum('amount');

        $recentTransactions = Transaction::with(['account', 'category', 'client'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin_portal.finance.index', compact(
            'accounts', 
            'todayIncome', 'todayExpense', 
            'monthIncome', 'monthExpense', 
            'recentTransactions'
        ));
    }

    public function storeTransfer(Request $request)
    {
        $validated = $request->validate([
            'from_account_id' => 'required|exists:accounts,id|different:to_account_id',
            'to_account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        $fromAccount = Account::findOrFail($validated['from_account_id']);
        $toAccount = Account::findOrFail($validated['to_account_id']);

        if ($fromAccount->balance < $validated['amount']) {
            return back()->withErrors(['amount' => 'Insufficient funds in the source account. Current balance is ' . number_format($fromAccount->balance, 2) . ' ৳']);
        }

        $transaction = Transaction::create([
            'account_id' => $fromAccount->id,
            'transfer_to_account_id' => $toAccount->id,
            'type' => 'transfer',
            'amount' => $validated['amount'],
            'reference' => $validated['reference'],
            'description' => $validated['description'] ?? "Transfer from {$fromAccount->name} to {$toAccount->name}",
            'transaction_date' => $validated['transaction_date'],
            'created_by' => auth()->id(),
        ]);

        ActivityLog::log('finance_transfer', "Transferred {$validated['amount']} ৳ from account '{$fromAccount->name}' to '{$toAccount->name}'", $transaction);

        return redirect()->route('finance.index')->with('success', 'Funds transferred successfully.');
    }
}

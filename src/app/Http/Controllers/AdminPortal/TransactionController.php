<?php

namespace App\Http\Controllers\AdminPortal;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\TransactionCategory;
use App\Models\Client;
use App\Models\Project;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['account', 'category', 'client', 'project']);

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('account_id')) {
            $query->where('account_id', $request->input('account_id'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->input('client_id'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('description', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%");
        }

        $transactions = $query->latest('transaction_date')->latest('id')->paginate(15);

        $accounts = Account::all();
        $categories = TransactionCategory::where('status', 'active')->get();
        $clients = Client::all();

        return view('admin_portal.finance.transactions.index', compact('transactions', 'accounts', 'categories', 'clients'));
    }

    public function create(Request $request)
    {
        $type = $request->input('type', 'income'); // default to income
        $accounts = Account::where('status', 'active')->get();
        $categories = TransactionCategory::where('type', $type)->where('status', 'active')->get();
        $clients = Client::where('status', 'active')->get();
        $projects = Project::where('status', 'active')->get();

        return view('admin_portal.finance.transactions.create', compact('type', 'accounts', 'categories', 'clients', 'projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:transaction_categories,id',
            'client_id' => 'nullable|exists:clients,id',
            'project_id' => 'nullable|exists:projects,id',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        $account = Account::findOrFail($validated['account_id']);

        // Check category type compatibility
        $category = TransactionCategory::findOrFail($validated['category_id']);
        if ($category->type !== $validated['type']) {
            return back()->withErrors(['category_id' => 'Selected category is not compatible with transaction type.'])->withInput();
        }

        // Check funds if expense
        if ($validated['type'] === 'expense' && $account->balance < $validated['amount']) {
            return back()->withErrors(['amount' => 'Insufficient funds in the selected account. Current balance is ' . number_format($account->balance, 2) . ' ৳'])->withInput();
        }

        $validated['created_by'] = auth()->id();
        $transaction = Transaction::create($validated);

        ActivityLog::log('transaction_created', "Admin created {$transaction->type} transaction of " . number_format($transaction->amount, 2) . " ৳ in account '{$account->name}'", $transaction);

        return redirect()->route('finance.transactions.index')->with('success', 'Transaction recorded successfully.');
    }

    public function edit(Transaction $transaction)
    {
        $accounts = Account::where('status', 'active')->get();
        $categories = TransactionCategory::where('type', $transaction->type)->where('status', 'active')->get();
        $clients = Client::where('status', 'active')->get();
        $projects = Project::where('status', 'active')->get();

        return view('admin_portal.finance.transactions.edit', compact('transaction', 'accounts', 'categories', 'clients', 'projects'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:transaction_categories,id',
            'client_id' => 'nullable|exists:clients,id',
            'project_id' => 'nullable|exists:projects,id',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        $account = Account::findOrFail($validated['account_id']);
        $category = TransactionCategory::findOrFail($validated['category_id']);

        if ($category->type !== $validated['type']) {
            return back()->withErrors(['category_id' => 'Selected category is not compatible with transaction type.'])->withInput();
        }

        // Check funds if expense, taking old transaction amount into account
        if ($validated['type'] === 'expense') {
            $currentBalance = $account->balance;
            if ($transaction->account_id === $account->id && $transaction->type === 'expense') {
                $currentBalance += $transaction->amount; // Add back previous amount
            }
            if ($currentBalance < $validated['amount']) {
                return back()->withErrors(['amount' => 'Insufficient funds in the selected account. Current balance is ' . number_format($currentBalance, 2) . ' ৳'])->withInput();
            }
        }

        $transaction->update($validated);

        ActivityLog::log('transaction_updated', "Admin updated transaction #{$transaction->id}: {$transaction->type} of " . number_format($transaction->amount, 2) . " ৳ in account '{$account->name}'", $transaction);

        return redirect()->route('finance.transactions.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        ActivityLog::log('transaction_deleted', "Admin deleted transaction #{$transaction->id}: {$transaction->type} of " . number_format($transaction->amount, 2) . " ৳ from account '{$transaction->account->name}'", $transaction);
        $transaction->delete();

        return redirect()->route('finance.transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}

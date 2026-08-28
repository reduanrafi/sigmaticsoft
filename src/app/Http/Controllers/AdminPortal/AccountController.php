<?php

namespace App\Http\Controllers\AdminPortal;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        return view('admin_portal.finance.accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('admin_portal.finance.accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:accounts,name',
            'type' => 'required|in:cash,bank,mobile_wallet',
            'opening_balance' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $account = Account::create($validated);

        ActivityLog::log('account_created', "Admin created financial account: {$account->name}", $account);

        return redirect()->route('finance.accounts.index')->with('success', 'Account created successfully.');
    }

    public function edit(Account $account)
    {
        return view('admin_portal.finance.accounts.edit', compact('account'));
    }

    public function update(Request $request, Account $account)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:accounts,name,' . $account->id,
            'type' => 'required|in:cash,bank,mobile_wallet',
            'opening_balance' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $account->update($validated);

        ActivityLog::log('account_updated', "Admin updated financial account: {$account->name}", $account);

        return redirect()->route('finance.accounts.index')->with('success', 'Account updated successfully.');
    }

    public function destroy(Account $account)
    {
        if ($account->transactions()->count() > 0) {
            return redirect()->route('finance.accounts.index')->with('error', 'Cannot delete account with existing transactions.');
        }

        ActivityLog::log('account_deleted', "Admin deleted financial account: {$account->name}", $account);
        $account->delete();

        return redirect()->route('finance.accounts.index')->with('success', 'Account deleted successfully.');
    }
}

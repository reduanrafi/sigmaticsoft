<?php

namespace App\Http\Controllers\AdminPortal;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\TransactionCategory;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $query = Transaction::whereBetween('transaction_date', [$startDate, $endDate]);

        if ($request->filled('account_id')) {
            $query->where('account_id', $request->input('account_id'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->input('client_id'));
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->input('project_id'));
        }

        $transactions = $query->with(['account', 'category', 'client', 'project'])->orderBy('transaction_date', 'asc')->get();

        // Calculate Totals
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $netProfit = $totalIncome - $totalExpense;

        // Group-wise Breakdowns
        // Category breakdown
        $categoryBreakdown = $transactions->where('type', 'expense')
            ->groupBy('category_id')
            ->map(function($items) {
                return [
                    'name' => $items->first()->category->name ?? 'Uncategorized',
                    'total' => $items->sum('amount')
                ];
            });

        // Client breakdown
        $clientBreakdown = $transactions->where('type', 'income')
            ->groupBy('client_id')
            ->map(function($items) {
                return [
                    'name' => $items->first()->client->company_name ?? 'Direct/No Client',
                    'total' => $items->sum('amount')
                ];
            });

        // Project breakdown
        $projectBreakdown = $transactions->where('type', 'income')
            ->groupBy('project_id')
            ->map(function($items) {
                return [
                    'name' => $items->first()->project->name ?? 'General Payment',
                    'total' => $items->sum('amount')
                ];
            });

        // Account balances
        $accountBalances = Account::all();

        // Filter lists
        $accounts = Account::all();
        $categories = TransactionCategory::all();
        $clients = Client::all();
        $projects = Project::all();

        return view('admin_portal.finance.reports', compact(
            'transactions', 'totalIncome', 'totalExpense', 'netProfit',
            'categoryBreakdown', 'clientBreakdown', 'projectBreakdown', 'accountBalances',
            'accounts', 'categories', 'clients', 'projects',
            'startDate', 'endDate'
        ));
    }
}

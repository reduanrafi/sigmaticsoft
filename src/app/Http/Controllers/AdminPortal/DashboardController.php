<?php

namespace App\Http\Controllers\AdminPortal;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\ClientRequest;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\ActivityLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        // Clients
        $totalClients = Client::count();
        $activeClients = Client::where('status', 'active')->count();

        // Projects
        $activeProjects = Project::whereIn('status', ['active', 'planning', 'on_hold'])->count();
        $completedProjects = Project::where('status', 'completed')->count();

        // Tasks
        $openTasks = Task::whereNotIn('status', ['completed', 'cancelled', 'rejected'])->count();
        $inProgressTasks = Task::where('status', 'in_progress')->count();
        $overdueTasks = Task::where('due_date', '<', $today)
            ->whereNotIn('status', ['completed', 'cancelled', 'rejected'])
            ->count();
        $completedThisMonth = Task::where('status', 'completed')
            ->whereBetween('completed_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->count();

        // Requests
        $newRequests = ClientRequest::where('status', 'submitted')->count();
        $pendingRequests = ClientRequest::whereIn('status', ['submitted', 'under_review'])->count();

        // Finance
        $todayIncome = Transaction::where('type', 'income')->where('transaction_date', $today)->sum('amount');
        $todayExpense = Transaction::where('type', 'expense')->where('transaction_date', $today)->sum('amount');

        $monthIncome = Transaction::where('type', 'income')->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])->sum('amount');
        $monthExpense = Transaction::where('type', 'expense')->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])->sum('amount');

        $totalBalance = Account::all()->sum('balance');

        // Recent lists
        $recentRequests = ClientRequest::with(['client', 'project'])->latest()->take(5)->get();
        $recentTaskUpdates = ActivityLog::where('action', 'like', 'task_%')
            ->with('user')
            ->latest()
            ->take(5)
            ->get();
        $recentTransactions = Transaction::with(['account', 'category', 'client'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin_portal.dashboard', compact(
            'totalClients', 'activeClients',
            'activeProjects', 'completedProjects',
            'openTasks', 'inProgressTasks', 'overdueTasks', 'completedThisMonth',
            'newRequests', 'pendingRequests',
            'todayIncome', 'todayExpense', 'monthIncome', 'monthExpense', 'totalBalance',
            'recentRequests', 'recentTaskUpdates', 'recentTransactions'
        ));
    }
}

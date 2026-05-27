<?php

namespace App\Http\Controllers;

use App\Enums\ExpenseStatus;
use App\Enums\ProjectStatus;
use App\Enums\PurchaseStatus;
use App\Models\Document;
use App\Models\Expense;
use App\Models\Material;
use App\Models\Project;
use App\Models\Purchase;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $monthStart = now()->startOfMonth();

        $projectsTotal = Project::count();
        $activeProjects = Project::where('status', ProjectStatus::InProgress)->count();
        $monthExpenses = Expense::where('status', ExpenseStatus::Approved)
            ->where('expense_date', '>=', $monthStart)
            ->sum('amount');

        $projectSpending = Project::query()
            ->withSum(['expenses as approved_total' => fn ($q) => $q->where('status', ExpenseStatus::Approved)], 'amount')
            ->orderByDesc('approved_total')
            ->limit(5)
            ->get();

        $lowStockMaterials = Material::where('is_active', true)
            ->whereColumn('current_stock', '<=', 'minimum_stock')
            ->orderBy('current_stock')
            ->limit(8)
            ->get();

        $pendingPurchases = Purchase::where('status', PurchaseStatus::Pending)->count();
        $recentExpenses = Expense::with(['project', 'category', 'registeredBy'])
            ->latest()
            ->limit(8)
            ->get();
        $recentDocuments = Document::with('uploader')
            ->latest()
            ->limit(8)
            ->get();

        return view('dashboard.index', compact(
            'projectsTotal',
            'activeProjects',
            'monthExpenses',
            'projectSpending',
            'lowStockMaterials',
            'pendingPurchases',
            'recentExpenses',
            'recentDocuments',
        ));
    }
}

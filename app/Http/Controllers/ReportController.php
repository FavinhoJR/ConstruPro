<?php

namespace App\Http\Controllers;

use App\Enums\ExpenseStatus;
use App\Models\Expense;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function expenses(Request $request): View
    {
        $from = $request->get('from', now()->startOfMonth()->toDateString());
        $to = $request->get('to', now()->toDateString());

        $byProject = Project::query()
            ->withSum(['expenses as total' => fn ($q) => $q
                ->where('status', ExpenseStatus::Approved)
                ->whereBetween('expense_date', [$from, $to])], 'amount')
            ->orderByDesc('total')
            ->get();

        $byCategory = Expense::query()
            ->selectRaw('expense_category_id, SUM(amount) as total')
            ->where('status', ExpenseStatus::Approved)
            ->whereBetween('expense_date', [$from, $to])
            ->with('category')
            ->groupBy('expense_category_id')
            ->get();

        return view('reports.expenses', compact('byProject', 'byCategory', 'from', 'to'));
    }
}

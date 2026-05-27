<?php

namespace App\Http\Controllers;

use App\Enums\ExpenseStatus;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Project;
use App\Models\Supplier;
use App\Services\DocumentStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function __construct(private readonly DocumentStorageService $documents) {}

    public function index(Request $request): View
    {
        $expenses = Expense::with(['project', 'category', 'supplier', 'registeredBy'])
            ->when($request->project_id, fn ($q, $id) => $q->where('project_id', $id))
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->when($request->expense_category_id, fn ($q, $id) => $q->where('expense_category_id', $id))
            ->when($request->from_date, fn ($q, $date) => $q->whereDate('expense_date', '>=', $date))
            ->when($request->to_date, fn ($q, $date) => $q->whereDate('expense_date', '<=', $date))
            ->latest('expense_date')
            ->paginate(15)
            ->withQueryString();

        return view('expenses.index', [
            'expenses' => $expenses,
            'projects' => Project::orderBy('name')->get(),
            'categories' => ExpenseCategory::orderBy('name')->get(),
            'statuses' => ExpenseStatus::options(),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Expense::class);

        return view('expenses.create', [
            'projects' => Project::orderBy('name')->get(),
            'categories' => ExpenseCategory::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
        ]);
    }

    public function store(StoreExpenseRequest $request): RedirectResponse
    {
        $expense = Expense::create([
            ...$request->safe()->except(['invoice_file']),
            'registered_by' => $request->user()->id,
            'status' => ExpenseStatus::Pending,
        ]);

        if ($request->hasFile('invoice_file')) {
            $this->documents->store(
                $request->file('invoice_file'),
                $expense,
                $request->user()->id,
                'factura',
                'expenses'
            );
        }

        return redirect()->route('expenses.index')->with('success', 'Gasto registrado.');
    }

    public function edit(Expense $expense): View
    {
        $this->authorize('update', $expense);

        return view('expenses.edit', [
            'expense' => $expense->load('documents'),
            'projects' => Project::orderBy('name')->get(),
            'categories' => ExpenseCategory::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateExpenseRequest $request, Expense $expense): RedirectResponse
    {
        $expense->update($request->safe()->except(['invoice_file']));

        if ($request->hasFile('invoice_file')) {
            $this->documents->store(
                $request->file('invoice_file'),
                $expense,
                $request->user()->id,
                'factura',
                'expenses'
            );
        }

        return redirect()->route('expenses.index')->with('success', 'Gasto actualizado.');
    }

    public function approve(Request $request, Expense $expense): RedirectResponse
    {
        $this->authorize('approve', $expense);

        $expense->update([
            'status' => ExpenseStatus::Approved,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'Gasto aprobado.');
    }

    public function reject(Request $request, Expense $expense): RedirectResponse
    {
        $this->authorize('approve', $expense);

        $request->validate(['rejection_reason' => ['required', 'string', 'max:500']]);

        $expense->update([
            'status' => ExpenseStatus::Rejected,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Gasto rechazado.');
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        $this->authorize('update', $expense);

        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Gasto eliminado.');
    }
}

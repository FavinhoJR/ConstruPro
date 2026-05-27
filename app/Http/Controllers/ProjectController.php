<?php

namespace App\Http\Controllers;

use App\Enums\ProjectStatus;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User;
use App\Services\DocumentStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function __construct(private readonly DocumentStorageService $documents) {}

    public function index(Request $request): View
    {
        $projects = Project::with('responsible')
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->when($request->search, fn ($q, $search) => $q->where(function ($query) use ($search) {
                $query->where('name', 'ilike', "%{$search}%")
                    ->orWhere('client', 'ilike', "%{$search}%");
            }))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('projects.index', [
            'projects' => $projects,
            'statuses' => ProjectStatus::options(),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Project::class);

        return view('projects.create', [
            'users' => User::where('is_active', true)->orderBy('name')->get(),
            'statuses' => ProjectStatus::options(),
        ]);
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $project = Project::create($request->safe()->except('documents'));

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $this->documents->store($file, $project, $request->user()->id, 'evidencia', 'projects');
            }
        }

        return redirect()->route('projects.show', $project)->with('success', 'Proyecto creado.');
    }

    public function show(Project $project, Request $request): View
    {
        $this->authorize('view', $project);

        $project->load([
            'responsible',
            'documents.uploader',
            'expenses.category',
            'expenses.supplier',
            'purchases.supplier',
            'inventoryMovements.material',
        ]);

        $tab = $request->get('tab', 'info');

        return view('projects.show', [
            'project' => $project,
            'tab' => $tab,
            'totalSpent' => $project->approvedExpensesTotal(),
            'statuses' => ProjectStatus::options(),
        ]);
    }

    public function edit(Project $project): View
    {
        $this->authorize('update', $project);

        return view('projects.edit', [
            'project' => $project,
            'users' => User::where('is_active', true)->orderBy('name')->get(),
            'statuses' => ProjectStatus::options(),
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update($request->validated());

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $this->documents->store($file, $project, $request->user()->id, 'evidencia', 'projects');
            }
        }

        return redirect()->route('projects.show', $project)->with('success', 'Proyecto actualizado.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->authorize('delete', $project);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Proyecto eliminado.');
    }
}

<?php

namespace App\Providers;

use App\Models\Expense;
use App\Models\Project;
use App\Models\User;
use App\Policies\ExpensePolicy;
use App\Policies\ProjectPolicy;
use App\Services\BrandingService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(BrandingService::class, fn () => new BrandingService());
    }

    public function boot(): void
    {
        Paginator::useTailwind();

        Gate::policy(Project::class, ProjectPolicy::class);
        Gate::policy(Expense::class, ExpensePolicy::class);

        Gate::define('manage-users', fn (User $user) => $user->canManageUsers());
        Gate::define('manage-inventory', fn (User $user) => $user->canManageInventory());
        Gate::define('manage-purchases', fn (User $user) => $user->canManageInventory());
        Gate::define('manage-suppliers', fn (User $user) => $user->hasRole(
            \App\Enums\RoleName::Admin,
            \App\Enums\RoleName::Manager,
            \App\Enums\RoleName::Warehouse,
            \App\Enums\RoleName::Accounting
        ));

        View::composer('*', function ($view): void {
            $view->with('branding', app(BrandingService::class)->current());
        });
    }
}

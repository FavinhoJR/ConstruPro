<?php

namespace App\Models;

use App\Enums\RoleName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function responsibleProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'responsible_id');
    }

    public function hasRole(RoleName|string ...$roles): bool
    {
        $names = collect($roles)->map(
            fn (RoleName|string $role) => $role instanceof RoleName ? $role->value : $role
        );

        return $names->contains($this->role?->name);
    }

    public function canApproveExpenses(): bool
    {
        return $this->hasRole(RoleName::Admin, RoleName::Manager, RoleName::Accounting);
    }

    public function canManageUsers(): bool
    {
        return $this->hasRole(RoleName::Admin);
    }

    public function canManageInventory(): bool
    {
        return $this->hasRole(RoleName::Admin, RoleName::Warehouse, RoleName::Manager);
    }
}

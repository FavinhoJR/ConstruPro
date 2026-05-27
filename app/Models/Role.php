<?php

namespace App\Models;

use App\Enums\RoleName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = ['name', 'label'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function matches(RoleName|string $role): bool
    {
        $name = $role instanceof RoleName ? $role->value : $role;

        return $this->name === $name;
    }
}

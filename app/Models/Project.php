<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'client',
        'description',
        'location',
        'start_date',
        'estimated_end_date',
        'status',
        'estimated_budget',
        'responsible_id',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'estimated_end_date' => 'date',
            'estimated_budget' => 'decimal:2',
            'status' => ProjectStatus::class,
        ];
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function approvedExpensesTotal(): float
    {
        return (float) $this->expenses()
            ->where('status', 'aprobado')
            ->sum('amount');
    }
}

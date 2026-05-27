<?php

namespace App\Http\Requests;

use App\Enums\InventoryMovementType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInventoryMovementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage-inventory');
    }

    public function rules(): array
    {
        return [
            'material_id' => ['required', 'exists:materials,id'],
            'type' => ['required', Rule::enum(InventoryMovementType::class)],
            'quantity' => ['required', 'numeric', 'min:0.001'],
            'project_id' => ['nullable', 'exists:projects,id'],
            'movement_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }
}

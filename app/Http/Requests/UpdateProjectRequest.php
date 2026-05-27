<?php

namespace App\Http\Requests;

use App\Enums\ProjectStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('project'));
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'client' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'estimated_end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', Rule::enum(ProjectStatus::class)],
            'estimated_budget' => ['required', 'numeric', 'min:0'],
            'responsible_id' => ['nullable', 'exists:users,id'],
            'documents' => ['nullable', 'array'],
            'documents.*' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'],
        ];
    }
}

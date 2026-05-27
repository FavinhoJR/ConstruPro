<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBrandingRequest;
use App\Services\BrandingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class BrandingController extends Controller
{
    public function __construct(private readonly BrandingService $brandingService) {}

    public function edit(): View
    {
        Gate::authorize('manage-users');

        return view('settings.branding', [
            'brandingSettings' => $this->brandingService->current(),
        ]);
    }

    public function update(UpdateBrandingRequest $request): RedirectResponse
    {
        Gate::authorize('manage-users');

        $data = $request->validated();

        $this->brandingService->update(
            data: $data,
            logo: $request->file('logo'),
            removeLogo: (bool) ($data['remove_logo'] ?? false),
        );

        return redirect()->route('settings.branding.edit')->with('success', 'Personalizacion actualizada.');
    }
}

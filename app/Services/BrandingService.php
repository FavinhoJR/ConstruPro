<?php

namespace App\Services;

use App\Models\CompanySetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class BrandingService
{
    private const CACHE_KEY = 'branding.current';

    public function current(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function (): array {
            $defaults = [
                'company_name' => config('branding.company_name'),
                'tagline' => config('branding.tagline'),
                'logo_url' => config('branding.logo_url'),
                'logo_path' => null,
                'footer_rights' => config('branding.footer_rights'),
                'footer_credit' => config('branding.footer_credit'),
            ];

            if (! Schema::hasTable('company_settings')) {
                return $defaults;
            }

            $setting = CompanySetting::query()->first();

            if (! $setting) {
                return $defaults;
            }

            return [
                'company_name' => $setting->company_name ?: $defaults['company_name'],
                'tagline' => $setting->tagline ?: $defaults['tagline'],
                'logo_url' => $setting->logo_path ? Storage::disk('public')->url($setting->logo_path) : $defaults['logo_url'],
                'logo_path' => $setting->logo_path,
                'footer_rights' => $defaults['footer_rights'],
                'footer_credit' => $defaults['footer_credit'],
            ];
        });
    }

    public function update(array $data, ?UploadedFile $logo = null, bool $removeLogo = false): CompanySetting
    {
        $setting = CompanySetting::query()->firstOrNew();

        $setting->fill([
            'company_name' => $data['company_name'],
            'tagline' => $data['tagline'] ?? null,
        ]);

        if ($removeLogo && $setting->logo_path) {
            Storage::disk('public')->delete($setting->logo_path);
            $setting->logo_path = null;
        }

        if ($logo) {
            if ($setting->logo_path) {
                Storage::disk('public')->delete($setting->logo_path);
            }

            $setting->logo_path = $logo->store('branding', 'public');
        }

        $setting->save();

        Cache::forget(self::CACHE_KEY);

        return $setting;
    }
}

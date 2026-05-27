<?php

namespace App\Services;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DocumentStorageService
{
    public function store(
        UploadedFile $file,
        Model $owner,
        int $userId,
        string $category = 'general',
        string $directory = 'documents'
    ): Document {
        $path = $file->store($directory, 'public');

        return $owner->documents()->create([
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getClientMimeType() ?? 'application/octet-stream',
            'size' => $file->getSize(),
            'category' => $category,
            'uploaded_by' => $userId,
        ]);
    }

    public function delete(Document $document): void
    {
        Storage::disk('public')->delete($document->path);
        $document->delete();
    }
}

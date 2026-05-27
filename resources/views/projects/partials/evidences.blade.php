<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse ($documents as $doc)
        <div class="bg-white rounded-xl border border-slate-200 p-4 text-sm">
            <p class="font-medium truncate">{{ $doc->original_name }}</p>
            <p class="text-slate-500 mt-1">{{ $doc->uploader->name }}</p>
            <a href="{{ $doc->url() }}" target="_blank" class="text-slate-700 underline mt-2 inline-block">Ver archivo</a>
        </div>
    @empty
        <p class="text-slate-500">Sin evidencias.</p>
    @endforelse
</div>

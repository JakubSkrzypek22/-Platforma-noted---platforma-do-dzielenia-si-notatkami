<a href="{{ route('notes.show', $note) }}" class="block">
    @if ($main && $main->file_type === 'image')
        <img src="{{ route('notes.preview', $note) }}" alt="{{ $note->title }}" class="w-full h-40 object-cover bg-slate-100 dark:bg-slate-800">
    @else
        <div class="w-full h-40 flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900 text-slate-400">
            <i class="bi bi-file-earmark-pdf text-4xl"></i>
        </div>
    @endif
</a>

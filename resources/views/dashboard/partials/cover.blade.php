<a href="{{ route('notes.show', $note) }}" class="block">
    @if ($main && $main->file_type === 'image')
        <img src="{{ route('notes.preview', $note) }}" alt="{{ $note->title }}" class="w-full h-40 object-cover object-top bg-slate-100 dark:bg-slate-800">
    @else
        <img src="{{ route('notes.cover', $note) }}" alt="{{ $note->title }}" class="w-full h-40 object-cover object-top bg-white">
    @endif
</a>

<div class="profile-card p-12 text-center {{ $extraClass ?? '' }}" @isset($id) id="{{ $id }}" @endisset>
    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-4">
        <i class="bi {{ $icon }} text-2xl text-slate-400"></i>
    </div>
    <h3 class="text-lg font-bold text-text-body mb-1">{{ $title }}</h3>
    <p class="text-slate-500 dark:text-slate-400 text-sm max-w-sm mx-auto mb-5">{{ $text }}</p>
    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-hover text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-colors">
        <i class="bi bi-grid-fill"></i> Przeglądaj katalog
    </a>
</div>
